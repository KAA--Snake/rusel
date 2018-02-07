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

class CatalogFilter extends Widget
{
    public $perPage;
    public $options;

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

        $filterData = [];

        if(!is_numeric($this->options['sectionId']) || empty($this->options['sectionId'])){
            return false;
        }

        $productSearchModel = new ProductsSearch();
        $filterDataForSection = $productSearchModel->getFilterDataForSectionId($this->options['sectionId']);

        if(isset($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets']) && is_array($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'])){
            $filterData = $filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'];
        }

        unset($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets']);


        foreach($filterData as &$oneFilter){
            //$key = md5($oneFilter['key']);
            $oneFilter['md_key'] = md5($oneFilter['key']);
            sort($oneFilter['sub_sub_aggr']['buckets']);

        }

        return $this->render('catalog_filter',
            [
                'totalFound' => $filterDataForSection['hits']['total'],
                'filterData' => $filterData,
                'perPage' => $this->perPage,
            ]);
    }
}