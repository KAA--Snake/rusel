<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 12.05.2017
 * Time: 14:03
 */

namespace common\modules\catalog\models\mongo;


use yii\mongodb\ActiveRecord;
use yii\mongodb\Exception;
use common\helpers\translit\Translit;

class Product extends ActiveRecord
{
    public static function getDb()
    {
        return \Yii::$app->get('db_mongo');
    }


    public static function collectionName(){
        return 'product';
    }

    public function rules(){
        return [
            [['id', 'name', 'code', 'artikul', 'status'], 'required'],
            [['id', 'section_id', 'status'], 'integer'],
            [['id'], 'unique'],
            [['sort'], 'default', 'value' => 100],
        ];
    }

    public function safeAttributes(){
        return[
            '_id',
            'id',
            'section_id',
            'status',
            'sort',
            'name',
            'code',
            'artikul',
            'ed_izmerenia',
            'product_logic',
            'properties',
            'other_properties',
            'prices',
            'quantity',
            'marketing',
        ];
    }

    public function attributes(){
        return [
            '_id',
            'id',
            'section_id',
            'status',
            'sort',
            'name',
            'code',
            'artikul',
            'ed_izmerenia',
            'product_logic',
            'properties',
            'other_properties',
            'prices',
            'quantity',
            'marketing',
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
     * Сохранение из парсера
     * @param $group
     */
    public function saveProduct(&$product){

        $product['code'] = str_ireplace(['/','\\'], '', $product['code']);

        /**
         * если не задан код, берем его транслитом
         */
        if(empty($product['code']) || $product['code'] == ''){
            $product['code'] = $product['name'];
            $product['code'] = Translit::t($product['code']);
        }

        //\Yii::$app->pr->print_r2($product);

        /**тестовый сброс */
       /* $selfProduct = new static();
        $selfProduct->deleteAll();
        \Yii::$app->db_mongo->getCollection('product')->drop();
        unset($selfProduct);*/

        $selfProduct = static::find()->andWhere(['id' => $product['id']])->one();

        if(!$selfProduct){
            $selfProduct = new static();
        }
        //var_dump($selfProduct->getAttributes());
        $selfProduct->setAttributes($product);

        try{
            $selfProduct->save();

        }catch (Exception $e){

            $error = '<br />' . $e->getMessage() . '<br />';
            Yii::$app->session->setFlash('error_'.intval($product['id']), $error);
        }



    }


}