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
    public $cacheTime = 1;

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

        //if (!$filterData = $cache->get($cacheKey) || true){
            //Получаем данные из таблицы (модель TagPost)

            $productSearchModel = new ProductsSearch();
            $filterDataForSection = $productSearchModel->getFilterDataForSectionId($this->options['sectionId']);

            if(isset($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets']) && is_array($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'])){
                //$filterData = $filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'];

                $totalFound = $filterDataForSection['hits']['total'];
            }

            $filterData2 = [];
            foreach($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'] as &$oneFilter){
                //$key = md5($oneFilter['key']);
                //$oneFilter['md_key'] = md5($oneFilter['key']);
                $filterData[md5($oneFilter['key'])] = $oneFilter;

                sort($oneFilter['sub_sub_aggr']['buckets']);

            }

            unset($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets']);

            //Устанавливаем зависимость кеша от кол-ва записей в таблице
            //$dependency = new \yii\caching\DbDependency(['sql' => 'SELECT COUNT(*) FROM {{%tag_post}}']);
            $cache->set($cacheKey, $filterData, $this->cacheTime);
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

        //\Yii::$app->pr->print_r2($appliedFilter);

        $appliedFilter = json_encode($appliedFilter, JSON_UNESCAPED_SLASHES);

        return $this->render('catalog_filter',
            [
                'totalFound' => $totalFound,
                'filterData' => $filterData,
                'perPage' => $this->perPage,
                'appliedFilterJson' => $appliedFilter
            ]);
    }
}