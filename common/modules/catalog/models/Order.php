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

    public $source = 'rusel24.ru';
    public $date;
    public $time;
    public $client_id;
    public $client_ip;
    public $client_geolocation;
    public $client_shortname;
    public $client_fullname;

    public $client_inn;
    public $client_kpp;
    public $delivery_city_index;

    public $products; //сюда будут падать кука с товарами (целиком, пусть парсят сами в ЕРП)


    public function rules()
    {
        return [
            [['email'], 'required'],
            [[
                'client_inn',
                'client_kpp',
                'delivery_city_index',
                'client_ip',
                'client_geolocation',
                'products',
                'fio',
                'tel',
                'email',
                'org',
                'order_comment',
                'client_shortname',
                'delivery_address',
                'client_fullname',
                'delivery_var',
                'delivery_city',
                'delivery_contact_person',
                'delivery_tel',
                'source'
            ], 'string'],
            ['client_id', 'integer'],
            [[
                'answer_var',
                'date',
                'time',
            ], 'safe'],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if(!$this->date){
            $this->date = date('Y-m-d');
        }
        if(!$this->time){
            $this->time = date('h:i:s');
        }
        // ...custom code here...
        return true;
    }


}