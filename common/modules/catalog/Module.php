<?php

namespace common\modules\catalog;

/**
 * catalog module definition class
 */
class Module extends \yii\base\Module
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
}
