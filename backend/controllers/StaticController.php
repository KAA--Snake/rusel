<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.18
 * Time: 17:01
 */

namespace backend\controllers;


use yii\web\Controller;

class StaticController extends Controller
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCooperation()
    {
        return $this->render('cooperation');
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionDelivery()
    {
        return $this->render('delivery');
    }

    public function actionDocuments()
    {
        return $this->render('documents');
    }

    public function actionVacancies()
    {
        return $this->render('vacancies');
    }


}