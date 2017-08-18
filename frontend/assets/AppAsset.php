<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/vendor/jquery-ui.structure.css',
        /*'css/vendor/jquery-ui.theme.css',*/
        'css/vendor/jquery.jscrollpane.css',
        'css/vendor/slick.css',
        'css/vendor/slick-theme.css',
        /*'css/vendor/jstree/style.css',*/
        'css/site.css',
        'css/site_main.css',
    ];
    public $js = [
        'js/vendor/jquery-3.2.1.js',
        'js/vendor/jquery-ui.js',
        'js/vendor/jquery.mousewheel.js',
        'js/vendor/jquery.jscrollpane.min.js',
        'js/vendor/slick.min.js',
        'js/vendor/jstree.min.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /*'yii\bootstrap\BootstrapAsset',*/
    ];
}
