<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\offers;


use common\modules\catalog\models\Offers;
use yii\base\Widget;

class WOffers extends Widget
{
    //public $maket = 'main_menu';

    public function init()
    {
        parent::init();


        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {

        $news = Offers::find()->orderBy('id ASC')->all();

        return $this->render('offers', ['models' => $news]);
    }
}