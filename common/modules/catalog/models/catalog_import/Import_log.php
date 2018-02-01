<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.09.2017
 * Time: 18:29
 */

namespace common\modules\catalog\models\catalog_import;


use yii\db\Exception;

class Import_log extends \yii\db\ActiveRecord
{
    /** @var  array $currentImportModel*/
    public static $currentImportModel;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.import_log';
    }


    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return \Yii::$app->get('db_postg');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['import_file_name', 'import_status'], 'required'],
            [['import_file_name', ], 'string'],
            [['import_status', ], 'integer'],
            [['imported_cnt', ], 'integer'],
            [['start_date', ], 'datetime'],
            [['end_date', ], 'datetime'],
            [['errors_log', ], 'string'],

        ];
    }

    public function attributes(){
        return [
            'id',
            'import_file_name',
            'import_status',
            'imported_cnt',
            'start_date',
            'end_date',
            'errors_log',
            //'currentImportModel',
        ];
    }


    /**
     * Возвращает запись из лога по имени файла
     *
     * @param bool $filename
     * @return array
     */
    public function getByFileName($filename=false){
        $res = [];

        if(!$filename) return [];


        $res = static::find()->andWhere(
            ['import_file_name' => $filename]
        )->one();

        return $res;
    }


    /**
     * сохраняет в логе запись по импорту (чтобы можно было смотреть за процессом)
     */
    public static function checkAndSave(){

        /**
         * Проверка на update/insert
         */
        $self = $res = static::find()->andWhere(
            ['import_file_name' => Import_log::$currentImportModel['import_file_name']]
        )->one();

        if(!$self){
            $self = new static();
        }

        //print_r($self->getAttributes());

        $self->setAttributes(Import_log::$currentImportModel);
        $self->save(false);


    }

}