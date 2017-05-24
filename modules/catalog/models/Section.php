<?php

namespace modules\catalog\models;

use Yii;
use yii\db\Exception;

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
 * @property integer $sort
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
            [['depth_level', 'unique_id'], 'required'],
            [['depth_level', 'sort', 'unique_id', 'parent_id'], 'integer'],
            [['preview_text', 'detail_text'], 'string'],
            [['code', 'name', 'picture'], 'string', 'max' => 255],
            [['unique_id'], 'unique'],
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
            'sort' => 'Sort',
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


    /**
     * Сохранение из парсера
     * @param $group
     */
    public function saveGroup(&$group){
        //print_r($group);
        /**
         * Если $status == 0 удаляем запись
         */
        $status = intval($group->status);
        if($status == 0){

            $selfSection = static::find()
                ->andWhere(['unique_id' => intval($group->id)])
                ->one();

            if($selfSection){
                $trn = Yii::$app->db_postg->beginTransaction();

                try{
                    $selfSection->delete();
                    $trn->commit();
                    $error = '<br/> Удален раздел: ' .strval($group->name) . ' (ID = ' .intval($group->id). ') <br />';

                    Yii::$app->session->setFlash('error_'.intval($group->id), $error);

                }catch (Exception $e){
                    $trn->rollback();

                    $error =  '<br /> Не удалось удалить раздел ' .strval($group->name) . '(ID = ' .intval($group->id). ')<br />';
                    $error .=  $e->getMessage() . '<br />';

                    Yii::$app->session->setFlash('error_'.intval($group->id), $error);
                }

            }

            unset($group);
            return true;
        }

        //\Yii::app()->db_postg->createCommand('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');

        $trn = Yii::$app->db_postg->beginTransaction();
        try {

            /**
             * Проверка на update/insert
             */
            $selfSection = static::find()->andWhere(['unique_id' => intval($group->id)])->one();

            if(!$selfSection){
                $selfSection = new static();
            }

            $selfSection->setAttributes([
                'unique_id' => intval($group->id),
                'depth_level' => intval($group->depth_level),
                'parent_id' => intval($group->parent_id),
                'code' => strval($group->code),
                'name' => strval($group->name),
                'sort' => intval($group->sort),
                'preview_text' => strval($group->preview_text),
                'detail_text' => strval($group->detail_text),
                'picture' => strval($group->picture),
            ]);

            if ($selfSection->save(true)) {

                $trn->commit();

            } else {

                $error = '<br />Ошибка сохранения <pre>' . $group . '</pre><br />';
                Yii::$app->session->setFlash('error_'.intval($group->id), $error);
                /*$errors = $selfSection->getErrors();
                Yii::$app->pr->print_r2($errors);*/
            }

        } catch(Exception $e){
            $trn->rollback();

            $error = '<br />' . $e->getMessage() . '<br />';
            Yii::$app->session->setFlash('error_'.intval($group->id), $error);
        }

        unset($group);

        return true;

    }

}
