<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.04.2017
 * Time: 17:31
 */

namespace common\models\elasticsearch;

use common\helpers\translit\Translit;
use common\modules\catalog\models\Section;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use yii\base\Model;
use yii\elasticsearch\Exception;

class Product extends Model
{
    /** @var Client $elasticClient*/
    private static $elasticClient; //здесь будет содержаться сам клиент поиска

    const productData = [
        'index' => 'product',
        'type' => 'product_type',
    ];

    public function __construct(array $config = [])
    {
        //получаем клиента для поиска
        static::getElasticClient();

        parent::__construct($config);
    }



    public static function getElasticClient(){

        if(!isset(static::$elasticClient)){
            $hosts = [
                // This is effectively equal to: "https://username:password!#$?*abc@foo.com:9200/"
                [
                    'host' => 'elasticsearch',
                    'port' => '9200',
                    'scheme' => 'http',
                    'user' => 'elastic',
                    'pass' => 'changeme'
                ],

            ];

            static::$elasticClient = ClientBuilder::create()           // Instantiate a new ClientBuilder
            ->setHosts($hosts)      // Set the hosts
            ->build();              // Build the client object

            return static::$elasticClient;
        }


        return static::$elasticClient;
    }


    public function attributes(){
        return [
            //'_id',
            'id',
            'section_id',
            'url',
            'status',
            'sort',
            'name',
            'code',
            'artikul',
            'ed_izmerenia',
            'product_logic',
            'properties',
            'other_properties',
            'prices',
            'quantity',
            'marketing',
        ];
    }


    public function rules(){
        return [
            [['id', 'name', 'code', 'artikul', 'status'], 'required'],
            [['id', 'section_id', 'status'], 'integer'],
            [['id'], 'unique'],
            [['sort'], 'default', 'value' => 100],
            [['url'], 'string'],
        ];
    }



    /** удаляет все индексы для товаров*/
    public function deleteAll(){
        $params = [
             "query" => [
                 'index' => 'product',
                 "match_all" => new \stdClass()
             ]
        ];
        $ch = curl_init( 'http://elasticsearch:9200/product' );
        # Setup request to send json via POST.
        /*$payload = json_encode( array(
            "login"=> 'elastic',
            "password"=> 'changeme',
        ) );*/
        //curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_USERPWD, 'elastic' . ":" . 'changeme');


        $result = curl_exec($ch);
        curl_close($ch);

        //var_dump($result);
    }


    public function addProduct($productData){

        $params = [
            'id' => $productData['id'],
            //'routing' => 'company_xyz',
            //'timestamp' => strtotime("-1d"),
            'body' => $productData
        ];

        //добавляем базовую инфу (название индекса и тп)
        $params = self::productData+$params;

        try{
            $response = static::getElasticClient()->index($params);

        }catch(\Exception $e){

            $message = json_decode($e->getMessage());

            echo '<br/>'.$params['id'].'|'.'ERROR'.'|'.$message->error->reason;

            //@TODO закомментить отладку ниже, оставить толкь ото что выше
            \Yii::$app->pr->print_r2($params);
        }

        //$response = static::getElasticClient()->update($params);

    }



    public function getProductById($productId){
        $params = [
            //'index' => 'product',
            //'type' => 'product_type',
            //'id' => $productId
            'id' => 6654
        ];

        $params = static::productData + $params;

        //\Yii::$app->pr->print_r2($params);


        return static::getElasticClient()->get($params);
        //var_dump($response);

        //\Yii::$app->pr->print_r2($response);
    }




    /**
     * Сохранение из парсера
     * @param $product
     * @internal param $group
     */
    public function saveProduct(&$product){



        $product['code'] = str_ireplace(['/','\\'], '', $product['code']);

        /**
         * если не задан код, берем его транслитом из артикула
         */
        if(empty($product['code']) || $product['code'] == ''){

            //если артикул есть
            if(!empty($product['artikul']) && $product['artikul'] != ''){
                $product['code'] = $product['artikul'];
            }else{
                //если артикула нет, делаем код из имени
                $product['code'] = $product['name'];
            }
            $product['code'] = Translit::t($product['code']);
        }

        /** сгенерим урл из урла раздела/урла товара */
        $product['url'] = $this->__generateUrl($product['code'], $product['section_id']);


        //\Yii::$app->pr->print_r2($product);


        try{

            $this->addProduct($product);

           // $selfProduct->save();

        }catch (Exception $e){

            $error = '<br />' . $e->getMessage() . '<br />';

            //echo $error;
            //\Yii::$app->pr->print_r2($product);

            //\Yii::$app->session->setFlash('error_'.intval($product['id']), $error);
        }



    }


    /**
     * Генерирует УРЛы для товаров и пишет их в соотв поле таблицы...надо ли ?
     *
     * @return bool
     */
    private function __generateUrl($productCode, $sectionUniqueId){
        $section = false; //первоначально раздела для товара нет

        if($sectionUniqueId > 0 && !empty($sectionUniqueId)){
            $section = Section::find()->andWhere(['unique_id' => $sectionUniqueId])->one();
        }else{
            //@TODO нет раздела для товара, значит сбрасываем его в корень кталога. Подумать как это реализовать!
        }

        /*echo '$section->url = ' . $section->url . '<br />';
        echo '$productCode = ' . $productCode . '<br />';
        echo 'URL = '.$section->url.$productCode.'/' . '<br />';*/

        if($section){
            //echo 'Уникальный ИД: '.$section->unique_id . '<br />';
            return $section->url.$productCode.'/';
        }else{
            //@TODO не найден такой раздела в каталоге для товара, сбрасываем товар в корень каталога

        }

        //если раздела не существует, то хотя бы генерим урл из кода
        return $productCode.'/';
    }


}