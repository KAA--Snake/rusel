<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
//elastic
/*
admin: 123123123
readwrite: r1rf98wh7p8
readonly: sh5okh9jf9
elastic: 2v29gg83hjx

# This editor maps roles to users of that role, like this:
# role_name: user1, user2

admin: admin
readwrite: readwrite
readonly: readonly
*/
//6g0h5BHK0kXLM0nSlu4vgVKN
//https://4873ffa424778a84e4cc377607e792b2.us-east-1.aws.found.io:9243/
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
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
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //правило для показа элементов типа post/show/1 (post/show?id=1)
                'post/show/<id:\d+>' => 'post/show',

                'elastic/find-by-name/<name:\w+>' => 'elastic/find-by-name'
            ],
        ],

    ],
    'params' => $params,
];
