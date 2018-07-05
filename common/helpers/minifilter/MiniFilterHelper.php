<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.11.17
 * Time: 15:45
 */

namespace common\helpers\minifilter;


use common\modules\catalog\models\currency\Currency;

class MiniFilterHelper
{

    /**
     * добавляет к товару текущую цену в пересчете на курс
     *
     * @param $product
     * @return bool
     */
    public static function getMiniFilterOption(&$requestParams){
		if(!empty($requestParams['on_stores'])){
			return true;
		}else if(!empty($requestParams['on_stores'])){
			return true;
		}

		if(!empty(\Yii::$app->request->get('on_stores'))){
			$requestParams['on_stores'] = 'y';
			return true;
		}else if(!empty(\Yii::$app->request->get('marketing'))){
			$requestParams['marketing'] = 'y';
			return true;
		}


		return false;
    }


}