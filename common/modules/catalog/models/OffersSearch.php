<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.18
 * Time: 9:44
 */

namespace common\modules\catalog\models;

use common\models\elasticsearch\Product;
use common\modules\catalog\models\search\searches\ProductsSearch;
use common\widgets\offers_substitution\OffersSubstitution;
use yii\base\Model;

class OffersSearch extends Offers
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    /**
     * Получает спецпредл по его УРЛ, и получает список товаров по артикулу либо по их ИД-ам
     *
     *
     * @param $url
     * @return array|bool
     */
    public function getProductsForOffer($url){

        if(empty($url)) return false;

        $products = [];
        $resultText = "";

        $oneOffer = static::find()->andWhere([
            'url' => $url
        ])->one();

        $result = [];
        $totalFound = 0;

        if($oneOffer){

            $result['offer'] = $oneOffer;

            $fullText = $oneOffer->full_text;
            $regexp = '/\{(\d+)\}/miu';

            preg_match_all($regexp,
                $fullText,
                $sortedProductIds, PREG_PATTERN_ORDER);

            if (count($sortedProductIds[1]) > 0)
            {
                $ids = array_values( array_unique($sortedProductIds[1], SORT_NUMERIC) );
                //\Yii::$app->pr->print_r2($ids);

                $neededStores = [];
                if(!empty($oneOffer->property_ids)){
                    $neededStores = explode(';', $oneOffer->property_ids);
                }
                $productMod = new ProductsSearch();
                $products = $productMod->getProductsByIds($ids, $neededStores);

                if(!empty($products['hits'])){

                    //составляем массив для подстановки
                    //$trans = array("{24994}" => "<b>SUBSTR ONE</b>", "{24995}" => "<b>SUBSTR TWO</b>", "hi" => "hello");
                    $substitutionArr = [];
                    foreach ($products['hits'] as $oneProduct) {
                        $substKey = '{'.$oneProduct['_source']['id'].'}';
                        $substValue = "ОШИБКА С ЗАМЕНОЙ {$oneProduct['_source']['id']}";
                        try {
                            $substValue = OffersSubstitution::widget([
                                'options' => [
                                    'product' => &$oneProduct
                                ],
                            ]);
                        } catch (\Exception $e) {
                        }

                        //$substValue = "subst {$oneProduct['_source']['id']}"; - тестовая проверка
                        $substitutionArr[$substKey] = $substValue;
                    }

                    $resultText = strtr($fullText, $substitutionArr);

                    $result['products'] = $products;
                    $totalFound = count($products['hits']);
                }
            }

            //\Yii::$app->pr->print_r2($oneOffer->getAttributes());

//            if(!empty($oneOffer->product_ids)){
//                $ids = explode(';', $oneOffer->product_ids);
//
//                $neededStores = [];
//                if(!empty($oneOffer->property_ids)){
//                    $neededStores = explode(';', $oneOffer->property_ids);
//                }
//                $productMod = new ProductsSearch();
//                $products = $productMod->getProductsByIds($ids, $neededStores);
//
//                if(!empty($products)){
//                    $result['products'] = $products;
//
//                    $totalFound = count($products);
//                }
//
//            }

        }


        //пробрасывается в контроллер из Pagination_beh.php
        $pagination = \Yii::$app->controller->pagination;
        $pagination['totalCount'] = $products['total'];

        return
            [
                'products' => $result,
                'totalProductsFound' => $products['total'],
                'resultText' => $resultText, //текст с подставленными товарами
                //'filterData' => $allFilterDataProps,
                //'appliedFilterJson' => $appliedFilter,
                'paginator' => $pagination,
                //'emptyFilterResult' => $this->isEmptyResult,
                //'filterManufacturers' => $allManufacturers,

            ];

    }


}