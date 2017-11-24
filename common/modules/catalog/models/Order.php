<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.17
 * Time: 14:38
 */

namespace common\modules\catalog\models;


use common\models\elasticsearch\Product;
use yii\base\Model;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
   /* public $answer_var;
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

    public $client_id;
    public $client_ip;
    public $client_geolocation;
    public $client_shortname;
    public $client_fullname;

    public $client_inn;
    public $client_kpp;
    public $delivery_city_index;*/


    /*public $date;
    public $time;*/
    public $is_sent_to_erp;
    public $source = 'rusel24.ru';
    //public $products; //сюда будут падать кука с товарами (целиком, пусть парсят сами в ЕРП)


    public static function tableName()
    {
        return 'public.order';
    }


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
            [['id','client_id', 'is_sent_to_erp'], 'integer'],
            ['email', 'default', 'value' => date('Y-m-d') ],
            ['time', 'default', 'value' => date('H:i:s') ],
            ['products', 'default', 'value' => $this->__getOrderProducts() ],
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

        //\Yii::$app->pr->print_r2($insert);

        // ...custom code here...
        return true;
    }


    /**
     * Вынимает все товары из куки корзины,
     * @return mixed
     * @internal param $order
     */
    private function __getOrderProducts(){


        $orders = [];
        $neededIds = [];

        $products = explode('&', $_COOKIE['cart']);
        //\Yii::$app->pr->print_r2($products);
        if(count($products) > 0){
            foreach($products as $oneProduct){
                $productData = explode('|', $oneProduct);

                $productId = $productData[0];
                $productCount = $productData[1];

                //заполняем для будущей выборки товаров
                $neededIds[] = $productId;

                $orders[$productId] = [
                    'count' => $productCount
                ];

            }
        }

        //тепреь делаем выборку
        //$productsDetailed =

        \Yii::$app->pr->print_r2($orders);

        return '';

        $order = [];

        return $order;
    }



}