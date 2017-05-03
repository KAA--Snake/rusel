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
            'rules' => [
                //правило для показа элементов типа post/show/1 (post/show?id=1)
                'search/by-name/<name:\w+>' => 'search/by-name'
            ],
        ],
    ],
];
