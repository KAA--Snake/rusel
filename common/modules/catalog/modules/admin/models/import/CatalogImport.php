<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 13:42
 */

namespace common\modules\catalog\modules\admin\models\import;

set_time_limit(0);
$start_time = microtime(true);

use common\modules\catalog\models\mongo\Product;
use common\modules\catalog\models\Section;
use yii\base\Model;


class CatalogImport extends Model
{

    public $enableCsrfValidation = false;

    var $file;
    var $filePath;

    public function rules()
    {
        $catalogModule = \Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedExtensions'];

        return [
            [['file'],
                'file',
                'skipOnEmpty' => false,
                'checkExtensionByMimeType' => false, //bug #6148
                'extensions' => $allowedExtensions,
                'maxFiles' => 1],
        ];
    }


    public function upload()
    {

        $catalogModule = \Yii::$app->getModule('catalog');
        $folder =  '/'.$catalogModule->params['importFolderName'].'/';

        if ($this->validate()) {
            $this->filePath = __DIR__.$folder . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs($this->filePath);
            return true;
        } else {
            return false;
        }
    }

    /*public function massUpload()
    {

        $catalogModule = \Yii::$app->getModule('Catalog');
        $catalogModule->params['csvFolderName'];

        if ($this->validate()) {

            foreach ($this->csvFile as $file) {
                $file->saveAs(__DIR__.'/upload_csv/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }*/


    /**
     * Сам импорт
     *
     * распознавание что именно импортируется, происходит в парсере далее
     */
    public function import(){

        $files = array($this->filePath);

        foreach($files as $file) {
            $reader = new CatalogXmlReader($file);
            $reader->parse();
            unset($reader);
        }
    }


    /**
     * Генерирует УРЛы для ВСЕХ разделов и элементов каталога,
     * используется после того как был сделан импорт.
     *
     * Также возможно использование без импорта (для перегенерации, если надо)
     *
     * @return bool
     */
    public function generateCatalogUrls(){
        //взять объект Section и сгенерить для него УРЛЫ
        $sectionModel = new Section();
        $sectionModel->generateUrls();

        //взять объект Product и сгенерить для него УРЛЫ
        //$productModel = new Product();
        //$productModel->generateUrls();



        return true;
    }


}