<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.10.17
 * Time: 13:07
 */

namespace frontend\controllers;


use common\modules\catalog\models\Order;
use yii\web\Controller;
use Yii;

class OrderController extends Controller
{
    /**
     * Показывает страницу на которую редиректит после успешного оформления заказа
     */
    public function actionDone(){
        return $this->render('@common/modules/catalog/views/order/orderDone', []);
    }

    /**
     *  1. Принимает форму при оформлении заказа.
     *  2. Если все ок, создает заказ то выдает ОК и номер заказа для редиректа на страницу подтверждения
     *  3. Если все НЕ ок, то выдает ошибки.
     */
    public function actionSend(){

        Yii::$app->session->addFlash('something', 'ORDER SUCCESSFULL ADDED');

        $form_model = new Order();

        if($form_model->load(Yii::$app->request->post())){

            //$this->redirect()
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            //Yii::$app->pr->print_r2(Yii::$app->request->post());

        }
        //Yii::$app->pr->print_r2();

    }
}