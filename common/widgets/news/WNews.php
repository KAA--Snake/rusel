<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\news;

use common\modules\catalog\models\News;
use yii\base\Widget;

class WNews extends Widget
{
    //public $maket = 'main_menu';

    public function init()
    {
        parent::init();


        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {

        $news = News::find()->limit(5)->orderBy('date DESC')->all();

        return $this->render('news', ['models' => $news]);
    }
}