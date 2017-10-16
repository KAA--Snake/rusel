<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.10.17
 * Time: 11:18
 */

namespace common\modules\catalog\controllers;


use common\models\elasticsearch\Product;
use yii\web\Controller;

class CartController extends Controller
{

    /**
     * Отдает аякс со списком товаров из корзины.
     * Сами ИДы товаров берет из куки Cart
     *
     * @return array
     */
    public function actionGetCart(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $cart = [];


        if(isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])){

            $cart = $_COOKIE['cart'];
            //\Yii::$app->pr->print_r2($cart);
        }else{
            return [];
        }

        $cart = explode('&', $cart);

        //получили $cart массив записей в корзине

        $prodIds = [];
        foreach ($cart as $oneCartProduct){
            $product = explode('|', $oneCartProduct);
            $prodIds[] = $product[0];

        }

        //\Yii::$app->pr->print_r2($prodIds);

        //die();
        $products = [];

        if(count($prodIds) > 0){

            $productsModel = new Product();
            $products = $productsModel->getProductsByIds($prodIds);
            //\Yii::$app->pr->print_r2($products);
        }

//die();
        return $products;
    }
}