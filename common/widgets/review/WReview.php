<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2020
 * Time: 14:46
 */

namespace common\widgets\review;

use common\modules\catalog\models\Review;
use yii\base\Widget;

class WReview extends Widget
{
    //public $maket = 'main_menu';

    public function init()
    {
        parent::init();


        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {

        $models = Review::find()->orderBy('sort ASC')->all();

        return $this->render('list', ['models' => $models]);
    }
}