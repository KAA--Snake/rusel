<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.10.17
 * Time: 13:24
 */

namespace frontend\controllers;


use common\models\elasticsearch\Product;
use common\modules\catalog\models\Order;
use yii\web\Controller;

class CartController extends Controller
{

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
     * Отдает аякс со списком товаров из корзины.
     * Сами ИДы товаров берет из куки Cart
     *
     * @return array
     */
    public function actionIndex(){

        $this->layout = '@common/modules/catalog/views/layouts/catalogDetail';


        $cart = [];


        if(isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])){

            $cart = $_COOKIE['cart'];
            //\Yii::$app->pr->print_r2($cart);
        }else{
            return $this->render('@common/modules/catalog/views/default/cartOrder', ['cart' => []]);
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

        $orderModel = new Order();
        //var_dump(compact('orderModel'));

        //die();

        return $this->render('@common/modules/catalog/views/default/cartOrder',
            [
                'cart' => $products,
                'form_model' => compact('orderModel')

            ]);


//die();
        //return $products;
    }



}