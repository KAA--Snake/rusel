<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace backend\controllers;


use common\modules\catalog\models\Info;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class InfoController extends Controller
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
    public function actionIndex($id=false)
    {

        $model = false;

        $models = Info::find()->all();

        if($id){

            $model = Info::findOne((int) $id);
        }

        return $this->render('index', ['models' => $models, 'model' => $model]);
    }




    public function actionDelete($id=false){


        $findOne = Info::findOne($id);

        if($findOne){
            $findOne->delete();
        }

        $models = Info::find()->all();

        return $this->render('index', ['models' => $models, 'model' => false]);


    }




    public function actionAdd(){

        $model = new Info();

        $result = [];

        if($model->load(Yii::$app->getRequest()->post()) && $model->validate()){

            $model->file = UploadedFile::getInstance($model, 'file');

            if(!empty($model->file)){

                $savedImgResult = $model->upload();

                if ($savedImgResult) {

                    //\Yii::$app->pr->print_r2($model->getAttributes());

                    $model->setAttributes([
                        'sort' => $model->sort,
                        'url' => $model->url,
                        'text' => $model->text,

                        'big_img_src' => $savedImgResult['big_img_src'],
                        'big_img_width' => $savedImgResult[0],
                        'big_img_height' => $savedImgResult[1],
                        //'small_img_width',
                        //'small_img_height'
                    ]);

                    if($model->save() == false){
                        $result['errors'] = $model->getErrors();
                    }

                }
            }

        }

        //$result['errors'] = $model->getErrors();

        $models = Info::find()->all();

        return $this->render('index', ['uploadResult' => $result, 'models' => $models, 'model' => $model]);

    }


}