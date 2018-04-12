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

class Info extends ActiveRecord
{
    var $file;

    public static function tableName()
    {
        return 'public.info';
    }


    public function rules()
    {
        return [
            [
                [
                    'big_img_src',
                    'small_img_src',
                    'url'
                 ],
                'string'
            ],
            [['text'], 'string'],
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
        $this->small_img_src = $this->big_img_src;



        if(!empty($this->text)){

            $this->text = htmlentities($this->text);
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


    public function saveMe(){
        $model = $this;


        //\Yii::$app->pr->print_r2($model->getAttributes());
        //die();

        $attributes = [
            'sort' => $model->sort,
            'url' => $model->url,
            'text' => $model->text,
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