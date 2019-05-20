<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace backend\controllers;


use common\modules\catalog\models\News;
use common\modules\catalog\models\seo\SeoManufacturer;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

class SeoManufacturerController extends Controller
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
    public function actionIndex($id=false)
    {

        $model = false;

        $models = SeoManufacturer::find()->all();

        if($id){

            $model = SeoManufacturer::findOne((int) $id);
        }

        return $this->render('@backend/views/seo/manufacturers', ['models' => $models, 'model' => $model]);
    }


    /**
     * @param bool $id
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id=false){


        $findOne = SeoManufacturer::findOne($id);

        if($findOne){
            $findOne->delete();
        }

        $models = SeoManufacturer::find()->all();

        return $this->render('@backend/views/seo/manufacturers', ['models' => $models, 'model' => false]);


    }




    public function actionAdd(){

        $model = new SeoManufacturer();

        $result = [];

        if($model->load(Yii::$app->getRequest()->post()) && $model->validate()){
            $model = $model->saveMe();
        }

        //\Yii::$app->pr->print_r2($model->getErrors());

        $models = SeoManufacturer::find()->all();

        return $this->render('@backend/views/seo/manufacturers', ['uploadResult' => $result, 'models' => $models, 'model' => $model]);

    }


}