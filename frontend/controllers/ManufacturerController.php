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
use yii\web\Controller;

class ManufacturerController extends Controller
{
    public $layout = 'searchFullWidth';


    /**
     * Cтраница поиска по названию производителя
     *
     */
    public function actionIndex($manufacturer = ''){

        /** вынимаем из таблицы производителей нужного по его имени, получаем его ИД */

        $manufacturerModel = new Manufacturer();

        $manufacturer = $manufacturerModel->getByName($manufacturer);

        if(empty($manufacturer->m_id) || !isset($manufacturer->m_id)) {
            return $this->render('byManufacturers', ['productsList' => []]);
        }
        //\Yii::$app->pr->print_r2($manufacturer);

        $productModel = new Product();
        $products = $productModel->getProductByManufacturer([$manufacturer->m_id]);

        //\Yii::$app->pr->print_r2($products);

        /** @TODO вынимаем структуру разделов для этих товаров. */



        return $this->render('byManufacturers', ['productsList' => $products]);
    }
}