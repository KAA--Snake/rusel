<?php

namespace modules\catalog;

/**
 * catalog module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\catalog\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        //\Yii::configure($this, require(__DIR__ . '/config/config.php'));
    }
}
