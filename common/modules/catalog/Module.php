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
            $catalogDir.'/admin/section' => $catalogDir.'/admin/section/index',
            $catalogDir.'/admin/product' => $catalogDir.'/admin/product/index',
            $catalogDir.'/<pathForParse:[\w_\/-]+>'=> $catalogDir.'/default',
            $catalogDir => $catalogDir.'/default',
            //'POST import' => 'import/create',
            //'catalog/test/test2' => 'catalog/default',
        ], true);
    }
}
