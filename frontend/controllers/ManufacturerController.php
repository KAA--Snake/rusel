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


    public function behaviors()
    {
        return [

            'manufacturers' => [
                'class' => 'common\modules\catalog\behaviours\Manufacturers_beh',
                /*'in_attribute' => 'name',
                'out_attribute' => 'slug',
                'translit' => true*/
            ]
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

        if(empty($manufacturer->m_id) || !isset($manufacturer->m_id)) {
            return $this->render('productsList', ['productsList' => [], 'manufacturer' => $manufacturer->m_name]);
        }
        //\Yii::$app->pr->print_r2($manufacturer);

        $productModel = new Product();
        $products = $productModel->getProductByManufacturer([$manufacturer->m_id]);

        if(count($products) <= 0){
            return $this->render('productsList', ['productsList' => [], 'manufacturer' => $manufacturer->m_name]);
        }

        //\Yii::$app->pr->print_r2($products);

        /** @TODO вынимаем структуру разделов для этих товаров. */
        $sectionModel = new Section();
        $groupedSections = $sectionModel->getTreeForProducts($products);

        return $this->render('productsList', [
            'productsList' => $products,
            'manufacturer' => $manufacturer->m_name,
            'groupedSections' => $groupedSections,
        ]);
    }
}