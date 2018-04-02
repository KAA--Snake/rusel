<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.17
 * Time: 14:38
 */

namespace common\modules\catalog\models;


use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Artikle extends ActiveRecord
{
    var $file;

    public static function tableName()
    {
        return 'public.artikles';
    }


    public function rules()
    {
        return [
            [
                [
                    'big_img_src',
                    'small_img_src',
                    'full_text',
                    'preview_text',
                    'name',
                    'type',
                    'sort',
                    'url',
                ],
                'string'
            ],
            [['date'], 'date', 'format' => 'd-m-Y'],
            [['file'],
                'file',
                //'skipOnEmpty' => false,
                'checkExtensionByMimeType' => false, //bug #6148
                //'extensions' => $allowedExtensions,
                'maxFiles' => 1],
            [['id','big_img_width', 'big_img_height', 'small_img_width', 'small_img_height', 'sort'], 'integer'],
        ];
    }


    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        /**
         *  @TODO Здесь надо генерить миникартинку
         * пока что миникартинка = большой картинке
         *
         */
        if(empty($this->small_img_src)){

            $this->small_img_src = $this->big_img_src;
        }


        if(!empty($this->full_text)){

            $this->full_text = htmlentities($this->full_text);
        }

        if(!empty($this->preview_text)){

            $this->full_text = htmlentities($this->full_text);
        }



        //\Yii::$app->pr->print_r2($insert);

        // ...custom code here...
        return true;
    }



    public function upload()
    {

        $folder =  $_SERVER['DOCUMENT_ROOT'].'/upload/artikles/'; //$_SERVER['DOCUMENT_ROOT'] = /webapp

        if ($this->validate()) {
            $filePath = $folder . $this->file->baseName . '.' . $this->file->extension;

            $this->file->saveAs($filePath);

            $imgResult = getimagesize($filePath);
            $imgResult['big_img_src'] = '/upload/artikles/'. $this->file->baseName . '.' . $this->file->extension;


            return $imgResult;
        } else {
            return false;
        }
    }


    public function __get($name) {
        switch ($name ) {
            case 'date':
                //return date('d.m.Y', strtotime($this->getAttribute('date')));
                break;
            case 'preview_text':

                return html_entity_decode($this->getAttribute('preview_text'));
                break;

            case 'full_text':

                return html_entity_decode($this->getAttribute('full_text'));
                break;

        }


        return parent::__get($name);
    }


    public function saveMe(){
        $model = $this;


        //\Yii::$app->pr->print_r2($model->getAttributes());
        //die();


        $attributes = [
            'type' => $model->type,
            'sort' => $model->sort,
            'url' => $model->url,
            'full_text' => $model->full_text,
            'preview_text' => $model->preview_text,
        ];

        $model->file = UploadedFile::getInstance($model, 'file');

        if(!empty($model->file)){

            $savedImgResult = $model->upload();

            if ($savedImgResult) {

                //\Yii::$app->pr->print_r2($model->getAttributes());
                $attributes['big_img_src'] = $savedImgResult['big_img_src'];
                $attributes['big_img_width'] = $savedImgResult[0];
                $attributes['big_img_height'] = $savedImgResult[1];
            }

        }

        //если обновляем запись, то подменяем текущую модель той которую обновляем
        if(isset($model->id) && $model->id > 0 && !empty($model->id)){
            $model = self::findOne($model->id);

        }else{
            //SiC bug null != empty...
            unset($model->id);
        }


        $model->setAttributes($attributes);

        $model->save();


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