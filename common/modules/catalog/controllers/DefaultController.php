<?php

namespace common\modules\catalog\controllers;

use common\modules\catalog\models\mongo\Product;
use common\modules\catalog\models\Section;
use yii\web\Controller;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends Controller
{
    public $layout = 'catalog';



    public function import(){
        $section = new Section();

        $section->setAttributes([
            //'id' => 5,
            'unique_id' => '10',
            'depth_level' => 2,
            'parent_id' => '2',
            'code' => 'razdel_second_level_1',
            'name' => 'Раздел второго уровня_1',
            'sort' => 100,


            'preview_text' => 'Превью текст',
            'detail_text' => 'Детальный текст',
            'picture' => '/images/klemms.jpg',

        ]);

        if($section->insert()){

        }else{
            $errors = $section->getErrors();
            \Yii::$app->pr->print_r2($errors );

        }

        return 'done';
    }



    /**
     * Точка входа для всего каталога
     *
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($pathForParse = false)
    {
        //для нулевого уровня каталога показываем только главные разделы
        if(!$pathForParse){
            $rootSections = Section::find()->andWhere([
                'depth_level' => 1
            ])
            ->orderBy([
                'depth_level' => SORT_ASC,
                //'sort' => SORT_ASC,
            ])
            ->all();


            //\Yii::$app->pr->print_r2($rootSections);
            //return '';
            return $this->render('catalogRoot', ['rootSections' => $rootSections]);
        }

        /** есть ли такой товар */
        $productWhere = [
            'url' => $pathForParse
        ];
        $product = Product::find()->andWhere($productWhere)->one();
        if($product){
            \Yii::$app->pr->print_r2($product->getAttributes());
            return '';
        }



        /** есть ли такой раздел */
        $sectionModel = new Section();
        $sectionData = $sectionModel->getSectionByUrl($pathForParse);

        //\Yii::$app->pr->print_r2($sectionData);

        /** раскомментить ниже если нужен только 1 подраздел */
        //$sectionData = $sectionModel->getSectionByUrl($pathForParse, 1);

        if($sectionData){
            //\Yii::$app->pr->print_r2($sectionData['currentSection']->getAttributes());


            /*foreach($sectionData['unGroupedSiblings'] as $oneSibling){
                //\Yii::$app->pr->print_r2($oneSibling->getAttributes());
            }*/

            echo '<br />';
            echo '<br />';
            echo 'Выбран раздел: <b>' . $sectionData['currentSection']->name.'</b>';
            echo '<br />';
            echo '<br />';


            echo 'Подразделы:';
            echo '<br />';
            echo '<br />';


            //\Yii::$app->pr->print_r2($sectionData['groupedSiblings']);

            foreach($sectionData['groupedSiblings'] as $oneSibling){

                //\Yii::$app->pr->print_r2($oneSibling->getAttributes());

                echo '-- ' . $oneSibling->name . '<br />';

                if(isset($oneSibling->childs)){
                    //echo 'Подразделы в этой категории (показан только +1 уровень): <br />';

                    foreach ($oneSibling->childs as $oneChild) {
                        echo '------ ' . $oneChild->name . '<br />';

                    }
                }

            }


            //return '@todo - include section template';
            return '@todo - include section template';
        }







        return $this->render('index', ['pathForParse' => $pathForParse, 'categories' => $product ]);
    }
}
