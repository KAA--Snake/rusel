<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 12.04.2017
 * Time: 15:49
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class B_iblock_section extends ActiveRecord
{
    public static function tableName(){
        return 'b_iblock_section';
    }
}