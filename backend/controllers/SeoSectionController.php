<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace backend\controllers;


use common\modules\catalog\models\seo\SeoSection;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

class SeoSectionController extends Controller
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

        $models = SeoSection::find()->all();

        if($id){

            $model = SeoSection::findOne((int) $id);
        }

        return $this->render('@backend/views/seo/sections', ['models' => $models, 'model' => $model]);
    }


    /**
     * @param bool $id
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id=false){


        $findOne = SeoSection::findOne($id);

        if($findOne){
            $findOne->delete();
        }

        $models = SeoSection::find()->all();

        return $this->render('@backend/views/seo/sections', ['models' => $models, 'model' => false]);


    }




    public function actionAdd(){

        $model = new SeoSection();

        $result = [];

        if($model->load(Yii::$app->getRequest()->post()) && $model->validate()){
            $model = $model->saveMe();
        }

        //\Yii::$app->pr->print_r2($model->getErrors());

        $models = SeoSection::find()->all();

        return $this->render('@backend/views/seo/sections', ['uploadResult' => $result, 'models' => $models, 'model' => $model]);

    }


}