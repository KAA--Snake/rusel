<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset2 extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/site_main2.css',
        'css/vendor/jquery-ui.structure.css',
        'css/vendor/jquery-ui.theme.css',
        'css/vendor/fotorama.css',
    ];
    public $js = [
        'js/vendor/jquery-3.2.1.min.js',
        'js/vendor/jquery-ui.min.js',
        'js/vendor/fotorama.js',
        'js/script.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /*'yii\bootstrap\BootstrapAsset',*/
    ];
}
