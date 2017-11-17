<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.10.17
 * Time: 13:07
 */

namespace frontend\controllers;


use common\modules\catalog\models\Order;
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

        Yii::$app->session->addFlash('something', print_r(Yii::$app->request->post()['Order'], true));

        $form_model = new Order();

        if($form_model->load(Yii::$app->request->post())){

            //$connection = new AMQPStreamConnection('rabbit', 5672, 'rabbit_user', 'rabbit3457');
            $connection = new AMQPStreamConnection('rabbit', 5672, 'user', 'pass');
            //$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
            $channel = $connection->channel();

            $channel->queue_declare(
                'invoice_queue',	#queue name - Имя очереди может содержать до 255 байт UTF-8 символов
                false,      	#passive - может использоваться для проверки того, инициирован ли обмен, без того, чтобы изменять состояние сервера
                true,      	#durable - убедимся, что RabbitMQ никогда не потеряет очередь при падении - очередь переживёт перезагрузку брокера
                false,      	#exclusive - используется только одним соединением, и очередь будет удалена при закрытии соединения
                false       	#autodelete - очередь удаляется, когда отписывается последний подписчик
            );

            $msg = new AMQPMessage(
                5738234,
                array('delivery_mode' => 2) #создаёт сообщение постоянным, чтобы оно не потерялось при падении или закрытии сервера
            );

            $channel->basic_publish(
                $msg,           	#сообщение
                '',             	#обмен
                'invoice_queue' 	#ключ маршрутизации (очередь)
            );

            $channel->close();
            $connection->close();

            //$this->redirect()
            //return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            //Yii::$app->pr->print_r2(Yii::$app->request->post());

        }
        //Yii::$app->pr->print_r2();

    }
}