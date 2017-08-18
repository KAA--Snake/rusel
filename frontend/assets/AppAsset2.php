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
        'js/vendor/jquery-3.2.1.js',
        'js/vendor/jquery-ui.js',
        'js/vendor/fotorama.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /*'yii\bootstrap\BootstrapAsset',*/
    ];
}
