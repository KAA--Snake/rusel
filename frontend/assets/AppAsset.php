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
        'css/site.css',

        'css/vendor/jquery-ui.structure.css',
        /*'css/vendor/jquery-ui.theme.css',*/
        'css/vendor/jquery.jscrollpane.css',
        'css/vendor/slick.css',
        'css/vendor/slick-theme.css',
        'css/vendor/suggestions.min.css',
        'css/site_main.css',
    ];
    public $js = [
        'js/vendor/jquery-3.2.1.min.js',
        'js/vendor/jquery-ui.min.js',
        'js/vendor/jquery.mousewheel.js',
        'js/vendor/jquery.jscrollpane.min.js',
        'js/vendor/slick.min.js',
        'js/vendor/clipboard.min.js',
        'js/vendor/jquery.inputmask.bundle.min.js',
        'js/vendor/jquery.xdomainrequest.min.js',
        'js/vendor/jquery.suggestions.min.js',
        'js/vendor/jquery.form-validator.min.js',
        'js/script.min.js',
        'js/cart.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /*'yii\bootstrap\BootstrapAsset',*/
    ];
}
