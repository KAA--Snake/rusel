<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace backend\controllers;

use common\modules\catalog\models\Artikle;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

class StaticController extends Controller
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
    public function actionIndex($type = false)
    {

        $model = false;

        //$models = Artikle::find()->all();
        //die();

        if($type){

            $model = Artikle::find()->andWhere(['type' => $type])->one();
        }

        return $this->render($type, ['model' => $model]);
    }


    /**
     * Добавляет новую статью в базу
     * Чтобы ее стало видно, надо сделать вьюху с таким же type и сохранить ее в
     * backend/views/static
     * @return string
     */
    public function actionNew() {
        $model = new Artikle();
        return $this->render('add-new', ['model' => $model]);
    }


    public function actionDelete($id=false){

        return 'Функционал недоступен';

        $findOne = Artikle::findOne($id);

        if($findOne){
            $findOne->delete();
        }

        $models = Artikle::find()->all();

        return $this->render('index', ['models' => $models, 'model' => false]);


    }


    /**
     * Редактирование статьи (не добавление, а именно редактирование.)
     * @return string
     */
    public function actionAdd(){

        $model = new Artikle();

        $result = [];

        if($model->load(Yii::$app->getRequest()->post()) && $model->validate()){

            $model = $model->saveMe();

        }

        //\Yii::$app->pr->print_r2($model->getErrors());
        //$models = Artikle::find()->all();

        return $this->render($model->type, ['uploadResult' => $result, 'model' => $model]);

    }


}