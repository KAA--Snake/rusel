<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace backend\controllers;


use yii\web\Controller;

class SliderController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($slideId=false)
    {
        echo $slideId;
        die('index');

        return $this->render('index');
    }

    public function actionDelete($slideId){

        echo $slideId;
        die('deleted');

        return $this->render('index');

    }

    public function actionAdd(){


        die('add');

        return $this->render('index');

    }

}