<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\filter;


//use common\modules\catalog\models\Section;
use common\helpers\translit\Translit;
use common\modules\catalog\models\search\searches\ProductsSearch;
use yii\base\Widget;
use yii\redis\Cache;

class CatalogFilter extends Widget
{
    public $perPage;
    public $options;
    public $cacheTime = 1; //TODO увеличить время кеширования

    public function init()
    {
        parent::init();

        //\Yii::$app->pr->print_r2($this->options);

        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {

        if(!is_numeric($this->options['sectionId']) || empty($this->options['sectionId'])){
            return false;
        }

        $searchParams = [
            'section_id' => $this->options['sectionId']
        ];

        /** При применении фильтра не кешируем @TODO может будем кешировать? */
        if( \Yii::$app->request->isPost){ //если был применен фильтр
            if( !empty( \Yii::$app->request->post('catalog_filter') ) ){

                \Yii::$app->pr->print_r2(\Yii::$app->request->post() );
                //die();

                $fakes = [
                    '_csrf-frontend',
                    'perPage',
                    'catalog_filter',
                ];
                foreach(\Yii::$app->request->post() as $k => $postData){
                    if(in_array($k, $fakes)) continue;

                    if(!is_integer($k)) continue;

                    if(empty($postData)) continue;

                    $searchParams['other_properties.property.id'] = $k;
                    $searchParams['other_properties.property.value'] = $postData;

                }


            }
        }



        //если не был применен фильтр, то сделаем полную выборку свойств по всему разделу
        $retData = $this->getAllFilterData($searchParams);


        return $this->render('catalog_filter', $retData);
    }



    public function getAllFilterData($searchParams){


        /** @var Cache $cache */
        $cache = \Yii::$app->cache;

        $totalFound = 0;

        $cacheKey = 'getFilterForSection'.$this->options['sectionId'];

        //if (!$filterData = $cache->get($cacheKey) || true){
        //Получаем данные из таблицы (модель TagPost)

        $productSearchModel = new ProductsSearch();

        $filterDataForSection = $productSearchModel->getFilterDataForSectionId($searchParams);

        if(isset($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets']) && is_array($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'])){
            //$filterData = $filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'];

            $totalFound = $filterDataForSection['hits']['total'];
        }


        foreach($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'] as &$oneFilter){

            $oneFilter['prop_name'] = $oneFilter['prop_name']['buckets'][0]['key'];
            $key = $oneFilter['key'];
            $filterData[$key] = $oneFilter;

            sort($oneFilter['prop_values']['buckets']);

        }

        unset($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets']);

        //Устанавливаем зависимость кеша от кол-ва записей в таблице
        //$dependency = new \yii\caching\DbDependency(['sql' => 'SELECT COUNT(*) FROM {{%tag_post}}']);
        //$cache->set($cacheKey, $filterData, $this->cacheTime);
        //}


        //\Yii::$app->pr->print_r2($filterData);

        /** сборка для уже выбранных параметров фильтра */
        //\Yii::$app->pr->print_r2($_POST);
        $appliedFilter = [];
        foreach ($_POST as $k=>$postData){
            if(empty($postData)) continue;

            if(isset($filterData[$k])){
                $appliedFilter[$k] = $postData;
            }

        }

        unset($_POST);

        \Yii::$app->pr->print_r2($appliedFilter);

        $appliedFilter = json_encode($appliedFilter, JSON_UNESCAPED_SLASHES);

        return
            [
                'totalFound' => $totalFound,
                'filterData' => $filterData,
                'perPage' => $this->perPage,
                'appliedFilterJson' => $appliedFilter
            ];
    }


}