<?php

namespace common\modules\catalog\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use common\helpers\translit\Translit;
use yii\helpers\Url;
use common\models\elasticsearch\Product;

/**
 * This is the model class for table "public.manufacturer".
 *
 * Содержит список производителей и их ИДы
 *
 * @property integer $id
 * @property integer $m_id
 * @property string $m_name
 */
class Manufacturer extends \yii\db\ActiveRecord
{

    private $catalogModule;

    public function __construct(){
        //сохраняем ссылку на модуль, чтоб не тягать постоянно
        $this->catalogModule = \Yii::$app->getModule('catalog');

        parent::__construct();
    }





    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.manufacturer';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_postg');
    }

   /* public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                // 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }*/


    /** нужно для построение tree */
    /*public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id'], 'required'],
            [['m_id'], 'integer'],
            [['m_name'], 'string'],
            [['m_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'm_id' => 'Уникальный ID',
            'm_name' => 'Название',
        ];
    }


    /**
     * Возвращает производителя по его названию
     *
     * @param string $name
     * @return array
     */
    public function getByName($name=''){
        if($name == '') return [];

        $result = static::find()->andWhere([
            'm_name' => $name
        ])->one();

        return $result;

    }


}
