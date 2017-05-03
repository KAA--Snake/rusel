<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.05.2017
 * Time: 18:59
 */

namespace common\models;


use common\models\ActiveQueries\Elements\B_iblock_element_query;
use common\models\B_catalog_product;
use yii\db\ActiveRecord;

class B_iblock_element extends ActiveRecord
{

    public static function getDb() {
        //return \Yii::$app->db_postg;
        return \Yii::$app->db;
    }


    public static function tableName(){
        //parent::tableName(); возвращает имя таблицы
        return 'b_iblock_element'; //можно вручную вернуть имя таблицы
    }
    public function getID(){
        return $this->ID;
    }

    /**
     * Расширяем запрос
     *
     * @return B_iblock_element_query
     */
    public static function find(){
        return new B_iblock_element_query(get_called_class());
    }


    //связь с продуктом для инфы по кол-ву
    public function getbCatalogProduct(){
        return $this->hasOne(B_catalog_product::className(), ['ID' => 'ID']);
    }


}