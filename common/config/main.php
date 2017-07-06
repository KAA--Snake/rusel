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
            'enableStrictParsing' => false,
            'rules' => [
                //test for mng/elastic
                'search/by-name/<name:.*>' => 'search/by-name',
                'mongo/search/<name:.*>' => 'mongo/search',
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
                'class'=>'nizsheanez\assetConverter\Converter',
            ]
        ],
    ],
    'modules' => [
        'catalog' => [
            'class' => 'common\modules\catalog\Module',
            'params' => [
                'importFolderName' => 'upload_xml',
                'allowedExtensions' => ['xml', 'csv', 'txt'],
            ]
        ],
    ],
];
