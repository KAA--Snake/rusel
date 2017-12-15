<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.12.17
 * Time: 9:47
 */

namespace common\modules\catalog\models\search;


use common\modules\catalog\models\search\searches\byFiles\BaseFileSearch;
use common\modules\catalog\models\search\searches\FileSearchFabric;
use yii\base\Model;

class SearchByFile extends Model
{

    //public $enableCsrfValidation = false;

    var $file;
    var $filePath;


    public function rules()
    {
        $catalogModule = \Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedSearchFileExtensions'];

        return [
            [
                ['file'],
                'file',
                //'skipOnEmpty' => false,
                'checkExtensionByMimeType' => false, //bug #6148
                'extensions' => $allowedExtensions,
                'maxFiles' => 1
            ],

        ];
    }


    public function attributeLabels()
    {

        return [
            'file' => 'Файл для обработки',
        ];

        //return parent::attributeLabels();
    }


    public function upload()
    {

        $catalogModule = \Yii::$app->getModule('catalog');
        $folder =  $catalogModule->params['uploadSearchDir'];



        if ($this->validate()) {
            $this->filePath = $_SERVER['DOCUMENT_ROOT'].$folder . $this->file->baseName . '.' . $this->file->extension;

            $ret = [
                'filePath' => $this->filePath,
                'extension' => $this->file->extension,
            ];

            $this->file->saveAs($this->filePath);

            return $ret;
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
     * Отдает список артикулов из загруженного файла
     *
     * @param $filePath
     * @return array
     */
    public function getArticlesFromFile($filePath){
        $articlesList = (new BaseFileSearch($filePath['extension'], $filePath['filePath']))->getArticlesList();

        return $articlesList;
    }



}