<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 16.04.2017
 * Time: 9:15
 */

namespace frontend\models\queries;


use yii\db\ActiveQuery;

class B_element_query extends ActiveQuery
{
    public function isActive(){
        //здесь используется вместо устаревшего scope- условие для выборки
        return $this->andWhere(['b_iblock_element.ACTIVE' => 'Y']);
    }
}