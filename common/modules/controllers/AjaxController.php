<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.10.17
 * Time: 9:52
 */

namespace frontend\controllers;


use common\modules\catalog\models\currency\Currency;
use yii\web\Controller;

class AjaxController extends Controller
{

    /** отдает курсы всех валют в JSON */
    public function actionGetCurrencies(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return Currency::getAllCurrencies();
    }
}