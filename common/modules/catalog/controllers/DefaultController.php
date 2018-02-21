<?php

namespace common\modules\catalog\controllers;

use common\models\elasticsearch\Product;
use common\modules\catalog\models\BreadCrumbs;
use common\modules\catalog\models\filter\CatalogFilter;
use common\modules\catalog\models\search\searches\ProductsSearch;
use common\modules\catalog\models\Section;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends Controller
{
    public $layout = 'catalog';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'manufacturers' => [
                'class' => 'common\modules\catalog\behaviours\Manufacturers_beh',
                /*'in_attribute' => 'name',
                'out_attribute' => 'slug',
                'translit' => true*/
            ],
            'pagination' => [
                'class' => 'common\modules\catalog\behaviours\Pagination_beh',
                'maxSizeCnt' => \Yii::$app->getModule('catalog')->params['max_products_cnt']

            ],
        ];
    }

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

        //\Yii::$app->pr->print_r2($this->view->params);

        $perPage = \Yii::$app->getModule('catalog')->params['max_products_cnt'];

        $isNeedPerPage = \Yii::$app->request->get('perPage');
        if(isset($isNeedPerPage)){
            $perPage = $isNeedPerPage;
        }

        $sectionModel = new Section();
        $breadCrumbsObj = new BreadCrumbs();

        //$sectionModel->getBreadCrumbsForPath();

        /*$page = \Yii::$app->request->get('page');
        if(!$page){
            $page = 1;
        }
        $this->view->params['page'] = $page;*/
        $this->view->params['perPage'] = $perPage;


        /** для нулевого уровня каталога показываем только главные разделы */
        if(!$pathForParse){
            $rootSections = $sectionModel->getRootSections();

            return $this->render('catalogRoot', ['rootSections' => $rootSections]);
        }



        /** карточка товара */
        $productModel = new Product();

        $product = $productModel->getProductByUrl($pathForParse);
        //
        if($product){

            //получаем breadcrumbs
            $breadcrumbs = $breadCrumbsObj->getForCatalogProduct($product);
            $this->view->params['breadcrumbs'] = $breadcrumbs;

            $this->layout = 'catalogDetail';
            return $this->render('productDetail', ['oneProduct' => $product]);
        }


        /**
         * Ниже вывод раздела/списка товаров в разделе
         */

        $sectionData = $sectionModel->getSectionByUrl($pathForParse, 5);

        if(!empty($sectionData['currentSection']['unique_id']) && $sectionData['currentSection']['unique_id'] > 0) {

            $filterParams = [
                'section_id' => $sectionData['currentSection']['unique_id']
            ];

            $productsSearchModel = new ProductsSearch();
            $sectionProducts = $productsSearchModel->getFilteredProducts($filterParams);
        }

        //\Yii::$app->pr->print_r2($sectionProducts);


        /** раскомментить ниже если нужен только 1 подраздел */
        //$sectionData = $sectionModel->getSectionByUrl($pathForParse, 1);

        if( $sectionData['currentSection'] ){


            /**
             * если ничего ен нашлось, сделаем НОВЫЙ поиск и покажем соотв уведомление
             */
            if($sectionProducts['emptyFilterResult']){
                //ob_end_clean();
                //echo "<script type='text/javascript'>  window.location=window.location.href; </script>";

                \Yii::$app->session->addFlash('error','По заданному критерию поиска товаров не найдено!');
               /* $productsSearchModel = new ProductsSearch();
                $sectionProducts = $productsSearchModel->getFilteredProducts($filterParams, true);*/

            }



            $returnData = [
                'currentSection' => $sectionData['currentSection'],
                'groupedSiblings' => $sectionData['groupedSiblings'],
                'unGroupedSiblings' => $sectionData['unGroupedSiblings'],
                'currentSectionProducts' => $sectionProducts['products'],
                'paginator' => $sectionProducts['paginator'],
                'totalProductsFound' => $sectionProducts['totalProductsFound'],
                'filterData' => $sectionProducts['filterData'],
                'appliedFilterJson' => $sectionProducts['appliedFilterJson'],
                'emptyFilterResult' => $sectionProducts['emptyFilterResult'],
                'filterManufacturers' => $sectionProducts['filterManufacturers'],
                'perPage' => $perPage,

            ];

	       /* \Yii::$app->pr->print_r2($sectionProducts['filterData']);
	        die();*/
        }else{
            /** если ничего не нашлось, выбросим 404 */
            throw new HttpException(404);
        }

        $breadcrumbs = $breadCrumbsObj->getForCatalogSection($sectionData['currentSection']);
        $this->view->params['breadcrumbs'] = $breadcrumbs;

        /** если раздел содержит товары, выведем их список */
        if( !empty($sectionProducts['products']) || $sectionProducts['emptyFilterResult'] ){

            $this->layout = 'catalogFullWidth';


            return $this->render('sectionProducts', $returnData);
        }
        /** если раздел не содержит товаров, но есть список подразделов, выведем их*/
        else if( !empty($sectionData['groupedSiblings']) ){


            return $this->render('sectionsList', $returnData);
        }
        /** последний подраздел, но без списка товаров (по идее сюда не должно заходить, т.к. товары должны быть!)*/
        else if( $sectionData['currentSection'] ){


            return $this->render('sectionsList', $returnData);
        }



        /** если ничего не нашлось ранее, выбросим 404 */
        throw new HttpException(404);

    }
}
