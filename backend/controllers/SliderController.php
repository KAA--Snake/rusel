<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace backend\controllers;


use common\modules\catalog\models\Slider;
use yii\web\Controller;
use yii\web\UploadedFile;
use Yii;
use yii\filters\AccessControl;

class SliderController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        //'actions' => ['*'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

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

        $slide = false;

        $slides = Slider::find()->orderBy('id ASC')->all();

        if($slideId){

            $slide = Slider::findOne((int) $slideId);
        }

        return $this->render('index', ['slides' => $slides, 'slide' => $slide]);
    }




    public function actionDelete($slideId){


        $findOne = Slider::findOne($slideId);

        if($findOne){
            $findOne->delete();
        }

        $models = Slider::find()->orderBy('id ASC')->all();


        return $this->render('index', ['slides' => $models, 'slide' => false]);


    }




    public function actionAdd(){

        $slider = new Slider();

        $result = [];

        if($slider->load(Yii::$app->getRequest()->post()) && $slider->validate()){
            $slider = $slider->saveMe();
        }

        //$result['errors'] = $slider->getErrors();

        $slides = Slider::find()->orderBy('id ASC')->all();

        return $this->render('index', ['uploadResult' => $result, 'slides' => $slides, 'slide' => $slider]);

    }

}