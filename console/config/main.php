<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [


        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'auth' => ['username' => 'elastic', 'password' => 'changeme'],
            //'username' => 'elastic',
            //'password' => 'changeme',
            'nodes' => [
                ['http_address' => 'elasticsearch:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
        //основная база mysql
        /*'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=mysql;port=3306;dbname=yii',
            'username' => 'root',
            'password' => 'pass',
            'charset' => 'utf8',
        ],*/
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=postgres;port=5432;dbname=yii_pg',
            'username' => 'serg',
            'password' => 'pass',
            'charset' => 'utf8',
        ],

        'db_postg' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=postgres;port=5432;dbname=yii_pg',
            'username' => 'serg',
            'password' => 'pass',
            'charset' => 'utf8',
        ],

        'db_mongo' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://yii_user:pass123123@mongodb:27017/yii_mongo',
        ],

        'pr' => [
            'class' => 'common\components\printr\PrettyPrintComponent',

        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,


            //'viewPath' => '@app/mail',
            'htmlLayout' => 'layouts/html',
            'textLayout' => 'layouts/text',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['ordsite@rusel24.ru' => 'Rusel24.ru'],
            ],

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'ordsite@rusel24.ru',
                'password' => 'Sn7ee7HQuQ',
                'port' => '465', // Port 25 is a very common port too
                'encryption' => 'ssl', // It is often used, check your provider or mail server specs
            ],


        ],

        'cache' => [

            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'redis',
                'port' => 6379,
                'database' => 0,
            ]

            //'class' => 'yii\caching\FileCache',
        ],

        /*'errorHandler' => [
            'errorAction' => 'site/error',
        ],*/

        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                ],
            ],
        ],
    ],
    'params' => $params,
];
