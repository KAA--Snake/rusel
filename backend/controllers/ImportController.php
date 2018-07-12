<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 12:20
 */


namespace backend\controllers;

set_time_limit(0);

use common\modules\catalog\models\catalog_import\Import_log;
use common\modules\catalog\models\mongo\Product;
use common\modules\catalog\models\Section;
use common\modules\catalog\modules\admin\models\import\CatalogImport;
use phpDocumentor\Reflection\Location;
use Yii;
use yii\filters\AccessControl;
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

                            //$catalogImportModel = new CatalogImport();
                            //echo $_SERVER['DOCUMENT_ROOT'];
                            //die();
                            //$catalogImportModel->filePath = $erpParams['upload_folder'].$postData['file_name'];
                            //$catalogImportModel->filePath = '/webapp/upload/erp/list1502263897108.txt';

	                        exec('nohup php /webapp/yii import/manual '.$postData['file_name']. ' > /dev/null &');
                            //$catalogImportModel->import();
                            //return json_encode(['IMPORT_RESULT' => 'DONE']);



                            /*$resUlt = [
                                'RES' => 'DONE',
                                'ERRORS' => $_SESSION['ERRORS']
                            ];
                            $catalogImportModel->sendRespondToErp($postData['file_name'], $resUlt);*/

                            return true;
                            //return json_encode();

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