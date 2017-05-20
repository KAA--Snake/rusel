<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                //test for mng/elastic
                'search/by-name/<name:.*>' => 'search/by-name',
                'mongo/search/<name:.*>' => 'mongo/search',
                //REST для импорта CSVшек
                ['class' => 'yii\rest\UrlRule', 'controller' => 'import'],
                /*[
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'import',
                    'except' => ['delete', 'create', 'update'],
                    'pluralize' => false //не  переводим import в imports
                ]*/
            ],
        ],
    ],

    'modules' => [
        'catalog' => [
            'class' => 'common\modules\catalog\Module',
        ],
    ],
];
