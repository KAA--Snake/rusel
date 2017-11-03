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
use common\modules\catalog\models\Section;
use yii\web\Controller;

class ManufacturerController extends Controller
{
    public $layout = 'searchFullWidth';
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
     */
    public function actionIndex($manufacturer = ''){

        /** вынимаем из таблицы производителей нужного по его имени, получаем его ИД */

        $manufacturerModel = new Manufacturer();

        $manufacturer = $manufacturerModel->getByName($manufacturer);

        if(empty($manufacturer->m_id) || !isset($manufacturer->m_id) || empty($manufacturer->m_group_ids)) {
            return $this->render('productsList', ['productsList' => [], 'manufacturer' => $manufacturer->m_name]);
        }
        //\Yii::$app->pr->print_r2($this->pagination);

        $productModel = new Product();
        $products = $productModel->getProductByManufacturer([$manufacturer->m_id]);

        if(count($products) <= 0){
            return $this->render('productsList', ['productsList' => [], 'manufacturer' => $manufacturer->m_name]);
        }

        //\Yii::$app->pr->print_r2($this->pagination);

        /** @TODO вынимаем структуру разделов. */
        $sectionModel = new Section();
        $groupedSections = $sectionModel->getTreeForGroupIds($manufacturer->m_group_ids);

        return $this->render('productsList', [
            'productsList' => $products['productsList'],
            'manufacturer' => $manufacturer->m_name,
            'groupedSections' => $groupedSections,
            'paginator' => $products['paginator'],
        ]);
    }
}