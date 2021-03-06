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
    public $reCaptcha;

    public $formUrl;

    public $fio;
    public $phone;
    public $email;
    public $company;
    public $text;
    public $inn;

    /** @var UploadedFile */
    public $file;

    public $filepath;
    public $fileUrl = 'http://rusel24.ru/upload/feedback/';

    public $artikul;
    public $productName;
    public $manufacturer;
    public $productCount = '1';

    private $isFileAttached = false;


    public function rules()
    {
        return [
            [
                [
                    'formUrl',

                    'fio',
                    'phone',
                    'email',
                    'company',
                    'text',
                    'inn',

                    //приложенный файл
                    'filepath',
                    'fileUrl',

                    //товар
                    'productName',
                    'artikul',
                    'manufacturer',
                    'productCount',
                ],
                'string'
            ],
            [['file'],
                'file',
                //'skipOnEmpty' => false,
                'checkExtensionByMimeType' => false, //bug #6148
                //'extensions' => $allowedExtensions,
                'maxSize' => 1024 * 1024 * 5,
                'maxFiles' => 1,
                //'allowEmpty' => true
            ],
            //[['id','big_img_width', 'big_img_height', 'small_img_width', 'small_img_height'], 'integer'],
            [['email', 'phone', 'fio'], 'required'],
            [['filepath', 'fileUrl'], 'safe'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => '6LeJeg8aAAAAAOoO_-rN0--_aj2TPOgurXaAJutg', // unnecessary if reСaptcha is already configured
                'uncheckedMessage' => 'Пожалуйста, подтвердите что вы не бот.'],
            //[['productName', 'manufacturer', 'artikul', 'productCount'], 'string', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'file' => 'Прикрепить файл',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'company' => 'Организация или ИП',
            'text' => 'Текст сообщения',
            'inn' => 'ИНН',
            'productCount' => 'Количество',
            'reCaptcha' => '',
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {

        $folder =  $_SERVER['DOCUMENT_ROOT'].'/upload/feedback/'; //$_SERVER['DOCUMENT_ROOT'] = /webapp

        if ($this->validate()) {
            $this->filepath = $folder . $this->file->baseName . '.' . $this->file->extension;
            $this->fileUrl .= $this->file->baseName . '.' . $this->file->extension;

            $this->file->saveAs($this->filepath);

            $this->isFileAttached = true;

            return true;
        } else {
            //$this->addError('file', 'СЛИШКОМ БОЛЬШОЙ ФАЙЛ !');
            return false;
        }
    }


    public function saveMe(){
        $model = $this;

        $model->file = UploadedFile::getInstance($model, 'file');

        if(!empty($model->file)){
            $model->upload();
        }

        return $model;
    }

    public function sendMail(){

        $params = ['feedback' => $this]; //передаем текущий заказ

        $params['date'] = date('Y-m-d H:i:s');
        $params['isFileAttached'] = $this->isFileAttached;

        $emailParams = \Yii::$app->getModule('catalog')->params['email'];

        //$products = (array) json_decode($this->getAttributes()['products']);


        //\Yii::$app->pr->print_r2($params);
        try{
            //отправка уведомления для админа
            \Yii::$app->mailer->compose([
                'html' => 'views/feedback/feedback.php',
                //'text' => 'views/order/order.created.admin.php',
            ], $params)
                ->setTo([$emailParams['feedback'] => 'Admin'])
                ->setSubject('Rusel24.ru: Сообщение от ' .date('Y-m-d H:i:s'))
                ->send();
        }catch(Exception $exception){
            //\Yii::$app->pr->print_r2($exception->getMessage());
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