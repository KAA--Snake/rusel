<?php

namespace common\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "public.section".
 *
 * @property integer $id
 * @property integer $depth_level
 * @property integer $parent_id
 * @property string $code
 * @property string $name
 * @property string $preview_text
 * @property string $detail_text
 * @property string $picture
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.section';
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
            [['depth_level'], 'required'],
            [['depth_level', 'parent_id'], 'integer'],
            [['preview_text', 'detail_text'], 'string'],
            [['code', 'name', 'picture'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['parent_id'], 'unique'],
            [['code'], 'unique'],
            [['parent_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'depth_level' => 'Depth Level',
            'parent_id' => 'Parent ID',
            'code' => 'Code',
            'name' => 'Name',
            'preview_text' => 'Preview Text',
            'detail_text' => 'Detail Text',
            'picture' => 'Picture',
        ];
    }

    /**
     * @inheritdoc
     * @return SectionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SectionQuery(get_called_class());
    }
}
