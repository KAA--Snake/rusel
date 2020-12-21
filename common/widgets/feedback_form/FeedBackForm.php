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
    public $options;

    public static $defaultMode = 'default';
    public static $quickMode = 'quickAsk';
    public static $detailMode = 'withDetailProduct';


    public function init()
    {
        parent::init();

        if (!isset($this->options['oneProduct']) && empty($this->options['oneProduct'])) {
            $this->options['oneProduct'] = false;
        }

        //\Yii::$app->pr->print_r2($this->options);
        //die();

        //yiiwebJqueryAsset::register($this->getView());
    }

    private function buttonLogic()
    {
        switch ($this->options['mode']) {
            case static::$defaultMode:
                return "Задать вопрос";
                break;

            case static::$quickMode:
                return "Быстрый запрос";
                break;

            case static::$detailMode:
                return "Загрузить заказ";
                break;
        }
    }

    public function run()
    {
        $buttonText = $this->buttonLogic();

        //\Yii::$app->pr->print_r2($this->options);

        return $this->render('form', [
            'buttonText' => $buttonText,
            'oneProduct' => $this->options['oneProduct'],
        ]);
    }



}