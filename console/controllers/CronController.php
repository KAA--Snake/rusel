<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.09.2017
 * Time: 20:33
 */

namespace console\controllers;

set_time_limit(0);

use common\modules\catalog\models\currency\Currency;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\console\Controller;
use yii\console\Exception;


class CronController extends Controller
{

    /**
     * Получает валюты по крону
     */
    public function actionGetCurrency(){

        Currency::updateCurrencies();
        file_put_contents('/webapp/CronGetCurrency', date("d/m/Y"));
    }


    /**
     * Раббит демон тут, висит через супервизорд
     */
    public function actionRabbitListen()
    {

        //$connection = new AMQPStreamConnection('rabbit', 5672, 'rabbit_user', 'rabbit3457');
        try{
            $connection = new AMQPStreamConnection('rabbit', 5672, 'user', 'pass');
            $channel = $connection->channel();

            $channel->queue_declare(
                'main_queue',	#queue name - Имя очереди может содержать до 255 байт UTF-8 символов
                false,      	#passive - может использоваться для проверки того, инициирован ли обмен, без того, чтобы изменять состояние сервера
                true,      	#durable - убедимся, что RabbitMQ никогда не потеряет очередь при падении - очередь переживёт перезагрузку брокера
                false,      	#exclusive - используется только одним соединением, и очередь будет удалена при закрытии соединения
                false       	#autodelete - очередь удаляется, когда отписывается последний подписчик

            );

            /**
             * не отправляем новое сообщение на обработчик, пока он
             * не обработал и не подтвердил предыдущее. Вместо этого
             * направляем сообщение на любой свободный обработчик
             */
            $channel->basic_qos(
                null,   #размер предварительной выборки - размер окна предварительнйо выборки в октетах, null означает “без определённого ограничения”
                1,  	#количество предварительных выборок - окна предварительных выборок в рамках целого сообщения
                null	#глобальный - global=null означает, что настройки QoS должны применяться для получателей, global=true означает, что настройки QoS должны применяться к каналу
            );

            /**
             * оповещает о своей заинтересованности в получении
             * сообщений из определённой очереди. В таком случае мы
             * говорим, что они регистрируют получателя, или устанавливают
             * подписку на очередь. Каждый получатель (подписка) имеет
             * идентификатор, называемый “тег получателя”.
             */
            $channel->basic_consume(
                'main_queue',    	#очередь
                '',                  #тег получателя - Идентификатор получателя, валидный в пределах текущего канала. Просто строка
                false,               #не локальный - TRUE: сервер не будет отправлять сообщения соединениям, которые сам опубликовал
                false,               #без подтверждения - false: подтверждения включены, true - подтверждения отключены. отправлять соответствующее подтверждение обработчику, как только задача будет выполнена
                false,                 #эксклюзивная - к очереди можно получить доступ только в рамках текущего соединения
                false,                 #не ждать - TRUE: сервер не будет отвечать методу. Клиент не должен ждать ответа
                array($this, 'builder')	#функция обратного вызова - метод, который будет принимать сообщение
            );

            while(count($channel->callbacks)) {
                //$this->log->addInfo('Слежу за входящими сообщениями');
                $channel->wait();
            }

            $channel->close();
            $connection->close();
        }
        catch(Exception $e){
            //file_put_contents('/webapp/RabbitListen', 'error' .$e->getMessage(), FILE_APPEND);

        }

    }

    /**
     * Паттерн Строитель
     * На основе переданной сообщения (и очереди) будет строить соответствубщий класс и вызывать его методы
     *
     * @param AMQPMessage $msg
     */
    public function builder(AMQPMessage $msg)
    {
        //$this->generatePdf()->sendEmail();


        file_put_contents('/webapp/RabbitProcess', print_r($msg, true));

        /**
         * Если получатель умирает, не отправив подтверждения, брокер
         * AMQP пошлёт сообщение другому получателю. Если свободных
         * на данный момент нет - брокер подождёт до тех пор, пока
         * освободится хотя-бы один зарегистрированный получатель
         * на эту очередь, прежде чем попытаться заново доставить
         * сообщение
         */
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    }




    public function actionShow(){
        //Currency::showCurrencies();

        $price =  Currency::getPriceForCurrency(840, 1);

        echo $price . PHP_EOL;
    }

    public function actionFrequent() {
        // called every two minutes
        // */2 * * * * ~/sites/www/yii2/yii test

    }

    public function actionQuarter() {
        // called every fifteen minutes

    }

    public function actionHourly() {
        // every hour
        $current_hour = date('G');
        if ($current_hour%4) {
            // every four hours
        }
        if ($current_hour%6) {
            // every six hours
        }
    }
}