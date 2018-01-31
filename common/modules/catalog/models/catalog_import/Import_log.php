<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.09.2017
 * Time: 18:29
 */

namespace common\modules\catalog\models\catalog_import;


class Import_log extends \yii\db\ActiveRecord
{

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
            'start_date',
            'end_date',
        ];
    }



}