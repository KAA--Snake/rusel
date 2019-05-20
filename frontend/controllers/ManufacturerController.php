<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.10.17
 * Time: 17:21
 */

namespace frontend\controllers;

use common\models\elasticsearch\Product;
use common\modules\catalog\models\Manufacturer;
use common\modules\catalog\models\search\searches\ProductsSearch;
use common\modules\catalog\models\Section;
use common\modules\catalog\models\seo\SeoManufacturer;
use common\widgets\seo_manufacturer\SeoManufacturers;
use yii\web\Controller;

class ManufacturerController extends Controller
{
    public $layout = 'manufacturer';
    public $pagination;


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


    /**
     * Cтраница поиска по названию производителя
     *
     * @throws \Exception
     */
    public function actionIndex($manufacturer = ''){

        /** вынимаем из таблицы производителей нужного по его имени, получаем его ИД */

        $manufacturerModel = new Manufacturer();

        $manufacturer = $manufacturerModel->getByName($manufacturer);

        $this->view->params['seo']['manufacturer'] = $manufacturer;

        //seo text widget
        $seoTextForManufacturer = SeoManufacturers::widget([
            'options' => [
                'manufacturerId' => $manufacturer->m_id
            ],
        ]);

        if(empty($manufacturer->m_id) || !isset($manufacturer->m_id) || empty($manufacturer->m_group_ids)) {
            return $this->render('productsList', ['productsList' => [], 'manufacturer' => $manufacturer->m_name]);
        }
        //\Yii::$app->pr->print_r2($this->pagination);

        $productModel = new ProductsSearch();
        $products = $productModel->getProductByManufacturer([$manufacturer->m_id]);

        if(count($products) <= 0){
            return $this->render('productsList', ['productsList' => [], 'manufacturer' => $manufacturer->m_name]);
        }

        /*\Yii::$app->pr->print_r2($products);
        die();*/

        /** @TODO вынимаем структуру разделов. */
        $sectionModel = new Section();
        $groupedSections = $sectionModel->getTreeForGroupIds($manufacturer->m_group_ids);

        return $this->render('productsList', [
            'productsList' => $products['hits']['hits'],
            'manufacturer' => $manufacturer->m_name,
            'groupedSections' => $groupedSections,
            'seoText' => $seoTextForManufacturer,
            'paginator' => $products['paginator'],
        ]);
    }
}