<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 19.08.2017
 * Time: 13:20
 */

namespace common\modules\catalog\models\elastic;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class Elastic
{
    /** @var Client $elasticClient*/
    private static $elasticClient; //здесь будет содержаться сам клиент поиска

    public static $host         = 'elasticsearch';
    public static $port         = '9200';
    public static $scheme       = 'http';
    public static $user         = 'elastic';
    public static $pass         = 'f784Gtfx95Htrk48Rtw_04H';


    public function __construct(array $config = [])
    {
        //получаем клиента для поиска
        static::getElasticClient();
    }

    public static function getElasticClient(){

        if(!isset(static::$elasticClient)){
            $hosts = [
                // This is effectively equal to: "https://username:password!#$?*abc@foo.com:9200/"
                [
                    'host' => static::$host,
                    'port' => static::$port,
                    'scheme' => static::$scheme,
                    'user' => static::$user,
                    'pass' => static::$pass,
                ],

            ];

            static::$elasticClient = ClientBuilder::create()           // Instantiate a new ClientBuilder
            ->setHosts($hosts)      // Set the hosts
            ->build();              // Build the client object

            return static::$elasticClient;
        }


        return static::$elasticClient;
    }

}