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
use common\modules\catalog\models\search\searches\ProductsSearch;
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
            ],
            'pagination' => [
                'class' => 'common\modules\catalog\behaviours\Pagination_beh',
                'maxSizeCnt' => \Yii::$app->getModule('catalog')->params['max_products_cnt']

            ],
        ];
    }

    /**
     * Отдает аякс со списком товаров из корзины.
     * Сами ИДы товаров берет из куки Cart
     *
     * @return array
     */
    public function actionIndex(){

        $this->layout = 'cart';

        // получаем поля для введенной ранее формы (еси были)
        $cartFields = \Yii::$app->session->get('cartFields');
        if($cartFields){
            $cartFields = json_decode($cartFields);
        }else{
            $cartFields = new Order(); //заполняем все поля пустыми значениями (для подстановки во вьюху)
        }

        //\Yii::$app->pr->print_r2($cartFields);


        $cart = [];


        if(isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])){

            $cart = $_COOKIE['cart'];
            //\Yii::$app->pr->print_r2($cart);
        }else{
            return $this->render('@common/modules/catalog/views/default/cartOrder', [
                'cart' => [],
                'cartFields' => $cartFields
            ]);
        }

        $cart = explode('&', $cart);


        //получили $cart массив записей в корзине
	    //\Yii::$app->pr->print_r2($cart);
	    //die();
        $prodIds = [];
        $storages = [];
        foreach ($cart as $oneCartProduct){
            $product = explode('|', $oneCartProduct);
            $prodIds[] = $product[0];

	        $storages[$product[0]][] = $product[2];
        }

	    $prodIds = array_values(array_unique($prodIds));

        //\Yii::$app->pr->print_r2($storages);

        //die();
        $products = [];

        if(count($prodIds) > 0){

            $productsModel = new ProductsSearch();
            $products = $productsModel->getProductsByIds($prodIds)['hits'];

            //удалим те скалды, которые не были в покупках
	        $productsModel->removeCartStorages($products, $storages);
            //\Yii::$app->pr->print_r2($products);
        }

        $orderModel = new Order();
        //var_dump(compact('orderModel'));



        //die();

        return $this->render('@common/modules/catalog/views/default/cartOrder',
            [
                'cart' => $products,
                'form_model' => compact('orderModel'),
                'cartFields' => $cartFields

            ]);


//die();
        //return $products;
    }



}