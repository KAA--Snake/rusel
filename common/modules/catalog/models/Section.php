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

    private $catalogTree;
    private $reParented = [];
    private $url;

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
            [['preview_text', 'detail_text', 'menu_offlink', 'redirect_url', 'url'], 'string'],
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
            'url' => 'URL',
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
     * @return bool
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

        $allSects = static::find()->asArray()->all();

        return $this->buildTree($allSects);

    }


    /**
     *
     * @param $data
     * @param int $rootID
     * @return array
     */
    protected function buildTree(&$data, $rootID = 0) {

        $tree = array();

        foreach ($data as $id => $node) {
            if ($node['parent_id'] == $rootID) {
                unset($data[$id]);

                $node['childs'] = $this->buildTree($data, $node['unique_id']);
                $tree[] = $node;
            }
        }
        return $tree;
    }


    /**
     * Генерирует УРЛы для таблицы разделов
     *
     * @return bool
     */
    public function generateUrls(){

        $allSects = static::find()->all();
        //$allSects = static::find()->asArray()->all();

        foreach($allSects as $section){
            $this->reParented[$section->unique_id] = $section;
        }

        foreach($allSects as $k=>$section){
            $this->url = '';
            $this->addParentsCode($section->parent_id);
            $this->url .= $section->code.'/';

            $section->setAttribute('url', $this->url);
            $section->save();

        }

        //\Yii::$app->pr->print_r2($allSects);
        //\Yii::$app->pr->print_r2($this->reParented);

        //$tree = $this->buildTree2($allSects);
        return true;
    }



    /**
     * рекурсивно получает разделы родителя и достраивает по ним УРЛ
     *
     * @param $sectionUniqueId
     * @return string
     */
    protected function addParentsCode($sectionUniqueId){

        if(!empty($this->reParented[$sectionUniqueId])){

            $url = explode('/', $this->url);

            //добавим к первому элементу массива- код родителя
            array_unshift($url, $this->reParented[$sectionUniqueId]->code);

            $this->url = implode('/', $url);

            if($this->reParented[$sectionUniqueId]->parent_id > 0){//если не дошли до верхнего уровня каталога
                $this->addParentsCode($this->reParented[$sectionUniqueId]->parent_id);
            }

        }

        return $this->url;

    }

}
