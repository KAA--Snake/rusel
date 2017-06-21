<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscribe".
 *
 * @property integer $id
 * @property string $email
 */
class Subscribe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscribe';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_postg');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
        ];
    }
}
