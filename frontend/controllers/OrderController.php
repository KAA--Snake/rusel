<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.10.17
 * Time: 13:07
 */

namespace frontend\controllers;


use common\models\erp\Export;
use common\modules\catalog\models\Order;
use common\modules\catalog\models\rabbit\Order\RabbitOrder;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
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

        //Yii::$app->session->addFlash('something', print_r(Yii::$app->request->post()['Order'], true));

        $form_model = new Order();

        if($form_model->load(Yii::$app->request->post())){


            if(!$form_model->validate()){
                Yii::$app->session->addFlash('error', 'Ошибка сохранения заказа!');
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }

            /**
             * сначала сохраняем заказ в бд
             * при этом автоматически в заказ подтянутся данные по ценам при сохранении
             */
            $form_model->save();

            //$forRabbitSendData = $form_model->getAttributes();

            //присоединяем ее к заказу
            $forRabbitSendData= [];

            //это тут передается для того, чтобы после экспорта обновить данные в заказе
            $forRabbitSendData['id'] = $form_model->id;

            //получаем строку для ЕРП вида ID|количество|цена|код_валюты&ID|количество|цена|код_валюты& etc...
            $forRabbitSendData['dataForErp'] = $form_model->getDataForErp();

            /** потом отправляем в очередь на отправку заказа в ЕРП @TODO раскомментить после тестирования ниже ! */
            $rabbitModel = new RabbitOrder('order_queue');
            $rabbitModel->sendDataToRabbit(json_encode($forRabbitSendData));


            //@TODO ТЕСТОВАЯ ОТПРАВКА НАПРЯМУЮ БЕЗ РАББИТА ! УДАЛИТЬ ПОСЛЕ ТЕСТИРОВАНИЯ !
            $export = new Export();
            $export->exportOrder(json_encode($forRabbitSendData));


            /** отправляем письмо о новом заказе */
            $form_model->sendMail();


            //$file = file_get_contents('/webapp/RabbitProcess');






            //$this->redirect()
            //return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            //Yii::$app->pr->print_r2(Yii::$app->request->post());

        }




    }
}