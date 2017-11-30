<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
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
            'class' => 'yii\caching\FileCache',
        ],

        /*'errorHandler' => [
            'errorAction' => 'site/error',
        ],*/

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'manufacturer/<manufacturer:.*>' => 'manufacturer/index',
                //test for mng/elastic
               // 'catalog/<pathForParse:[\w_\/-]+>'=> 'catalog/default',
                //'search/by-name/<name:.*>' => 'search/by-name',
                //'mongo/search/<name:.*>' => 'mongo/search',
                //'POST import' => 'import/create',
                //REST для импорта CSVшек
                //['class' => 'yii\rest\UrlRule', 'controller' => 'import'],
                /*[
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'import',
                    //'except' => ['delete', 'update'],
                    'pluralize' => false //не  переводим import в imports
                ]*/
            ],
        ],
        'assetManager' => [
            'bundles' => [
                //require(__DIR__ . '/assets.php'),
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
            'converter'=> [
                'class'=> 'nizsheanez\assetConverter\Converter',
                'force'=> false, // true : If you want convert your sass each time without time dependency
                'destinationDir' => 'compiled', //at which folder of @webroot put compiled files
                'parsers' => [
                    'sass' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Sass',
                        'output' => 'css', // parsed output file type
                        'options' => [
                            'cachePath' => '@app/runtime/cache/sass-parser' // optional options
                        ],
                    ],
                    'scss' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Scss',
                        'output' => 'css', // parsed output file type
                        'options' => [ // optional options
                            'enableCompass' => false, // default is true
                            'importPaths' => [], // import paths, you may use path alias here,
                            // e.g., `['@path/to/dir', '@path/to/dir1', ...]`
                            'lineComments' => false, // if true — compiler will place line numbers in your compiled output
                            'outputStyle' => 'nested', // May be `compressed`, `crunched`, `expanded` or `nested`,
                            // see more at http://sass-lang.com/documentation/file.SASS_REFERENCE.html#output_style
                        ],
                    ],
                    'less' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Less',
                        'output' => 'css', // parsed output file type
                        'options' => [
                            'auto' => true, // optional options
                        ]
                    ]
                ]
            ]
        ],

    ],
    'modules' => [
        'catalog' => [
            'class' => 'common\modules\catalog\Module',

        ],
    ],
];
