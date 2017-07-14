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
        $sectionWhere = [
            'url' => $pathForParse
        ];
        $section = Section::find()->andWhere($sectionWhere)->one();
        if($section){

            /** выведем подразделы (если они есть)*/
            $sectionModel = new Section();
            $subSections = $sectionModel->getChildrens($section->unique_id);

            \Yii::$app->pr->print_r2($section->getAttributes());
            return '';
        }



        return '';

        return $this->render('index', ['pathForParse' => $pathForParse, 'categories' => $product ]);
    }
}
