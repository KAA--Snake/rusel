<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace frontend\controllers;

use common\modules\catalog\models\Artikle;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;

class CompanyController extends Controller
{


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
     * @param bool $static_type
     * @return string
     * @throws HttpException
     */
    public function actionIndex($static_type=false)
    {

        $model = false;

        //$models = Artikle::find()->all();

        if($static_type){

            $model = Artikle::find()->andWhere(['type' => $static_type])->one();
        }
        if(!$model){

            throw new HttpException(404);
        }

        return $this->render('static', ['model' => $model]);
    }




}