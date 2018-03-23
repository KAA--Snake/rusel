<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\main_slider;


use common\modules\catalog\models\Slider;
use yii\base\Widget;

class MainSlider extends Widget
{
    //public $maket = 'main_menu';

    public function init()
    {
        parent::init();


        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {

        $slides = Slider::find()->all();

        return $this->render('main_slider', ['slides' => $slides]);
    }
}