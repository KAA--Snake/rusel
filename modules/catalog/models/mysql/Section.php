<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 11.05.2017
 * Time: 18:57
 */

namespace modules\catalog\models\mysql;


use yii\db\ActiveRecord;

class Section extends ActiveRecord
{
    public static function tableName(){
        return 'section';
    }

}