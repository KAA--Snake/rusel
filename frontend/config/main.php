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
    'homeUrl' => '/',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'catalog'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [

        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
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
                    //'levels' => ['error', 'warning'],
                    'levels' => ['error'],
                    'logVars' => [],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

    ],
    'params' => $params,
];
