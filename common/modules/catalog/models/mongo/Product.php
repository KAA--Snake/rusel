<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 12.05.2017
 * Time: 14:03
 */

namespace common\modules\catalog\models\mongo;


use common\modules\catalog\models\Section;
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
            [['url'], 'string'],
        ];
    }

    public function safeAttributes(){
        return[
            '_id',
            'id',
            'section_id',
            'url',
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
            'url',
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
     * @param $product
     * @internal param $group
     */
    public function saveProduct(&$product){

        $product['code'] = str_ireplace(['/','\\'], '', $product['code']);

        /**
         * если не задан код, берем его транслитом из артикула
         */
        if(empty($product['code']) || $product['code'] == ''){

            //если артикул есть
            if(!empty($product['artikul']) && $product['artikul'] != ''){
                $product['code'] = $product['artikul'];
            }else{
                //если артикула нет, делаем код из имени
                $product['code'] = $product['name'];
            }
            $product['code'] = Translit::t($product['code']);
        }

        /** сгенерим урл из урла раздела/урла товара */
        $product['url'] = $this->__generateUrl($product['code'], $product['section_id']);


        //\Yii::$app->pr->print_r2($product);

        /**тестовый сброс */
       /* $selfProduct = new static();
        $selfProduct->deleteAll();
        \Yii::$app->db_mongo->getCollection('product')->drop();
        u        if (Yii::$app->request->isPost) {
            return 'here';
        }nset($selfProduct);*/

        $selfProduct = static::find()->andWhere(['id' => $product['id']])->one();

        if(!$selfProduct){
            $selfProduct = new static();
        }
        //var_dump($selfProduct->getAttributes());
        $selfProduct->setAttributes($product);

        //\Yii::$app->pr->print_r2($product);

        try{

            $selfProduct->save();

        }catch (Exception $e){

            $error = '<br />' . $e->getMessage() . '<br />';
            Yii::$app->session->setFlash('error_'.intval($product['id']), $error);
        }



    }


    /**
     * Генерирует УРЛы для товаров и пишет их в соотв поле таблицы...надо ли ?
     *
     * @return bool
     */
    private function __generateUrl($productCode, $sectionUniqueId){
        $section = false; //первоначально раздела для товара нет

        if($sectionUniqueId > 0 && !empty($sectionUniqueId)){
            $section = Section::find()->andWhere(['unique_id' => $sectionUniqueId])->one();
        }else{
            //@TODO нет раздела для товара, значит сбрасываем его в корень кталога. Подумать как это реализовать!
        }

        /*echo '$section->url = ' . $section->url . '<br />';
        echo '$productCode = ' . $productCode . '<br />';
        echo 'URL = '.$section->url.$productCode.'/' . '<br />';*/

        if($section){
            //echo 'Уникальный ИД: '.$section->unique_id . '<br />';
            return $section->url.$productCode.'/';
        }else{
            //@TODO не найден такой раздела в каталоге для товара, сбрасываем товар в корень каталога

        }

        //если раздела не существует, то хотя бы генерим урл из кода
        return $productCode.'/';
    }



}