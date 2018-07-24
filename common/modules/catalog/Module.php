<?php

namespace common\modules\catalog;

use yii\base\BootstrapInterface;

/**
 * catalog module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\modules\catalog\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();




        $this->modules = [
            'admin' => [
                // you should consider using a shorter namespace here!
                'class' => 'common\modules\catalog\modules\admin\Module',
            ],
        ];


        // custom initialization code goes here
        \Yii::configure($this, require(__DIR__ . '/config/config.php'));

        //echo $this->params['catalogDir'];
        //die();
        \Yii::setAlias('@catalogDir', $this->params['catalogDir']);
        \Yii::setAlias('@catImages', $this->params['uploadImagesDir']);
        \Yii::setAlias('@catDocs', $this->params['uploadFilesDir']);


    }


    /**
     * Настройки УРЛов для модуля каталога.
     * Подключен через бутстрап модуля в конфиге фронтенда.
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {

        $catalogDir = $this->params['catalogDir'];

        //подстановка слеша в конце
        $app->getUrlManager()->suffix = '/';

        $app->getUrlManager()->addRules([
            //['class' => 'yii\rest\UrlRule', 'controller' => 'pek'],
            //'POST /admin/import/' => 'import/create',
           //'POST admin/import' => 'import/create',
            //$catalogDir.'/ajax-cart/' => $catalogDir.'/cart/get-cart/',
            $catalogDir.'/cart/' => '/cart/', //корзина

            //$catalogDir.'/admin/section/' => $catalogDir.'/admin/section/index',
            //$catalogDir.'/admin/section/<id:\d+>' => $catalogDir.'/admin/section/view',
            //$catalogDir.'/admin/section/<action:\w+>/<id:\d+>' => $catalogDir.'/admin/section/<action>',
            //$catalogDir.'/admin/section/<action:\w+>' => $catalogDir.'/admin/section/<action>',

            //производители
            //$catalogDir.'/admin/manufacturer/' => $catalogDir.'/admin/manufacturer/index',
            //$catalogDir.'/admin/manufacturer/<id:\d+>' => $catalogDir.'/admin/manufacturer/view',
            //$catalogDir.'/admin/manufacturer/<action:\w+>/<id:\d+>' => $catalogDir.'/admin/manufacturer/<action>',
            //$catalogDir.'/admin/manufacturer/<action:\w+>' => $catalogDir.'/admin/manufacturer/<action>',

            //$catalogDir.'/admin/product/' => $catalogDir.'/admin/product/index',
            $catalogDir.'/<pathForParse:.+>'=> $catalogDir.'/default',
            $catalogDir => $catalogDir.'/default',


            /*'/catalog/admin/section/' => '/catalog/admin/section/index',
            '/catalog/admin/product/' => '/catalog/admin/product/index',
            '/catalog/<pathForParse:.+>'=> '/catalog/default',*/





            '/catalog' => '/catalog/default',

            //'catalog/test/test2' => 'catalog/default',
        ], true);
    }
}
