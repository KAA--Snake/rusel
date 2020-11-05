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
use common\modules\catalog\models\mongo\Product;
use common\modules\catalog\models\Section;
use common\modules\catalog\modules\admin\models\export\CatalogExport;
use common\modules\catalog\modules\admin\models\export\ProductXmlWriter;
use common\modules\catalog\modules\admin\models\export\XmlWriter;
use phpDocumentor\Reflection\Location;
use Yii;
use yii\filters\AccessControl;
use yii\web\HttpException;
use yii\web\UploadedFile;


class ExportController extends Controller
{
    public function actionManual($sectionId = false){

        //file_put_contents('/webapp/import.log', 'Start import: '.date("H:i:s"), FILE_APPEND);
        if(!$sectionId) {
            return;
        }
        //$erpParams = \Yii::$app->getModule('catalog')->params['erp'];

        //$postData = \Yii::$app->getRequest()->post();

        //$postData['file_name'] = 'list-1-1516437522108.xml';
        $sectionId = (int)$sectionId;

        try {
            $xmlWriter = new ProductXmlWriter();
        } catch (\Exception $ex) {
            file_put_contents('/webapp/export.log', $ex->getMessage(),  FILE_APPEND);
        }

        $xmlWriter->goThrousgSection($sectionId);

    }
}