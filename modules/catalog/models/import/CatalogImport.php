<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 13:42
 */

namespace modules\catalog\models\import;

set_time_limit(0);
$start_time = microtime(true);

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
     */
    public function importGroups(){

        $files = array($this->filePath);
        //\Yii::$app->pr->print_r2($files);
        foreach($files as $file) {
            $reader = new GroupParser($file);
            $reader->setModel(\modules\catalog\models\Section::className());
            $reader->parse();
        }
    }
}