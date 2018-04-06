<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.18
 * Time: 11:38
 */

namespace frontend\controllers;


use common\modules\catalog\models\News;
use yii\web\Controller;

class NewsController extends Controller
{
    public function actionIndex(){

        $models = News::find()
            ->orderBy('date DESC')
            ->all();

        return $this->render('all', ['models' => $models]);
    }

    public function actionOne($news_url = false){

        $model = false;

        if($news_url){
            $model = News::find()->andWhere(['url' => $news_url])->one();
        }

        $models = News::find()
            ->andWhere(['not', ['url' => $news_url]])
            ->orderBy('date DESC')
            ->all();

        return $this->render('one', ['models' => $models,'model' => $model]);
    }
}