<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.17
 * Time: 14:38
 */

namespace common\modules\catalog\models;


use common\helpers\cart\BuyHelper;
use common\models\elasticsearch\Product;
use common\modules\catalog\models\search\searches\ProductsSearch;
use yii\base\Exception;
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
    //public $products; //сюда будет писаться json с данными по товарам в заказе


    public static function tableName()
    {
        return 'public.order';
    }


    public function rules()
    {
        return [
            [['email'], 'required', 'message' => 'Не заполнено поле EMAIL'],
            [['org'], 'required', 'message' => 'Не выбрана "Организация или ИП"'],
            ['email', 'email'],
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
                'client_address',
                'delivery_var',
                'delivery_city',
                'delivery_contact_person',
                'delivery_tel',
                'delivery_time',
                'source'
            ], 'string'],
            [['id','client_id', 'is_sent_to_erp', 'answer_var'], 'integer'],
            ['date', 'default', 'value' => date('Y-m-d') ],
            ['time', 'default', 'value' => date('H:i:s') ],
            //['products', 'default', 'value' => $this->__getOrderProducts() ],
            [[
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

        /**
         * Заполним поле товарами и их ценой
         * Если не заполнены товары, сделаем возможным их изменение.,
         * В будущем чтоб разрешать изменение заказа, надо отрефакторить это условие if(empty($this->products)
         */
        if(empty($this->products)){

            $this->products = $this->__getOrderProducts();
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

        if(count($products) > 0){
            foreach($products as $oneProduct){
                $productData = explode('|', $oneProduct);

                $productId = $productData[0];
                $productCount = $productData[1];
	            $storageId = $productData[2];

                //заполняем для будущей выборки товаров
                $neededIds[$productId] = $productId;

                $orders[] = [
                	'id' => $productId,
                	'storageId' => $storageId,
                    'count' => $productCount
                ];

            }
        }

	    $neededIds = array_values($neededIds);

        //тепреь делаем выборку и формируем данные по заказу
        $productModel = new ProductsSearch();

        $productsDetailed = $productModel->getProductsByIds($neededIds)['hits'];

        foreach($productsDetailed as $oneProduct){

	        //полная передачу данных по товарам в заказ
        	foreach($orders as $oK => &$oneOrder){
        		if($oneOrder['id'] == $oneProduct['_source']['id']){
			        $orders[$oK]['productData'] = $oneProduct['_source'];
                    //\Yii::$app->pr->print_r2($oneProduct);
			        BuyHelper::setPriceForOrderProduct($orders[$oK]);
		        }
	        }
        }

        //die();
	    //\Yii::$app->pr->print_r2($oneProduct);
	    //die();
	    //\Yii::$app->pr->print_r2($productsDetailed);

	    //и возвращаем для сохранения полный json с заказом
        $order = json_encode($orders);

        return $order;
    }


    /**
     * Формирует структуру заказа для отправки в ЕРП
     * структура: ID|количество|цена|код_валюты
     *
     * @return array
     */
    public function getDataForErp(){
        $products = json_decode($this->products);
        $erpProducts = [];

        if(count($products) > 0){
            foreach($products as $oneProduct){
                $oneProductStroke = [];

                if(!isset($oneProduct->price) || empty($oneProduct->price)){
                    $oneProduct->price = 0;
                }
                if(!isset($oneProduct->currency) || empty($oneProduct->currency)){
                    $oneProduct->currency = 643;
                }

                $oneProductStroke[] = $oneProduct->id;
                $oneProductStroke[] = $oneProduct->count;
                $oneProductStroke[] = $oneProduct->price;
                $oneProductStroke[] = $oneProduct->currency;

                if($oneProduct->storageId == 'null'){//lol :)
	                //\Yii::$app->pr->print_r2($oneProduct);
	                $oneProduct->storageId = 0;
                }
	            $oneProductStroke[] = $oneProduct->storageId;

                $oneProductStroke = implode('|', $oneProductStroke);

                $erpProducts[] = $oneProductStroke;
            }
        }

        $erpProducts = implode('&', $erpProducts);

        return $erpProducts;
    }




    public function sendMail(){

        $params = ['order' => $this]; //передаем текущий заказ
        $view = 'created';
        $emailParams = \Yii::$app->getModule('catalog')->params['email'];

        $fio = $this->fio;
        if(empty($fio)){
            $fio = 'Покупатель';
        }

        //$products = (array) json_decode($this->getAttributes()['products']);

        //\Yii::$app->pr->print_r2((array)$products);
        //\Yii::$app->pr->print_r2($this->getAttributes()['products']);
        try{
            //отправка уведомления для админа
            \Yii::$app->mailer->compose([
                'html' => 'views/order/order.created.admin.php',
                //'text' => 'views/order/order.created.admin.php',
            ], $params)
                ->setTo([$emailParams['admin_order'] => 'Admin'])
                ->setSubject('Rusel24.ru: Запрос № '.$this->id. ' ' .date('Y-m-d H:i:s'))
                ->send();
        }catch(Exception $exception){
            file_put_contents('/webapp/upload/orders_errors', 'Не удалось отправить на почту заказ '.$this->id, FILE_APPEND );
        }

        if(empty($this->email)){
            return false;
        }

        return true; //пока не делаем рассылку для клиентов

        //шаблоны для клиента - решили не отправлять ничего клиентам
        /*\Yii::$app->mailer->compose([
            'html' => 'views/order/order.' . $view . '.html.php',
            'text' => 'views/order/order.' . $view . '.text.php',
        ], $params)
            ->setTo([$this->email => $fio])
            ->setSubject('Успешно оформлен заказ Rusel24.ru')
            ->send();*/

    }

}