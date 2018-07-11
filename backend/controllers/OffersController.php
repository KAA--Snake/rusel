<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace backend\controllers;

use common\modules\catalog\models\Offers;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

class OffersController extends Controller
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

        $models = Offers::find()->orderBy('id ASC')->all();

        if($id){

            $model = Offers::findOne((int) $id);
        }

        return $this->render('index', ['models' => $models, 'model' => $model]);
    }




    public function actionDelete($id=false){


        $findOne = Offers::findOne($id);

        if($findOne){
            $findOne->delete();
        }

        $models = Offers::find()->orderBy('id ASC')->all();

        return $this->render('index', ['models' => $models, 'model' => false]);


    }




    public function actionAdd(){

        $model = new Offers();

        $result = [];

        if($model->load(Yii::$app->getRequest()->post()) && $model->validate()){

            $model = $model->saveMe();

        }


        //\Yii::$app->pr->print_r2($model->getErrors());

        $models = Offers::find()->orderBy('id ASC')->all();

        return $this->render('index', ['uploadResult' => $result, 'models' => $models, 'model' => $model]);

    }


}