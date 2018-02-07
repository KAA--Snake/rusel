<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\filter;


//use common\modules\catalog\models\Section;
use common\modules\catalog\models\search\searches\ProductsSearch;
use yii\base\Widget;
use yii\redis\Cache;

class CatalogFilter extends Widget
{
    public $perPage;
    public $options;
    public $cacheTime = 86000;

    public function init()
    {
        parent::init();

        //\Yii::$app->pr->print_r2($this->options);

        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {
        //$sectionModel = new Section();
        //$rootSections = $sectionModel->getRootSections();

        if(!is_numeric($this->options['sectionId']) || empty($this->options['sectionId'])){
            return false;
        }


        /** @var Cache $cache */
        $cache = \Yii::$app->cache;


        $totalFound = 0;

        $cacheKey = 'getFilterForSection'.$this->options['sectionId'];

        if (!$filterData = $cache->get($cacheKey)){
            //Получаем данные из таблицы (модель TagPost)

            $productSearchModel = new ProductsSearch();
            $filterDataForSection = $productSearchModel->getFilterDataForSectionId($this->options['sectionId']);

            if(isset($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets']) && is_array($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'])){
                $filterData = $filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'];

                $totalFound = $filterDataForSection['hits']['total'];
            }

            unset($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets']);


            foreach($filterData as &$oneFilter){
                //$key = md5($oneFilter['key']);
                $oneFilter['md_key'] = md5($oneFilter['key']);
                sort($oneFilter['sub_sub_aggr']['buckets']);

            }


            //Устанавливаем зависимость кеша от кол-ва записей в таблице
            //$dependency = new \yii\caching\DbDependency(['sql' => 'SELECT COUNT(*) FROM {{%tag_post}}']);
            $cache->set($cacheKey, $filterData, $this->cacheTime);
        }



        return $this->render('catalog_filter',
            [
                'totalFound' => $totalFound,
                'filterData' => $filterData,
                'perPage' => $this->perPage,
            ]);
    }
}