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
use common\modules\catalog\modules\admin\models\export\CatalogExport;
use common\modules\catalog\modules\admin\models\export\ProductXmlWriter;
use common\modules\catalog\modules\admin\models\export\XmlWriter;
use common\modules\catalog\modules\admin\models\import\CatalogImport;
use phpDocumentor\Reflection\Location;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;


class ExportController extends Controller
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
        ];
    }

    //rest import CSV form
    public function actionIndex(){
        $catalogModule = \Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedExtensions'];

        $uploaded = false;
        $isProductsClear = false; //флаг - удалены ли товары

        //$model = new CatalogImport();

        $model = new CatalogExport();

        $importResults = '';

        $path = ProductXmlWriter::$dirPath;

        try {
            $importResults = file_get_contents($path.'exportStatus.log');
        } catch (\Exception $e) {
        }
        //$importResults = file_get_contents('/webapp/exportStatus.log');
        //echo 'Результат импорта товаров: ';
        //\Yii::$app->pr->printR2WOChecks($importResults);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()){

            $sectionId = 0;
            $manufacturerId = 0;

            if ( !empty($model->section_id) )  {
                //\Yii::$app->pr->printR2WOChecks($model->getAttributes());
                $sectionId = (int)$model->section_id;

            }

            if ( !empty($model->manufacturer_id) ) {
                $manufacturerId = (int)$model->manufacturer_id;
            }

            //$xmlWriter = new ProductXmlWriter();
            //$xmlWriter->goThrousgSection($sectionId, $manufacturerId);


            exec('nohup php /webapp/yii export/manual '.$sectionId.' '.$manufacturerId.' > /dev/null &');

            ob_end_clean();
            echo "<script type='text/javascript'>  window.location='/admin/export/'; </script>";

        }

        return $this->render('export', [
            'model' => $model,
            'exportResults' => $importResults,
            ]
        );
    }




    public function actionManual(){


        die('hehehe');
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