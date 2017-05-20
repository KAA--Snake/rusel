<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 12:20
 */

namespace backend\controllers;

use common\modules\catalog\models\import\CsvImport;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class ImportController extends Controller
{

    //public $modelClass = 'common\modules\catalog\models\import\CsvImport';

    //временно отключаем валидацию токенов для тестирования TODO
    public $enableCsrfValidation = false;

    public function actionCreate(){

        //\Yii::$app->pr->print_r2(\Yii::$app->request);

        $model = new CsvImport();

        if (Yii::$app->request->isPost) {

            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');

            /*$post = Yii::$app->request->post();
            \Yii::$app->pr->print_r2($post);*/

            //\Yii::$app->pr->print_r2($model->csvFile);


            //if ($model->massUpload()) {
            if ($model->upload()) {
                // file is uploaded successfully
                return 'uploaded';
            }

        }

        return 'post';
    }



    //rest import form
    public function actionIndex(){

        $model = new CsvImport();

        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return 'uploaded';
            }
        }

       // \Yii::$app->pr->print_r2(\Yii::$app->request);


        return $this->render('csv', ['model' => $model]);
    }



}