<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'homeUrl' => '/admin',
    'modules' => [
        /*'catalog' => [
            'class' => 'app\modules\catalog\Module',
            'params' => [
                'importFolderName' => 'upload_xml',
                'allowedExtensions' => ['xml', 'csv'],
            ]
        ],*/

    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'GET slider/<slideId:\d+>' => 'slider/index',
                'POST slider/add' => 'slider/add',
                'GET slider/delete/<slideId:\d+>' => 'slider/delete',
                'GET slider/update/<slideId:\d+>' => 'slider/delete',


                'GET info/<id:\d+>' => 'info/index',
                'POST info/add' => 'info/add',
                'GET info/delete/<id:\d+>' => 'info/delete',
                'GET info/update/<id:\d+>' => 'info/update',

                'GET review/<id:\d+>' => 'review/index',
                'POST review/add' => 'review/add',
                'GET review/delete/<id:\d+>' => 'review/delete',
                'GET review/update/<id:\d+>' => 'review/update',

                'GET popular/<id:\d+>' => 'popular/index',
                'POST popular/add' => 'popular/add',
                'GET popular/delete/<id:\d+>' => 'popular/delete',
                'GET popular/update/<id:\d+>' => 'popular/update',

                'GET news/<id:\d+>' => 'news/index',
                'POST news/add' => 'news/add',
                'GET news/delete/<id:\d+>' => 'news/delete',
                'GET news/update/<id:\d+>' => 'news/update',

                'GET static/new' => 'static/new',
                'GET static/<type:\w+>' => 'static/index',
                'POST static/add' => 'static/add',
                'GET static/delete/<id:\d+>' => 'static/delete',
                'GET static/update/<type:\d+>' => 'static/update',


                'GET offers/<id:\d+>' => 'offers/index',
                'POST offers/add' => 'offers/add',
                'GET offers/delete/<id:\d+>' => 'offers/delete',
                'GET offers/update/<id:\d+>' => 'offers/update',

                'GET seo/manufacturer' => 'seo-manufacturer/index',
                'GET seo/manufacturer/<id:\d+>' => 'seo-manufacturer/index',
                'POST seo/manufacturer/add' => 'seo-manufacturer/add',
                'GET seo/manufacturer/delete/<id:\d+>' => 'seo-manufacturer/delete',
                'GET seo/manufacturer/update/<id:\d+>' => 'seo-manufacturer/update',

                'GET seo/section' => 'seo-section/index',
                'GET seo/section/<id:\d+>' => 'seo-section/index',
                'POST seo/section/add' => 'seo-section/add',
                'GET seo/section/delete/<id:\d+>' => 'seo-section/delete',
                'GET seo/section/update/<id:\d+>' => 'seo-section/update',

                //'admin/<action:\w+>' => 'admin/site/<action>'
                /*'<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',*/
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    //'levels' => ['error'],
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget', //в файл
                    'categories' => ['import_fail'], //категория логов
                    'logFile' => '@runtime/logs/import_err.log', //куда сохранять
                    'logVars' => [] //не добавлять в лог глобальные переменные ($_SERVER, $_SESSION...)
                ],
                [
                    'class' => 'yii\log\FileTarget', //в файл
                    'categories' => ['rabbit_import_error'], //категория логов
                    'logFile' => '@runtime/logs/import_rabbit_err.log', //куда сохранять
                    'logVars' => [] //не добавлять в лог глобальные переменные ($_SERVER, $_SESSION...)
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

    ],

    'params' => $params,
];
