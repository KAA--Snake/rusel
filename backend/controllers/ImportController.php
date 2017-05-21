<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 12:20
 */

namespace backend\controllers;

use common\modules\catalog\models\import\CatalogImport;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class ImportController extends Controller
{

    //public $modelClass = 'common\modules\catalog\models\import\CsvImport';

    //временно отключаем валидацию токенов для тестирования TODO
    public $enableCsrfValidation = false;

    public function actionCreate(){
        $catalogModule = \Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedExtensions'];

        $uploaded = false;

        $model = new CatalogImport();

        if (Yii::$app->request->isPost) {

            $model->file = UploadedFile::getInstance($model, 'file');

            //if ($model->massUpload()) {
            if ($model->upload()) {
                // file is uploaded successfully
                $uploaded = true;

                $model->importGroups();
            }

        }

        return $this->render('csv', ['allowedExtensions' => $allowedExtensions, 'uploaded' => $uploaded, 'model' => $model]);
    }



    //rest import CSV form
    public function actionIndex(){
        $catalogModule = \Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedExtensions'];
        $model = new CatalogImport();
        return $this->render('csv', ['allowedExtensions' => $allowedExtensions, 'uploaded' => false, 'model' => $model]);
    }



}