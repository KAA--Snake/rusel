<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.10.17
 * Time: 13:07
 */

namespace frontend\controllers;


use yii\web\Controller;

class OrderController extends Controller
{
    /**
     * Показывает страницу на которую редиректит после успешного оформления заказа
     */
    public function actionDone(){
        return $this->render('@common/modules/catalog/views/order/orderDone', []);
    }
}