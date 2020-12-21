<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\actions;

use common\modules\catalog\models\FeedBack;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\web\Response;


class FeedBackFormAddAction extends Action
{

//    public $view = '@frontend/views/feedback/FeedbackForm';
//
    public function init()
    {
       parent::init();
    }

    /**
     * Runs the action.
     */
    public function run()
    {
        $feedBack = new FeedBack();

        if($feedBack->load(Yii::$app->getRequest()->post()) && $feedBack->validate()){
            $feedBack = $feedBack->saveMe();
        }

        die('END HERE');
        return "done";

        //return $this->controller->render($this->view);

    }

    /**
     * Sets the HTTP headers needed by image response.
     */
    protected function setHttpHeaders()
    {
        Yii::$app->getResponse()->getHeaders()
            ->set('Pragma', 'public')
            ->set('Expires', '0')
            ->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
            ->set('Content-Transfer-Encoding', 'binary')
            ->set('Content-type', 'application/xml');
    }
}
