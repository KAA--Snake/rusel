<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.01.18
 * Time: 17:35
 */

namespace console\controllers;
set_time_limit(0);

use common\modules\catalog\modules\admin\models\import\CatalogImport;
use yii\console\Controller;

class ImportController extends Controller
{
    public function actionManual($filename = false){


        file_put_contents('/webapp/import.log', 'Start import: '.date("H:i:s"), FILE_APPEND);

        if(!$filename) return false;


        $erpParams = \Yii::$app->getModule('catalog')->params['erp'];
        //$postData = \Yii::$app->getRequest()->post();

        //$postData['file_name'] = 'list-1-1516437522108.xml';
        $postData['file_name'] = $filename;

        //\Yii::$app->pr->print_r2($postData);


        //запустить импорт
        if(isset($postData['file_name']) && !empty($postData['file_name'])){

            unset($_SESSION['ERRORS']);

            //file_put_contents('/webapp/import.log', 'Start import: '.date("H:i:s"), FILE_APPEND);
            //\Yii::error('start process as '. date('H:i:s'));
            $catalogImportModel = new CatalogImport();

            //$catalogImportModel = new CatalogImport();
            //echo $_SERVER['DOCUMENT_ROOT'];
            //die();
            $catalogImportModel->filePath = $erpParams['upload_folder'].$postData['file_name'];

            //while(true){
            $catalogImportModel->import();
            //}

            //$catalogImportModel->filePath = '/webapp/upload/erp/list1502263897108.txt';

            //$catalogImportModel->import();
            //return json_encode(['IMPORT_RESULT' => 'DONE']);



            /*$resUlt = [
                'RES' => 'DONE',
                'ERRORS' => $_SESSION['ERRORS']
            ];*/
            //$catalogImportModel->sendRespondToErp($postData['file_name'], $resUlt);
            file_put_contents('/webapp/import.log', 'End import: '.date("H:i:s"), FILE_APPEND);
            //\Yii::info('end process as '. date('H:i:s'));

            return true;
            //return json_encode();

        }

    }
}