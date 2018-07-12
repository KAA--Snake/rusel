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


class ImportManualController extends Controller
{

    //@TODO временно отключаем валидацию токенов для тестирования
    public $enableCsrfValidation = false;


    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        //'actions' => ['*'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }




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


    public function actionSendt(){
        //return 'dddd';
        print_r(\Yii::$app->request->post());
        return;
    }

    public function actionSend(){

        $ch = curl_init( 'http://rusel24.fvds.ru/admin/import/sendt/' );
        # Setup request to send json via POST.

        $resUlt = [
            'RES' => 'DONE',
            'ERRORS' => ['no' => 'errors']
        ];

        $payload = array(
            'type' => 'site_answer',
            'answer' => 'somefile.xml',
            'result' => $resUlt,
        ) ;

        $payload = http_build_query($payload);

        file_put_contents('test_result_payload', $payload);

        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        //curl_setopt($ch, CURLOPT_USERPWD, Elastic::$user . ":" . Elastic::$pass);
        //curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
        //curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        $result = curl_exec($ch);
        file_put_contents('test_result_self', print_r($result, true));
        //file_put_contents('test_payload_self', print_r($payload, true));

        curl_close($ch);


    }





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


    //rest import CSV form
    public function actionIndex(){
        $catalogModule = \Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedExtensions'];

        $uploaded = false;
        $isProductsClear = false; //флаг - удалены ли товары

        $model = new CatalogImport();

        $importResults = Import_log::find()->andWhere([])->asArray()->all();
        echo 'Результат импорта товаров: ';
        \Yii::$app->pr->print_r2($importResults);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()){

            $model->file = UploadedFile::getInstance($model, 'file');

            /** если есть файл- загрузим его @todo перенести логику в модель */
            if(!empty($model->file)){

                if ($model->upload()) {
                    // file is uploaded successfully
                    $uploaded = true;

                    //первичное сохранение логгера
                    Import_log::deleteAll(); //сначала чистим
                    Import_log::$currentImportModel = [
                        'import_file_name' => $model->file,
                        'import_status' => 0,
                        'start_date' => date('Y-m-d H:i:s'),

                    ];
                    Import_log::checkAndSave();

                    $model->import();

                    /** запускаем проход по импортированному каталогу и генерим ему урлы*/
                    $model->generateCatalogUrls();

                    ob_end_clean();
                    echo "<script type='text/javascript'>  window.location='/admin/import-manual/'; </script>";


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
            'model' => $model,
            'importResults' => $importResults,
            ]
        );
    }


    /**
     * импорт списка производителей
     *
     * @return string
     */
    public function actionManufacturers(){
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

                }
            }

        }

        return $this->render('manufacturer', [
                'allowedExtensions' => $allowedExtensions,
                'uploaded' => $uploaded,
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

    public function actionManual(){

        //throw new HttpException(404, 'Функционал недоступен');
        if(\Yii::$app->getRequest()->getIsPost()){

            $erpParams = \Yii::$app->getModule('catalog')->params['erp'];

            $catalogModule = \Yii::$app->getModule('catalog');
            $allowedExtensions = $catalogModule->params['allowedExtensions'];

            $postData = \Yii::$app->getRequest()->post();


	            //запустить импорт
	        if(isset($postData['file_name']) && !empty($postData['file_name'])){


	                //первичное сохранение логгера
	                Import_log::deleteAll(); //сначала чистим
	                Import_log::$currentImportModel = [
		                'import_file_name' => $postData['file_name'],
		                'import_status' => 0,
		                'start_date' => date('Y-m-d H:i:s'),

	                ];
	                Import_log::checkAndSave();

	                exec('nohup php /webapp/yii import/manual '.$postData['file_name']. ' > /dev/null &');

                }
        }

        ob_end_clean();
        echo "<script type='text/javascript'>  window.location='/admin/import-manual/'; </script>";

    }

}