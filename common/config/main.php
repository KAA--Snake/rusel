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
            'params' => [
                'importFolderName' => 'upload_xml',
                'allowedExtensions' => ['xml', 'csv', 'txt'],
            ]
        ],
    ],
];
