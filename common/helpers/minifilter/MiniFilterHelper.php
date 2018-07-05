<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.11.17
 * Time: 15:45
 */

namespace common\helpers\minifilter;


use common\modules\catalog\models\currency\Currency;
use Yii;

class MiniFilterHelper
{

    /**
     * selfnote
     *
     * @return bool
     */
    public static function getMiniFilterOption(){

	    $requestParams = '';

	    /*if(isset(Yii::$app->getRequest()->post()['msearch']) && !empty(Yii::$app->getRequest()->post()['msearch'])){
		    $searchQuery = Yii::$app->getRequest()->post()['msearch'];
	    }

	    if(isset(Yii::$app->getRequest()->get()['msearch']) && !empty(Yii::$app->getRequest()->get()['msearch'])){
		    $searchQuery = Yii::$app->getRequest()->get()['msearch'];
	    }*/


	    if(!empty(\Yii::$app->request->get('on_stores'))){
		    $requestParams = 'on_stores';

	    }

	    if(!empty(\Yii::$app->request->get('marketing'))){
		    $requestParams = 'marketing';

	    }

	    if(!empty(\Yii::$app->request->post('on_stores'))){
		    $requestParams = 'on_stores';

	    }

	    if(!empty(\Yii::$app->request->post('marketing'))){
		    $requestParams = 'marketing';

	    }



		return $requestParams;

    }


}