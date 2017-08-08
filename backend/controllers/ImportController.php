<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 12:20
 */

namespace backend\controllers;


use common\modules\catalog\models\Section;
use common\modules\catalog\modules\admin\models\import\CatalogImport;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class ImportController extends Controller
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    //public $modelClass = 'common\modules\catalog\models\import\CsvImport';

    //@TODO временно отключаем валидацию токенов для тестирования
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

                $model->import();

                /** запускаем проход по импортированному каталогу и генерим ему урлы*/
                $model->generateCatalogUrls();
            }

        }

        return $this->render('csv', ['allowedExtensions' => $allowedExtensions, 'uploaded' => $uploaded, 'model' => $model]);
    }



    //rest import CSV form
    public function actionIndex(){
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

                $model->import();

                /** запускаем проход по импортированному каталогу и генерим ему урлы*/
                $model->generateCatalogUrls();
            }

        }

        return $this->render('csv', ['allowedExtensions' => $allowedExtensions, 'uploaded' => $uploaded, 'model' => $model]);
    }


    /**
     * Генерирует УРЛЫ для каталога.
     *
     * @TODO Временно отключена, сделать только для админа !
     *
     * @return string
     */
    public function actionGenerate(){

        if(true) return 'ADMINS ONLY';

        $sectModel = new Section();

        $sectModel->generateUrls();

    }



}