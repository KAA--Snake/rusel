<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.05.2017
 * Time: 16:37
 */

namespace common\models\mongo;


use yii\mongodb\ActiveRecord;

class Element extends ActiveRecord
{

    public static function getDb()
    {
        return \Yii::$app->get('db_mongo');
    }


    public static function collectionName(){
        return 'element';
    }

    public function rules(){
        return [
            [['id', 'name', 'quantity',], 'required'],
            [['id', 'quantity'], 'integer'],
            [['id'], 'unique'],
        ];
    }

    public function safeAttributes(){
        return[
            '_id',
            'id',
            'name',
            'quantity',
        ];
    }

    public function attributes(){
        return [
            '_id',
            'id',
            'name',
            'quantity',
        ];
    }

}