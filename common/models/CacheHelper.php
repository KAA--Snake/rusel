<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 13.07.2018
 * Time: 13:51
 */

namespace common\models;


class CacheHelper
{

    public static function getAdditionalCacheParamsFromRequest(){
        $cacheParams = [];

        //\Yii::$app->pr->print_r2(\Yii::$app->request->post());

        if(!empty(\Yii::$app->request->get('on_stores'))){
            $cacheParams['on_stores'] = \Yii::$app->request->get('on_stores');
        }

        if(!empty(\Yii::$app->request->get('marketing'))){
            $cacheParams['marketing'] = \Yii::$app->request->get('marketing');
        }


        /*if(!empty($cacheParams)){
            return md5(serialize($cacheParams));
        }else if(empty(\Yii::$app->request->post())){
            //если не выбраны пагинация НО и не выбран фильтр, то все же занесем в кеш
            return true;
        }*/

        return $cacheParams;
    }



}