<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace backend\controllers;

use common\modules\catalog\models\Popular;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

class PopularController extends Controller
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

        $models = Popular::find()->orderBy('sort ASC')->all();

        if($id){
            $model = Popular::findOne((int) $id);
        }

        return $this->render('index', ['models' => $models, 'model' => $model]);
    }

    /**
     * @param bool $id
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id=false){

        $findOne = Popular::findOne($id);

        if($findOne){
            $findOne->delete();
        }

        $models = Popular::find()->orderBy('sort ASC')->all();

        return $this->render('index', ['models' => $models, 'model' => false]);
    }


    public function actionAdd(){

        $model = new Popular();

        $result = [];
        //\Yii::$app->pr->print_r2(Yii::$app->getRequest()->post());
        if($model->load(Yii::$app->getRequest()->post()) && $model->validate()){
            $model = $model->saveMe();
        }

        $result['errors'] = $model->getErrors();
        //\Yii::$app->pr->print_r2(Yii::$app->getRequest()->post());
        $models = Popular::find()->orderBy('sort ASC')->all();

        return $this->render('index', ['uploadResult' => $result, 'models' => $models, 'model' => false]);
    }


}