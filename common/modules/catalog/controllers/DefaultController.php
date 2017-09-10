<?php

namespace common\modules\catalog\controllers;

use common\models\elasticsearch\Product;
use common\modules\catalog\models\BreadCrumbs;
use common\modules\catalog\models\Section;
use yii\web\Controller;
use yii\web\HttpException;

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
     * @param bool $pathForParse
     * @return string
     * @throws HttpException
     */
    public function actionIndex($pathForParse = false)
    {
        /** @todo УДАЛИТЬ ЭТО НИЖЕ- СДЕЛАНО ТОЛЬКО ДЛЯ ТЕСТИРОВАНИЯ - корзина */
        if(!empty(\Yii::$app->request->get('cart'))){

            $this->layout = 'catalogDetail';
            return $this->render('cartOrder');
        }

        $sectionModel = new Section();
        $breadCrumbsObj = new BreadCrumbs();

        //$sectionModel->getBreadCrumbsForPath();

        /** для нулевого уровня каталога показываем только главные разделы */
        if(!$pathForParse){
            $rootSections = $sectionModel->getRootSections();

            return $this->render('catalogRoot', ['rootSections' => $rootSections]);
        }



        /** карточка товара */
        $productModel = new Product();

        $product = $productModel->getProductByUrl($pathForParse);
        if($product){
            $this->layout = 'catalogDetail';
            return $this->render('productDetail', ['oneProduct' => $product]);
        }


        /**
         * Ниже вывод раздела/списка товаров в разделе
         */
        $sectionData = $sectionModel->getSectionByUrl($pathForParse, 5);

        /** раскомментить ниже если нужен только 1 подраздел */
        //$sectionData = $sectionModel->getSectionByUrl($pathForParse, 1);

        if( $sectionData['currentSection'] ){

            $returnData = [
                'currentSection' => $sectionData['currentSection'],
                'groupedSiblings' => $sectionData['groupedSiblings'],
                'unGroupedSiblings' => $sectionData['unGroupedSiblings'],
                'currentSectionProducts' => $sectionData['currentSectionProducts'],
                'paginator' => $sectionData['paginator'],
                'totalProductsFound' => $sectionData['totalProductsFound'],
            ];
        }else{
            /** если ничего не нашлось, выбросим 404 */
            throw new HttpException(404);
        }



        /** если раздел содержит товары, выведем их список */
        if( !empty($sectionData['currentSectionProducts']) ){

            $this->layout = 'catalogFullWidth';

            $breadcrumbs = $breadCrumbsObj->getForCatalogSection($sectionData['currentSection']);
            $this->view->params['breadcrumbs'] = $breadcrumbs;

            return $this->render('sectionProducts', $returnData);
        }
        /** если раздел не содержит товаров, но есть список подразделов, выведем их*/
        else if( !empty($sectionData['groupedSiblings']) ){

            $breadcrumbs = $breadCrumbsObj->getForCatalogSection($sectionData['currentSection']);
            $this->view->params['breadcrumbs'] = $breadcrumbs;

            return $this->render('sectionsList', $returnData);
        }
        /** последний подраздел, но без списка товаров (по идее сюда не должно заходить, т.к. товары должны быть!)*/
        else if( $sectionData['currentSection'] ){

            $breadcrumbs = $breadCrumbsObj->getForCatalogSection($sectionData['currentSection']);
            $this->view->params['breadcrumbs'] = $breadcrumbs;

            return $this->render('sectionsList', $returnData);
        }



        /** если ничего не нашлось ранее, выбросим 404 */
        throw new HttpException(404);

    }
}
