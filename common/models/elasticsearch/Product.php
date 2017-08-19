<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.04.2017
 * Time: 17:31
 */

namespace common\models\elasticsearch;

use common\helpers\translit\Translit;
use common\modules\catalog\models\elastic\Elastic;
use common\modules\catalog\models\Section;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use yii\base\Model;
use yii\elasticsearch\Exception;

class Product extends Model
{

    const productData = [
        'index' => 'product',
        'type' => 'product_type',
    ];


    public function clearAllProducts(){

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
        curl_setopt($ch, CURLOPT_USERPWD, Elastic::$user . ":" . Elastic::$pass);


        $result = curl_exec($ch);
        curl_close($ch);

        //var_dump($result);
    }


    /**
     * первоначаьлный маппинг
     */
    public function mapIndex(){


        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'product',
            'body' => [
                //'settings' => [
                //    'number_of_shards' => 3,
                //    'number_of_replicas' => 2
                //],
                'mappings' => [
                    'product_type' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'url' => [
                                'type' => 'text',
                                //'analyzer' => 'standard'
                            ],
                            'url' => [
                                'type' => 'keyword',
                                //'analyzer' => 'standard'
                            ],
                            'section_id' => [
                                'type' => 'integer'
                            ],
                            'id' => [
                                'type' => 'integer'
                            ],
                            'sort' => [
                                'type' => 'integer'
                            ],
                            'artikul' => [
                                'type' => 'keyword'
                            ],

                            'properties.proizvoditel' => [
                                'type' => 'keyword'
                            ],
                            'properties.prinadlejnosti' => [
                                'type' => 'keyword'
                            ],

                            'other_properties' => [
                                'type' => 'nested'
                            ],


                            'prices' => [
                                'type' => 'nested'
                            ],

                            'quantity' => [
                                'type' => 'nested'
                            ],
                        ]
                    ]
                ]
            ]
        ];

        // Create the index with mappings and settings now
        $response = Elastic::getElasticClient()->indices()->create($params);

        // Update the index mapping
       // static::getElasticClient()->indices()->create($params);

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
            $response = Elastic::getElasticClient()->index($params);

        }catch(\Exception $e){

            $message = json_decode($e->getMessage());

            $mesObj = [
                'ID' => $params['id'],
                'ERR_DESC' => $message->error->reason
            ];

            $_SESSION['ERRORS'][] = $mesObj;

            //\Yii::$app->pr->print_r2($params);
        }

        //$response = Elastic::getElasticClient()->update($params);

    }


    /**
     * Получает список товаров по ИД раздела
     *
     * @param $productId
     * @return array
     */
    public function getProductsBySectionId($sectionId){
        $params = [
            'body' => [
                'query' => [
                    'term' => [
                        'section_id' => $sectionId
                    ]
                ]
            ]
        ];

        $params = static::productData + $params;

        $response = Elastic::getElasticClient()->search($params);

       /* \Yii::$app->pr->print_r2($params);
        \Yii::$app->pr->print_r2($response);*/

        if(!empty($response['hits']['hits'][0]['_source']) && isset($response['hits']['hits'][0]['_source'])){
            return $response['hits']['hits'];
        }

        //die();
        return false;
        //\Yii::$app->pr->print_r2($params);


        //return Elastic::getElasticClient()->get($params);
        //var_dump($response);

        //\Yii::$app->pr->print_r2($response);
    }


    /**
     * Получает товар по его св-ву url
     *
     * @param $productUrl
     * @return bool
     */
    public function getProductByUrl($productUrl)
    {

        $url = str_replace('/', '|', $productUrl);

        $params = [
            'body' => [
                'query' => [
                    'match' => [
                        'url' => $url
                    ]
                ]
            ]
        ];


        /*$json = '{
            "query" : {
                "term" : {
                    "section_id" : "165"
                }
            }
        }';*/

        /*$params = [
            'body' => $json
        ];*/

        //\Yii::$app->pr->print_r2($params);
        //\Yii::$app->pr->print_r2($response);
        //print_r($response);

        $params = static::productData + $params;

        $response = Elastic::getElasticClient()->search($params);

        if(!empty($response['hits']['hits'][0]['_source']) && isset($response['hits']['hits'][0]['_source'])){
            return $response['hits']['hits'][0]['_source'];
        }

        return false;

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

        $this->addProduct($product);

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

            //выпиливаем слеши для сохранения в базе
            $url = str_replace('/', '|', $section->url.$productCode);
            //$url = md5($url);


            //return 'electric_productsaksessuary-dlya-klemmmarkirovka2035-0';
            return $url;
        }else{
            //@TODO не найден такой раздела в каталоге для товара, сбрасываем товар в корень каталога

        }

        //если раздела не существует, то хотя бы генерим урл из кода
        return $productCode.'/';
    }


}