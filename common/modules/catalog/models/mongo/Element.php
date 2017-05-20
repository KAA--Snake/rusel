<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 12.05.2017
 * Time: 14:03
 */

namespace common\modules\catalog\models\mongo;


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

    /**
     *  $index like:
     *  [
     *   'name' => 1,
     *   'quantity' => 1,
     *   ]
     *
     * @param $index
     * @param $indexName
     */
    public function makeIndex($index, $indexName){

        self::getCollection()->createIndex([
            'key' => $index,
            'name' => $indexName
        ]);

        /* Element::getCollection()->createIndexes([
             [
                 'key' => [
                     'name' => 1,
                     'quantity' => 1,
                 ],
                 'name' => 'name_quantity_idx'
             ],
             [
                 'key' => [
                     'name' => 1,
                 ],
                 'name' => 'name_idx'
             ]
         ]);*/
    }


    /**
     * Test import
     */
    public function importData(){
        //\Faker
    }


}