<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\feedback_form;

use common\modules\catalog\models\FeedBack;
use yii\base\Widget;
use yii\redis\Cache;

class FeedBackForm extends Widget
{
    public $options;

    private $errors = array();
    private $isSent = false;

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

        $feedBack = new FeedBack();

        if($feedBack->load(\Yii::$app->getRequest()->post())) {

            if($feedBack->validate()){
                $feedBack = $feedBack->saveMe();

                //этот блок если при загрузке файла появятся ошибки
                if ($feedBack->hasErrors()) {
                    $this->errors = $feedBack->getErrors();

                    //очистим ошибки, чтобы показать их без гребаной яичной дефолтности
                    $feedBack->clearErrors();
                } else {
                    //отправка письма
                    $feedBack->sendMail();

                    //говорим что все в порядке (в шаблоне где-то)
                    $this->isSent = true;

                    //обновляем поля формы
                    $feedBack = new FeedBack();
                }

            } else {
                $this->errors = $feedBack->getErrors();

                //очистим ошибки, чтобы показать их без гребаной яичной дефолтности
                $feedBack->clearErrors();
            }
        }

        //\Yii::$app->pr->print_r2($this->errors);

        return $this->render('form', [
            'isSent' => $this->isSent,
            'errors' => $this->errors,
            'model' => $feedBack,
            'buttonText' => $buttonText,
            'oneProduct' => $this->options['oneProduct'],
        ]);
    }



}