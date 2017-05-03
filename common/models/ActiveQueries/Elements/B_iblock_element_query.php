<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.05.2017
 * Time: 20:15
 */

namespace common\models\ActiveQueries\Elements;


use yii\db\ActiveQuery;

class B_iblock_element_query extends ActiveQuery
{

    public function isActive(){
        return $this->andWhere(['b_iblock_element.ACTIVE' => 'Y']);
    }
}