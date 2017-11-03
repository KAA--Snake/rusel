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
            [['m_name', 'm_text', 'm_group_ids'], 'string'],
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
            'm_text' => 'Описание',
            'm_group_ids' => 'ИД групп',
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

    /**
     * Возвращает список всех производителей
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAllManufacturers(){
        $result = static::find()
            ->orderBy('m_name')
            ->asArray()
            ->all();

        return $result;
    }


    /**
     * Сохранение из парсера (используется при импорте каталога)
     * @param $proizv
     * @return bool
     * @internal param $group
     */
    public function saveProizvoditel(&$proizv){

        /*var_dump($proizv);
        return true;*/

        //\Yii::app()->db_postg->createCommand('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');

        $trn = Yii::$app->db_postg->beginTransaction();
        try {

            $selfSection = new static();
            $r = [
                'm_id' => intval($proizv->proizv_id),
                'm_name' => strval($proizv->proizv_name),
                'm_text' => strval($proizv->proizv_text),
                'm_group_ids' => strval($proizv->proizv_group_id),
            ];

            $selfSection->setAttributes([
                'm_id' => intval($proizv->proizv_id),
                'm_name' => strval($proizv->proizv_name),
                'm_text' => strval($proizv->proizv_text),
                'm_group_ids' => strval($proizv->proizv_group_id),

            ]);
            //Yii::$app->pr->print_r2($r);


            if ($selfSection->save(true)) {

                $trn->commit();

            } else {

                $error = '<br />Ошибка сохранения <pre>' . $proizv . '</pre><br />';
                Yii::$app->session->setFlash('error_'.intval($proizv->proizv_id), $error);
                /*$errors = $selfSection->getErrors();
                Yii::$app->pr->print_r2($errors);*/
            }

        } catch(Exception $e){
            $trn->rollback();

            $error = '<br />' . $e->getMessage() . '<br />';
            Yii::$app->session->setFlash('error_'.intval($proizv->proizv_id), $error);
        }

        unset($proizv);

        return true;

    }



}
