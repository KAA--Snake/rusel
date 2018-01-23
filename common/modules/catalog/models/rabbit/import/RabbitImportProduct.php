<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.01.18
 * Time: 15:40
 */

namespace common\modules\catalog\models\rabbit\import;


use common\models\elasticsearch\Product;
use common\modules\catalog\models\rabbit\Rabbit;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitImportProduct extends Rabbit
{

    public $queue_name = 'import_product_queue';


    /**
     *
     * Метод который вызывается воркером в качестве колбека при получении сообщения
     * реализация в конкретных воркерах-consumer-ах
     *
     * @param AMQPMessage $msg
     * @return mixed
     */
    public function processWork(AMQPMessage $msg)
    {
        //file_put_contents('/webapp/rabbit_msg', print_r($msg, true));

        //\Yii::error($msg->body, 'rabbit_import_error');
        $decodedProductInfo = @json_decode($msg->body);

        //@json_decode(@json_encode($decodedProductInfo),1);
        $object2Array = @json_decode(@json_encode($decodedProductInfo),1);

        //file_put_contents('/webapp/rabbit_msg', print_r($object2Array, true));

        $product = new Product();

        if( $product->saveProduct($object2Array) ){

            //usleep(250000);
            //usleep(500000);

            //file_put_contents('/webapp/rabbit_msg_ok', print_r($object2Array, true), FILE_APPEND);

            //\Yii::error($msg->body, 'rabbit_import_error');


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

        //$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);


        unset($decodedProductInfo); //чистим память
        unset($object2Array); //чистим память
        unset($product); //чистим память

        return false;

    }
}