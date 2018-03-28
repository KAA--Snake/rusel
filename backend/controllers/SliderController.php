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

        $slide = false;

        $slides = Slider::find()->all();

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

        $models = Slider::find()->all();


        return $this->render('index', ['slides' => $models, 'slide' => false]);


    }




    public function actionAdd(){

        $slider = new Slider();

        $result = [];

        if($slider->load(Yii::$app->getRequest()->post()) && $slider->validate()){

            $slider->file = UploadedFile::getInstance($slider, 'file');

            if(!empty($slider->file)){

                $savedImgResult = $slider->upload();

                if ($savedImgResult) {

                    //\Yii::$app->pr->print_r2($savedImgResult);

                    $slider->setAttributes([
                        'slide_url' => $slider->slide_url,
                        'big_img_src' => $savedImgResult['big_img_src'],
                        'big_img_width' => $savedImgResult[0],
                        'big_img_height' => $savedImgResult[1],
                        //'small_img_width',
                        //'small_img_height'
                    ]);

                    if($slider->save() == false){
                        $result['errors'][] = 'Не удалось загрузить файл';
                    }

                }
            }

        }

        $result['errors'] = $slider->getErrors();

        $slides = Slider::find()->all();

        return $this->render('index', ['uploadResult' => $result, 'slides' => $slides, 'slide' => $slider]);

    }

}