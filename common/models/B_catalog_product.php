<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.05.2017
 * Time: 21:07
 */

namespace common\models;


use yii\db\ActiveRecord;
use common\models\B_iblock_element;

class B_catalog_product extends ActiveRecord
{

    public static function getDb() {
        //return \Yii::$app->db_postg;
        return \Yii::$app->db;
    }

    public static function tableName(){
        return 'b_catalog_product';
    }


    //соотносим с elements
    public function getBIblockElement(){
        return $this->hasOne(B_iblock_element::className(), ['ID' => 'ID']);
    }

}