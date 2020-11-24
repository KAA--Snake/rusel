<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.12.17
 * Time: 14:20
 */

namespace common\modules\catalog\models\search\searches;


use common\helpers\minifilter\MiniFilterHelper;
use common\models\CacheHelper;
use common\models\elasticsearch\Product;
use common\modules\catalog\models\elastic\Elastic;
use PHPUnit\Framework\Exception;
use Yii;
use yii\redis\Cache;
use common\modules\catalog\models\Section;

class StockProductsSearch extends ProductsSearch
{
    //отключаем ограничение по длине для поиска в http://rusel24.ru/stock_info_1
    function _isLengthIsGood($artikul){

        $catalogModule = Yii::$app->getModule('catalog');
        $searchConfig = $catalogModule->params['search'];

        if(strlen($artikul) < $searchConfig['min_search_length'] || strlen($artikul) > $searchConfig['max_search_length']) return false;

        return true;
    }

    /**
     * Ищет по нескольким полям (по условию ИЛИ)
     *
     * @param string $artikuls
     *
     * @return array
     */
    public function searchManual(string $searchString)
    {
        //пробрасывается в контроллер из Pagination_beh.php
        $pagination = \Yii::$app->controller->pagination;

        $resultData = [];

        $filterDataForSection = $this->getManualSearchFilteredProducts($searchString, []);

        $this->_setSingleStorageAsMulti($filterDataForSection);

        $this->_setSinglePriceAsMulty($filterDataForSection);

        //static::setAccessoriedProds($filterDataForSection);

        //$this->_clearProductsForMiniFilter($filterDataForSection);

        return $filterDataForSection;
    }

    /**
     * Отдает товары и фильтр по заданным параметрам, аналог getFilteredProducts ,
     * но без кеширования и с доп строкой поиска.
     *
     * Юзается при ручном поиске через строку поиска.
     *
     * @param $params
     * @return array|bool
     */
    private function getManualSearchFilteredProducts($searchString, $searchParams = []) {

        $productsFound = [];
        $must = [];
        $should = [];
        $terms = [];
        $logicalOperator = 'should';//should = OR, must = AND

        $pagination = \Yii::$app->controller->pagination;

        $filterData = [];

        /**  дефолтные данные по фильтрам TODO применить их в фильтре !*/
        //$filterData['quantity']['stock']['count'] = '> 0';
        //$filterData['properties']['proizvoditel'] = '';

        if(strlen($searchString) == 0){
            $productsFound = ['error' => 'пустой артикул !'];
            return $productsFound;
        }

        $additParamsMust = [];

        //убираем ВСЕ товары у которых ИД раздела = 0
        $emptySectionFilter = [
            "term"=> [
                "section_id"=> 0
            ]
        ];

        $additParamsMust['bool']['must_not'][] = $emptySectionFilter;

        $multiFields = [

            //пробуем найти по артикула без пробелов
            "artikul.wo_whitespaces",
            "artikul",

            "name.cyrillic_to_latinyc",
            "name.latinyc_to_cyrillic",

            //detail text
            //"properties.detail_text.cyrillic_to_latinyc",
            //"properties.detail_text.latinyc_to_cyrillic",

            //производитель
            //"properties.proizvoditel.cyrillic_to_latinyc",
            //"properties.proizvoditel.latinyc_to_cyrillic",

        ];

        if(!$this->_isLengthIsGood($searchString)) {
            throw new Exception('Длина поискового запроса не подходит под условия поиска (от 2 до 100 символов)');
        }

        //костыль- подставляем вместо пробелов +
        if (strpos($searchString, '+') !== false) {
            $searchString = $this->__whitespaceSubstitute($searchString);
        }

        $multyQueryArr = $this->_getMultyQuery($searchString);
        if (empty($multyQueryArr)) {
            throw new Exception('Произошла непредвиденная ошибка. Обратитесь к администратору сайта.');
        }

        //$multyQueryArr = $this->_replacedSymbolsQuery($multyQueryArr);
        //$multyQueryArr = $this->__hackForSpaceQuery($multyQueryArr);
        $multyQueryArr = $this->__addToQuery($multyQueryArr);

        //если в запросе есть знак +, значит это запрос на строгое И(AND)
        if (strpos($searchString, '+') !== false) {
            $logicalOperator = 'must';
            //костыль- добавляем поле только с цифрами для поиск с +...хз почему но это работает
            $multiFields[] = "search_data.only_digits";
        }

        $should['bool'] = [];
        foreach($multyQueryArr as $singleQuery) {
            $terms[] = [
                "multi_match"=> [
                    "operator"=> "and",
                    "query"=> $singleQuery,
                    "type"=> "phrase_prefix",
                    "fields"=> $multiFields
                    //'boost' => 2.0
                ]
            ];
        }

        $should['bool'][$logicalOperator] = $terms;

        $must[] = $should;

        if (!empty($additParamsMust)) {
            $must[] = $additParamsMust;
        }

        $params = [
            'body' => [
                'from' => $pagination['from'],
                'size' => $pagination['maxSizeCnt'],
                'sort' => [
                    //'_score' => ['order' => 'desc'],
                    'artikul' => ['order' => 'asc'],
                ],

                'query' => [
                    'bool'=> [
                        /** обязательный блок (для ИД раздела ) */
                        'must' => $must
                    ]
                ],
            ]
        ];

        $params = $this->productData + $params;

        $response = Elastic::getElasticClient()->search($params);

        return $response;
    }
}