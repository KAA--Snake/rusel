<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.10.17
 * Time: 17:21
 */

namespace frontend\controllers;

use common\models\elasticsearch\Product;
use yii\web\Controller;

class ManufacturerController extends Controller
{
    public $layout = 'searchFullWidth';


    /**
     * Cтраница поиска по названию производителя
     *
     */
    public function actionIndex($manufacturer = ''){

        /** @TODO вынимаем из таблицы производителей нужного по его имени, получаем его ИД */
        $manufacturerId = [10663, 10885]; //это на будущие поиски по артикулу
        $manufacturerId = 10663;


        /** @TODO получаем список товаров у которых есть выбранные производители */

        $productModel = new Product();
        $products = $productModel->getProductByManufacturer($manufacturerId);


        /** @TODO вынимаем структуру разделов для этих товаров. */



        return $this->render('byManufacturers', ['manufacturer' => $manufacturer]);
    }
}