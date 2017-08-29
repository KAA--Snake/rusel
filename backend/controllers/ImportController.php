<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 12:20
 */


namespace backend\controllers;

set_time_limit(0);

use common\modules\catalog\models\mongo\Product;
use common\modules\catalog\models\Section;
use common\modules\catalog\modules\admin\models\import\CatalogImport;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;


class ImportController extends Controller
{

    //@TODO временно отключаем валидацию токенов для тестирования
    public $enableCsrfValidation = false;

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



    public function actionCreate(){
        $catalogModule = \Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedExtensions'];

        $uploaded = false;

        $model = new CatalogImport();


        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()){
            \Yii::$app->pr->print_r2(Yii::$app->request->post());

            die();

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
    public function actionTest(){
        return 'works';
    }


    //rest import CSV form
    public function actionIndex(){
        $catalogModule = \Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedExtensions'];

        $uploaded = false;
        $isProductsClear = false; //флаг - удалены ли товары

        $model = new CatalogImport();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()){

            $model->file = UploadedFile::getInstance($model, 'file');

            /** если есть файл- загрузим его @todo перенести логику в модель */
            if(!empty($model->file)){

                if ($model->upload()) {
                    // file is uploaded successfully
                    $uploaded = true;

                    $model->import();

                    /** запускаем проход по импортированному каталогу и генерим ему урлы*/
                    $model->generateCatalogUrls();
                }
            }


            if(\Yii::$app->request->post('CatalogImport')['isNeedDropCollection'] == 1){
                /** надо чистить товары */
                /** @TODO СДЕЛАТЬ ПРОВЕРКУ НА АДМИНА !!*/

                $productModel = new \common\models\elasticsearch\Product();
                $productModel->clearAllProducts();
                $productModel->mapIndex();
                $isProductsClear = true;

            }



        }

        return $this->render('csv', [
            'allowedExtensions' => $allowedExtensions,
            'uploaded' => $uploaded,
            'isProductsClear' => $isProductsClear,
            'model' => $model
            ]
        );
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




    public function actionErp(){

        if(\Yii::$app->getRequest()->getIsPost()){
            $erpParams = \Yii::$app->getModule('catalog')->params['erp'];
            $postData = \Yii::$app->getRequest()->post();


            if($erpParams['login'] == $postData['login']){
                if($erpParams['password'] == $postData['password']){

                    //удалить ли товары?
                    if(isset($postData['clear_products']) && !empty($postData['clear_products'])){
                        //временно отключили удаление товаров
                        //$elModel = new \common\models\elasticsearch\Product();
                        //$elModel->deleteAll();

                    }

                    //запустить импорт
                    if(isset($postData['start_import']) && !empty($postData['start_import'])){


                        if(isset($postData['file_name']) && !empty($postData['file_name'])){

                            unset($_SESSION['ERRORS']);

                            $catalogImportModel = new CatalogImport();
                            //echo $_SERVER['DOCUMENT_ROOT'];
                            //die();
                            $catalogImportModel->filePath = $erpParams['upload_folder'].$postData['file_name'];
                            //$catalogImportModel->filePath = '/webapp/upload/erp/list1502263897108.txt';

                            $catalogImportModel->import();
                            //return json_encode(['IMPORT_RESULT' => 'DONE']);

                            return json_encode([
                                'RESULT' => 'DONE',
                                'ERRORS' => $_SESSION['ERRORS']
                            ]);

                        }



                        //echo $file;

                    }



                }
            }


        }


        throw new HttpException(404, 'Страница не найдена');

        //\Yii::$app->pr->print_r2(\Yii::$app->request->post());

        //return 'error';
    }

}