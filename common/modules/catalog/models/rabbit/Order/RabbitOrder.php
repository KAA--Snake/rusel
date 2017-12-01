<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.11.17
 * Time: 14:46
 */

namespace common\modules\catalog\models\rabbit\Order;


use common\models\erp\Export;
use common\modules\catalog\models\rabbit\Rabbit;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitOrder extends Rabbit
{
    public $queue_name = 'order_queue';



    public function processWork(AMQPMessage $msg){

        //file_put_contents('/webapp/processWork', print_r($msg->body, true));

        $erpExport = new Export();
        if($erpExport->exportOrder($msg->body)){

            /**
             * Если получатель умирает, не отправив подтверждения, брокер
             * AMQP пошлёт сообщение другому получателю. Если свободных
             * на данный момент нет - брокер подождёт до тех пор, пока
             * освободится хотя-бы один зарегистрированный получатель
             * на эту очередь, прежде чем попытаться заново доставить
             * сообщение
             */
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

            return true;
        }

        return false;

    }
}