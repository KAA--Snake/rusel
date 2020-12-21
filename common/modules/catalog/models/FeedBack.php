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

    public $filepath;
    public $fileUrl = 'http://rusel24.ru/upload/feedback/';


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

                    'filepath',
                    'fileUrl',
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
            [['filepath', 'fileUrl'], 'safe'],
        ];
    }


    public function upload()
    {

        $folder =  $_SERVER['DOCUMENT_ROOT'].'/upload/feedback/'; //$_SERVER['DOCUMENT_ROOT'] = /webapp

        if ($this->validate()) {
            $this->filepath = $folder . $this->file->baseName . '.' . $this->file->extension;
            $this->fileUrl .= $this->file->baseName . '.' . $this->file->extension;

            $this->file->saveAs($this->filepath);

            return true;
        } else {
            return false;
        }
    }


    public function saveMe(){
        $model = $this;

        $model->file = UploadedFile::getInstance($model, 'file');

        if(!empty($model->file)){

            if ($model->upload()) {

                //здесь делать отправку письма
                $this->sendMail();

                //здесь удалять $filePath
            }

        }

        return $model;

    }

    public function sendMail(){

        $params = ['feedback' => $this]; //передаем текущий заказ

        $params['date'] = date('Y-m-d H:i:s');

        $emailParams = \Yii::$app->getModule('catalog')->params['email'];

        //$products = (array) json_decode($this->getAttributes()['products']);


        //\Yii::$app->pr->print_r2($this->getAttributes()['products']);
        try{
            //отправка уведомления для админа
            \Yii::$app->mailer->compose([
                'html' => 'views/feedback/feedback.php',
                //'text' => 'views/order/order.created.admin.php',
            ], $params)
                ->setTo([$emailParams['feedback'] => 'Admin'])
                ->setSubject('Rusel24.ru: Обратная связь ' .date('Y-m-d H:i:s'))
                ->send();
        }catch(Exception $exception){
            \Yii::$app->pr->print_r2($exception->getMessage());
            //file_put_contents('/webapp/upload/orders_errors', 'Не удалось отправить на почту заказ '.$this->id, FILE_APPEND );
        }


        return true; //пока не делаем рассылку для клиентов

        //шаблоны для клиента - решили не отправлять ничего клиентам
        /*\Yii::$app->mailer->compose([
            'html' => 'views/order/order.' . $view . '.html.php',
            'text' => 'views/order/order.' . $view . '.text.php',
        ], $params)
            ->setTo([$this->email => $fio])
            ->setSubject('Успешно оформлен заказ Rusel24.ru')
            ->send();*/

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