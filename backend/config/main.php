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
