<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\feedback_form;

use yii\base\Widget;
use yii\redis\Cache;

class FeedBackForm extends Widget
{

    public function init()
    {
        parent::init();

        //\Yii::$app->pr->print_r2($this->options);
        //die();

        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {
        return $this->render('form');
    }



}