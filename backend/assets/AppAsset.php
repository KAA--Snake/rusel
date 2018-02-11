<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/vendor/jquery-ui.structure.css',
        /*'css/vendor/jquery-ui.theme.css',*/
        'css/site_main.css',
    ];
    public $js = [
        'js/vendor/jquery-3.2.1.js',
        'js/vendor/jquery-ui.js',
        'js/vendor/jquery.mousewheel.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /*'yii\bootstrap\BootstrapAsset',*/
    ];
}
