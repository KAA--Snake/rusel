<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\info;

use common\modules\catalog\models\Info;
use yii\base\Widget;

class WInfo extends Widget
{
    //public $maket = 'main_menu';

    public function init()
    {
        parent::init();


        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {

        $news = Info::find()->all();

        return $this->render('list', ['models' => $news]);
    }
}