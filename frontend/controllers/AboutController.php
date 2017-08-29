<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 29.08.17
 * Time: 9:36
 */

namespace frontend\controllers;


use yii\web\Controller;

class AboutController extends Controller
{
    public function actionCompany(){

        return $this->render('company');
    }
}