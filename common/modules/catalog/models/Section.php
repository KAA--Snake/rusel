<?php

namespace common\modules\catalog\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use common\helpers\translit\Translit;
use yii\helpers\Url;
use common\models\elasticsearch\Product;

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

    private $reParented = [];
    private $url;
    private $right; //правая граница дерева

    //сюда падает уровень вложенности при рекурсивном составлении дерева
    public $recursiveLevel = 1;
    public $subLevel = 1;

    public $childs;

    //для хранения ссылки на модуль
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
        return 'public.section';
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
            [['depth_level', 'unique_id'], 'required'],
            [['depth_level', 'sort', 'unique_id', 'parent_id', 'lft', 'rgt'], 'integer'],
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
            'id' => 'id',
            'unique_id' => 'Уникальный ID',
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
     * Получает раздел каталога по unique_id,
     *
     * @param $sectionUniqueId
     * @return array
     */
    public function getSectionByUniqueId($sectionUniqueId){
        $returnData = [];

        $currentSection = static::find()->andWhere([
            'unique_id' => $sectionUniqueId
        ])->one();


        return $currentSection;
    }


    /**
     * Выводит корневые разделы каталога
     * (используется для захода по адресу /catalog/)
     *
     * @return array
     */
    public function getRootSections(){

        $rootSections = [];

        //$sectionsCount = $this->catalogModule->params['max_sections_cnt'];

        $query = Section::find()->andWhere([
            'depth_level' => 1
        ]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            /*'pagination' => [
                'pageSize' => $sectionsCount,
            ],*/
            'sort' => [
                'defaultOrder' => [
                    'depth_level' => SORT_ASC,
                    //'name' => SORT_DESC
                ]
            ],
        ]);

        // returns an array of Section objects
        $rootSections = $provider->getModels();

        //\Yii::$app->pr->print_r2($rootSections);
        //return '';

        return $rootSections;
    }

    /**
     * Получает раздел каталога и всех его потомков по УРЛу,
     * можно указать максимальную глубину для подразделов
     *
     * @param $url
     * @param bool $maxDepthLevel
     * @return array
     * @internal param bool $asArray
     */
    public function getSectionByUrl($url, $maxDepthLevel=false){

        $returnData = [];
        $returnData['currentSection'] = [];
        $returnData['unGroupedSiblings'] = [];
        $returnData['groupedSiblings'] = [];
        $returnData['currentSectionProducts'] = []; //товары текущего раздела


        /** добавляем в конце слеш, т.к. у нас suffix = '/' */
        $url = $url.'/';

        /** достаем выбранный раздел */
        $returnData['currentSection'] = static::find()->andWhere([
            'url' => $url
        ])->one();

        /** достаем всех дочерние разделы */
        if($returnData['currentSection']){

            $mtn = 'lft > ' .$returnData['currentSection']->lft;
            $ltn = 'rgt < '.$returnData['currentSection']->rgt;

            $subsectionsQuery = static::find()->andWhere(['and', $mtn, $ltn]);

            /** если надо, то ограничим уровень вложенности */
            if($maxDepthLevel){
                $maxDepthLevel = $returnData['currentSection']->depth_level + $maxDepthLevel;

                $subsectionsQuery->andWhere([
                    '<=', 'depth_level', $maxDepthLevel
                ]);
            }

            $returnData['unGroupedSiblings'] = $subsectionsQuery->orderBy('depth_level, parent_id, sort ASC')->all();

            $unGroupedSiblings = $subsectionsQuery->orderBy('depth_level, parent_id, sort ASC')->all();

            //$returnData['unGroupedSiblings'] = $unGroupedSiblings;

            /** группировка подразделов */
            $returnData['groupedSiblings']= $this->groupSubsections($unGroupedSiblings, $returnData['currentSection']->unique_id);


        }


        /** достаем товары привязанные к текущему разделу */
        $productModel = new Product();
        if(!empty($returnData['currentSection']['unique_id']) && $returnData['currentSection']['unique_id'] > 0){
            $sectionProducts = $productModel->getProductsBySectionId($returnData['currentSection']['unique_id']);
            //\Yii::$app->pr->print_r2($sectionProducts);
            $returnData['currentSectionProducts'] = $sectionProducts['products'];
            $returnData['paginator'] = $sectionProducts['paginator'];
            $returnData['totalProductsFound'] = $sectionProducts['totalProductsFound'];
        }



        return $returnData;
    }



    private function groupSubsections($data, $rootID=false){

        $tree = array();

        foreach ($data as $id => $node) {

            if ($node->parent_id == $rootID) {
                //unset($data[$id]);
                //continue;

                $node->childs = $this->buildTree($data, $node->unique_id);
                $tree[$node->name] = $node;
            }
        }

        //\Yii::$app->pr->print_r2($tree);

        return $tree;


        /*foreach($sections as $oneSibling){
            $grouped[$oneSibling->depth_level][] = $oneSibling->getAttributes();
        }*/
        //\Yii::$app->pr->print_r2($grouped);

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
                //'depth' => strval($group->depth_level),
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
     * Рекурсивно выводит структуру каталога
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
     * Находит всех родителей для текущего раздела (для хлебных крошек)
     *
     * @param $section
     * @return array
     */
    public function getParents($section){
        //\Yii::$app->pr->print_r2($section->getAttributes());
        /** @var Section $section */

        if(is_numeric($section->lft)){

            $ltn = 'lft < ' . $section->lft;
            $mtn = 'rgt > ' . $section->rgt;

            //$subsectionsQuery = static::find()->andWhere(['and', $mtn, $ltn]);
            $parents = static::find()
                //->select(['url', 'upper(name) as label'])
                ->select(['url', 'name as label'])
                ->andWhere($ltn)
                ->andWhere($mtn)
                //->andWhere('depth_level < ' . $section->depth_level)
                ->orderBy('depth_level ASC')
                ->asArray()
                ->all();

            //\Yii::$app->pr->print_r2($parents);
            $parents[] = [
                'url' => $section->getAttribute('url'),  //для последнего урл не будет
                //'label' => mb_strtoupper($section->name),
                'label' => $section->name,
                'finalItem' => true,
            ];

            return $parents;
        }
        return [];

    }


    /**
     * Выводит в каталоге список
     *
     * @param $oneSibling
     * @return array
     * @internal param int $level
     * @internal param $groupedSiblings
     * @internal param $data
     * @internal param int $rootID
     */
    public function listTree($oneSibling){

        //\Yii::$app->pr->print_r2($oneSibling);

        if($this->recursiveLevel === 1){
            $sub = '';
            echo '<ul class="catalog_tree lv'.$this->recursiveLevel.'">';
        }else{
            $sub = ' sublvl';
            echo '<ul class="catalog_tree lv'.$this->recursiveLevel.' sublvl collapsed">';
        }



        $overallChildsCnt = count($oneSibling);

        $cnt = 0;
        foreach ($oneSibling as $id => $oneChild) {
            $classFst= '';
            if($cnt == 0 && $this->recursiveLevel === 1){
                $classFst .= ' ct_first';
            }

            $cnt++;

            $class='';
            if($overallChildsCnt == 1){
                $class .= ' ct_last';
            }

            if(count($oneChild->childs) > 0){
                $class .= ' ct_dir';
                $class .= ' child_collapsed';
            }

            echo '<li class="ct_item'.$class.$classFst.$sub.'">';

            $url = Url::toRoute(['@catalogDir/' . $oneChild->getAttribute('url')]);
            echo '<a href="'.$url.'">'.$oneChild->name.'</a>';

            if(isset($oneChild->childs) && count($oneChild->childs) > 0){
                $this->recursiveLevel++;
                $this->listTree($oneChild->childs);
            }

            echo '</li>';

            $overallChildsCnt--;
            //\Yii::$app->pr->print_r2($node->getAttributes());
        }




        echo '</ul>';
        //return $tree;
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


    /**
     * рекурсивное построение дерева для разделов каталога
     *
     * @param $parentSection
     * @param $left
     * @return mixed
     */
    private function __rebuild_tree($parentSection, $left) {
        // the right value of this node is the left value + 1
        $right = $left+1;

        // get all children of this node
        $parentUniqueId = $parentSection->unique_id;
        $siblingSections = static::find()->andWhere([
            'parent_id' => $parentUniqueId,
        ])->all();

        if(count($siblingSections) > 0){
            foreach($siblingSections as $oneSiblingSection){
                $right = $this->__rebuild_tree($oneSiblingSection, $right);
            }
        }

        // we've got the left value, and now that we've processed
        // the children of this node we also know the right value
        $parentSection->setAttribute('lft', $left);
        $parentSection->setAttribute('rgt', $right);
        $parentSection->save(false);

        // return the right value of this node + 1
        $this->right = $right+1;
        return $right+1;
    }


    /**
     * Пересобирает таблицу, создавая связи для дерева.
     * Используется при импорте разделов каталога
     * ИЛИ при изменении (ручном) разделов каталога (@TODO - сделать)
     *
     * @return bool
     */
    public function generateTree(){

        //всегда должен быть рутовый раздел. Цикл будет по ним
        $rootSections = Section::find()->andWhere([
            'depth_level' => 1
        ])
            ->orderBy([
                'sort' => SORT_ASC,
            ])
            ->all();

        //\Yii::$app->pr->print_r2($rootSections);
        $this->right = 1;
        foreach($rootSections as $rootSection){
            $this->__rebuild_tree($rootSection, $this->right);
        }

        return true;
    }




}
