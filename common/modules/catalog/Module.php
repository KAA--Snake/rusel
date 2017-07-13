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
    }


    /**
     * Настройки УРЛов для модуля каталога.
     * Подключен через бутстрап модуля в конфиге фронтенда.
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            'catalog/<pathForParse:[\w_\/-]+>'=>'catalog/default',
            'catalog' => 'catalog/default',
            //'POST import' => 'import/create',
            //'catalog/test/test2' => 'catalog/default',
        ], true);
    }
}
