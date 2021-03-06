<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.01.18
 * Time: 17:35
 */

namespace console\controllers;
set_time_limit(0);

use common\modules\catalog\models\catalog_import\Import_log;
use common\modules\catalog\modules\admin\models\import\CatalogImport;
use yii\console\Controller;
use yii\db\Exception;
use yii\redis\Cache;

class ImportController extends Controller
{
    public function actionManual($filename = false){



        //file_put_contents('/webapp/import.log', 'Start import: '.date("H:i:s"), FILE_APPEND);

        if(!$filename) return false;

        $erpParams = \Yii::$app->getModule('catalog')->params['erp'];
        //$postData = \Yii::$app->getRequest()->post();

        //$postData['file_name'] = 'list-1-1516437522108.xml';
        $postData['file_name'] = trim($filename);

        //\Yii::$app->pr->print_r2($postData);


        //запустить импорт
        if(isset($postData['file_name']) && !empty($postData['file_name'])){



            //unset($_SESSION['ERRORS']);

            //file_put_contents('/webapp/import.log', 'Start import: '.date("H:i:s"));
            //\Yii::error('start process as '. date('H:i:s'));
            $catalogImportModel = new CatalogImport();



            //первичное сохранение логгера
            Import_log::deleteAll(); //сначала чистим
            Import_log::$currentImportModel = [
                'import_file_name' => $postData['file_name'],
                'import_status' => 0,
                'start_date' => date('Y-m-d H:i:s'),

            ];
            Import_log::checkAndSave();

            $catalogImportModel->filePath = trim($erpParams['upload_folder'].$filename);

            $catalogImportModel->import();

	        /** запускаем проход по импортированному каталогу и генерим ему урлы*/
	        $catalogImportModel->generateCatalogUrls();


            /** @var Cache $cache */
            $cache = \Yii::$app->cache;
            $cache->flush();

	        $resUlt = [
		        'RES' => 'DONE',
		        'ERRORS' => $_SESSION['ERRORS']
	        ];
	        $catalogImportModel->sendRespondToErp($postData['file_name'], $resUlt);

            return true;
            //return json_encode();

        }

    }
}