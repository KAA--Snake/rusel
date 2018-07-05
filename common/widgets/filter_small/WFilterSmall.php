<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\filter_small;

use common\helpers\minifilter\MiniFilterHelper;
use yii\base\Widget;

class WFilterSmall extends Widget
{
    public $totalProductsFound;

    public function init()
    {
        parent::init();

        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {

	    $picked = MiniFilterHelper::getMiniFilterOption();

	    if($picked == ''){
	    	$picked = 'all';
	    }

        return $this->render('search', [
        	'totalProductsFound' => $this->totalProductsFound,
        	'picked' => $picked,

        ]);
    }
}