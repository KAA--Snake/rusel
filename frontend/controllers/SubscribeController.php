<?php

namespace frontend\controllers;

use Yii;
use common\models\Subscribe;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class SubscribeController extends \yii\web\Controller
{

    /**
     * Lists all Subscribe models.
     * @return mixed
     */
    public function actionAdminSubscribes()
    {

        if (Yii::$app->user->can('admin')){

            $dataProvider = new ActiveDataProvider([
                'query' => Subscribe::find(),
            ]);

            return $this->render('admin', [
                'dataProvider' => $dataProvider,
            ]);
        }

        return '403';

    }



    /**
     * Creates a new Subscribe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateSubscribe()
    {
        $model = new Subscribe();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create-subscribe']);
        } else {
            return $this->render('new', [
                'model' => $model,
            ]);
        }
    }



}
