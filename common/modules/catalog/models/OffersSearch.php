<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.18
 * Time: 9:44
 */

namespace common\modules\catalog\models;

use yii\base\Model;

class OffersSearch extends Offers
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }



    public function searchByUrl($url){

        if(empty($url)) return false;

        return static::find()->andWhere([
            'url' => $url
        ])->one();
    }


}