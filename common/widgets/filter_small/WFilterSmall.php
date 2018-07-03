<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\filter_small;

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
	    $picked = 'all';

		if(!empty(\Yii::$app->request->post()['on_stores'])){
			$picked = 'on_stores';
		}else if(\Yii::$app->request->post()['marketing']){
			$picked = 'marketing';
		}

        return $this->render('search', [
        	'totalProductsFound' => $this->totalProductsFound,
        	'picked' => $picked,

        ]);
    }
}