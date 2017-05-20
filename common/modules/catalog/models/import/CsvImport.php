<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 13:42
 */

namespace app\common\modules\catalog\models\import;


use yii\base\Model;

class CsvImport extends Model
{


    var $csvFile;

    public function rules()
    {
        return [];

        //пока не ограничиваем
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }


    public function upload()
    {

        if ($this->validate()) {
            $this->csvFile->saveAs(__DIR__.'/upload_csv/' . $this->csvFile->baseName . '.' . $this->csvFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function massUpload()
    {

        // echo __DIR__;
        //die();


        if ($this->validate()) {
            foreach ($this->csvFile as $file) {
                $file->saveAs(__DIR__.'/upload_csv/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}