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

        return $this->render('catalog_filter', $this->options);
    }



}