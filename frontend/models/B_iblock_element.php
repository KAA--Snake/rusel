<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 12.04.2017
 * Time: 12:10
 */

namespace frontend\models;

use yii\db\ActiveRecord;
use frontend\models\queries\B_element_query;

class B_iblock_element extends ActiveRecord
{

    /**
     * Используем базу постгреса
     * @return mixed
     */
    public static function getDb() {
        return \Yii::$app->db_mysql;
    }

    public static function tableName(){
        //parent::tableName(); возвращает имя таблицы
        return 'b_iblock_element'; //можно вручную вернуть имя таблицы
    }

    /**
     * Переопределяем кастомным запросом
     * @return B_element_query
     */
    public static function find(){
        return new B_element_query(get_called_class());
    }

    //переопределим геттер для поля таблицы NAME
    public function getRemakeName(){
        return 'ПЕРЕОПРЕДЕЛЕНО !!! : ' . $this->NAME;
    }

    public function getSectionElements(){
        return $this->hasMany(B_iblock_section_element::className(),['IBLOCK_ELEMENT_ID'=>'ID']);
    }


    public function getSections(){
        return $this->hasMany(B_iblock_section::className(), ['ID' => 'IBLOCK_SECTION_ID'])->via('sectionElements');
    }



/*
    //связь с таблицей элементов B_iblock_section через промежуточную таблицу B_iblock_section_element
    public function getElementSection333(){
        return $this->hasMany(B_iblock_section::className(),
            ['ID'=>'IBLOCK_SECTION_ID'])->viaTable(B_iblock_section_element::className(), ['IBLOCK_ELEMENT_ID' => 'ID']);

    }






    public function getSection(){
        return $this->hasOne(B_iblock_section::className(), ['IBLOCK_SECTION_ID' => 'IBLOCK_SECTION_ID']);
    }

    public function getSection2(){
        return $this->hasOne(B_iblock_section_element::className(), ['IBLOCK_SECTION_ID' => 'IBLOCK_SECTION_ID']);
    }
*/
}