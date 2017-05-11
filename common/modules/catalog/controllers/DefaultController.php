<?php

namespace common\modules\catalog\controllers;

use common\modules\catalog\models\Section;
use yii\web\Controller;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends Controller
{
    public $layout = 'catalog';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $section = new Section();

        $section->setAttributes([
            //'id' => 5,
            'unique_id' => '10',
            'depth_level' => 2,
            'parent_id' => '2',
            'code' => 'razdel_second_level_1',
            'name' => 'Раздел второго уровня_1',
            'sort' => 100,


            'preview_text' => 'Превью текст',
            'detail_text' => 'Детальный текст',
            'picture' => '/images/klemms.jpg',

        ]);

        if($section->insert()){

        }else{
            $errors = $section->getErrors();
            \Yii::$app->pr->print_r2($errors );

        }



/*
        $find = Section::find()->andWhere([
            'depth_level' => 1
        ])->all();

        \Yii::$app->pr->print_r2($find);
*/
        return $this->render('index');
    }
}
