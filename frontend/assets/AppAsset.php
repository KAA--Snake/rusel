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
        'https://cdn.jsdelivr.net/npm/suggestions-jquery@17.5.0/dist/css/suggestions.min.css',
        'css/site_main.css',
    ];
    public $js = [
        'js/vendor/jquery-3.2.1.js',
        'js/vendor/jquery-ui.js',
        'js/vendor/jquery.mousewheel.js',
        'js/vendor/jquery.jscrollpane.min.js',
        'js/vendor/slick.min.js',
        'js/vendor/jquery.inputmask.bundle.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js',
        'https://cdn.jsdelivr.net/npm/suggestions-jquery@17.5.0/dist/js/jquery.suggestions.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js',
        'js/script.js',
        'js/cart.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /*'yii\bootstrap\BootstrapAsset',*/
    ];
}
