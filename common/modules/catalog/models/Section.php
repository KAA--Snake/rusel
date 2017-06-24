<?php

namespace common\modules\catalog\models;

use Yii;
use yii\db\Exception;
use common\helpers\translit\Translit;

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
            [['preview_text', 'detail_text', 'menu_offlink', 'redirect_url'], 'string'],
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
            'id' => 'Id',
            'depth_level' => 'Вложенность раздела',
            'parent_id' => 'Родительский ID',
            'code' => 'Код',
            'name' => 'Название',
            'preview_text' => 'Краткое описание',
            'detail_text' => 'Детальное описание',
            'picture' => 'Картинка',
            'sort' => 'Сортировка',
            'menu_offlink' => 'Ссылка "над" разделом',
            'redirect_url' => 'Ссылка раздела (для перезаписи)',
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
     * Сохранение из парсера (используется при импорте каталога)
     * @param $group
     */
    public function saveGroup(&$group){
        //print_r($group);
        /**
         * Если $status == 0 удаляем запись
         */
        /*$status = intval($group->status);
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
        }*/

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

            $code = strval($group->code);
            $code = str_ireplace(['/','\\'], '', $code);

            /**
             * если не задан код, берем его транслитом
             */
            if(empty($code) || $code == ''){
                $code = strval($group->name);
                $code = Translit::t($code);
            }

            $selfSection->setAttributes([
                'unique_id' => intval($group->id),
                'depth_level' => intval($group->depth_level),
                'parent_id' => intval($group->parent_id),
                'code' => $code,
                'name' => strval($group->name),
                'sort' => intval($group->sort),
                'preview_text' => strval($group->preview_text),
                'detail_text' => strval($group->detail_text),
                'picture' => strval($group->picture),
                'menu_offlink' => strval($group->menu_offlink),
                'redirect_url' => strval($group->redirect_url),
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


    /**
     * Получает полную структуру разделов каталога
     * (используется для создания меню каталога)
     *
     * @return array
     */
    public function getCatalogSections(){
        $allSects = [];
        $allSects = static::find()->asArray()->all();

        $main = [];

        if(count($allSects) > 0){
            /** первоначально соберем разделы сделав ключами их ИДы разделов */
            foreach ($allSects as $k=>$oneSection) {
                $main[$oneSection['unique_id']] = $oneSection;
            }

            foreach($main as $sectionId => $sectionArr){
                //проверим, есть ли ИД текущего раздела в списке всех разделов
                if(array_key_exists($sectionArr['parent_id'], $main) && $sectionArr['parent_id'] != 0){
                    //если есть, то запишем его в подразделы к этому найденному разделу и удалим из списка главных разделов

                }else{
                    //если нет, то оставим

                }




            }

        }

        \Yii::$app->pr->print_r2($allSects);
        return $allSects;
    }







}
