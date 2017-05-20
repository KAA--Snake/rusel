<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 12:20
 */

namespace backend\controllers;

use app\common\modules\catalog\models\import\CsvImport;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class ImportController extends Controller
{

    //public $modelClass = 'common\modules\catalog\models\import\CsvImport';
    public $enableCsrfValidation = false;

    public function actionCreate(){

        \Yii::$app->pr->print_r2(\Yii::$app->request);

        $model = new CsvImport();

        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');

            if ($model->massUpload()) {
                // file is uploaded successfully


                return 'uploaded';
            }

        }

        return 'post';
    }


/*
    public function actionUploadCsv(){

        $model = new CsvImport();

        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstances($model, 'csvFile');
            if ($model->massUpload()) {
                // file is uploaded successfully


                return 'uploaded';
            }
        }

       // \Yii::$app->pr->print_r2(\Yii::$app->request);


        return $this->render('csv', ['model' => $model]);
    }




    //rest
    public function actionCreate(){
        $model = new CsvImport();

        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstances($model, 'csvFile');
            if ($model->massUpload()) {
                // file is uploaded successfully


                return 'uploaded';
            }
        }

        // \Yii::$app->pr->print_r2(\Yii::$app->request);


        return $this->render('csv', ['model' => $model]);
    }
    */
}