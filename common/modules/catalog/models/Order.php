<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.17
 * Time: 14:38
 */

namespace common\modules\catalog\models;


use yii\base\Model;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public $answer_var;
    public $fio;
    public $tel;
    public $email;
    public $org;
    public $delivery_var;
    public $delivery_city;
    public $delivery_contact_person;
    public $delivery_tel;
    public $delivery_address;
    public $order_comment;

    public $productIds;



    public function rules()
    {
        return [
            [['productIds'], 'required'],
            [[
                'answer_var',
                'fio',
                'tel',
                'email',
                'org',
                'delivery_var',
                'delivery_city',
                'delivery_contact_person',
                'delivery_tel',
                'delivery_address',
                'order_comment',
                'productIds',
            ], 'safe'],
        ];
    }


}