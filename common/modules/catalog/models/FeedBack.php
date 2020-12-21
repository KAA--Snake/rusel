<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.17
 * Time: 14:38
 */

namespace common\modules\catalog\models;

use yii\base\Model;
use yii\web\UploadedFile;

class FeedBack extends Model
{
    public $fio;
    public $phone;
    public $email;
    public $company;
    public $text;

    public $file;


    public function rules()
    {
        return [
            [
                [
                    'fio',
                    'phone',
                    'email',
                    'company',
                    'text',
                ],
                'string'
            ],
            [['file'],
                'file',
                //'skipOnEmpty' => false,
                'checkExtensionByMimeType' => false, //bug #6148
                //'extensions' => $allowedExtensions,
                'maxFiles' => 1],
            //[['id','big_img_width', 'big_img_height', 'small_img_width', 'small_img_height'], 'integer'],
            //[['email', 'phone', 'text'], 'required'],
        ];
    }


    public function upload()
    {

        $folder =  $_SERVER['DOCUMENT_ROOT'].'/upload/feedback/'; //$_SERVER['DOCUMENT_ROOT'] = /webapp

        if ($this->validate()) {
            $filePath = $folder . $this->file->baseName . '.' . $this->file->extension;

            $this->file->saveAs($filePath);

            return $filePath;
        } else {
            return false;
        }
    }


    public function saveMe(){
        $model = $this;

        $model->file = UploadedFile::getInstance($model, 'file');

        if(!empty($model->file)){


            $filePath = $model->upload();

            if ($filePath) {

                \Yii::$app->pr->print_r2($filePath);

                //здесь делать отправку письма


                //здесь удалять $filePath
            }

        }

        return $model;

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

}