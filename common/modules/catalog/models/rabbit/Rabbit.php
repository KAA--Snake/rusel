<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.11.17
 * Time: 14:45
 */

namespace common\modules\catalog\models\rabbit;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

abstract class Rabbit
{

    private $login = 'user';
    private $password = 'pass';
    private $server = 'rabbit';
    private $port = 5672;

    private $connection;
    private $channel;

    public $queue_name;


    public function __construct($queue_name = 'main_queue')
    {
        //$this->connection = new AMQPStreamConnection($this->server, $this->port, $this->login, $this->password);
        //$this->channel = $this->connection->channel();
        $this->queue_name = $queue_name;
    }

    private function __openConnection(){
        $this->connection = new AMQPStreamConnection($this->server, $this->port, $this->login, $this->password);
        $this->channel = $this->connection->channel();
    }


    private function __closeConnection(){
        $this->channel->close();
        $this->connection->close();
    }


    /**
     * Отправляет данные на consumer-а
     *
     * (приходить будут в метод $this->RabbitWorker())
     *
     * @param $orderData
     */
    public function sendDataToRabbit($orderData){

        $this->__openConnection();

        $this->channel->queue_declare(
            $this->queue_name,	#queue name - Имя очереди может содержать до 255 байт UTF-8 символов
            false,      	#passive - может использоваться для проверки того, инициирован ли обмен, без того, чтобы изменять состояние сервера
            true,      	#durable - убедимся, что RabbitMQ никогда не потеряет очередь при падении - очередь переживёт перезагрузку брокера
            false,      	#exclusive - используется только одним соединением, и очередь будет удалена при закрытии соединения
            false       	#autodelete - очередь удаляется, когда отписывается последний подписчик
        );

        $msg = new AMQPMessage(
            $orderData,
            array('delivery_mode' => 2) #создаёт сообщение постоянным, чтобы оно не потерялось при падении или закрытии сервера
        );

        $this->channel->basic_publish(
            $msg,           	#сообщение
            '',             	#обмен
            $this->queue_name 	#ключ маршрутизации (очередь)
        );

        $this->__closeConnection();

    }



    public function listenWorker(){

        try{

            //file_put_contents('/webapp/listenerStarted', $this->queue_name, FILE_APPEND);

           $this->__openConnection();

            $this->channel->queue_declare(
                $this->queue_name,	#queue name - Имя очереди может содержать до 255 байт UTF-8 символов
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
            $this->channel->basic_qos(
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
            $this->channel->basic_consume(
                $this->queue_name,    	#очередь
                '',                  #тег получателя - Идентификатор получателя, валидный в пределах текущего канала. Просто строка
                false,               #не локальный - TRUE: сервер не будет отправлять сообщения соединениям, которые сам опубликовал
                false,               #без подтверждения - false: подтверждения включены, true - подтверждения отключены. отправлять соответствующее подтверждение обработчику, как только задача будет выполнена
                false,                 #эксклюзивная - к очереди можно получить доступ только в рамках текущего соединения
                false,                 #не ждать - TRUE: сервер не будет отвечать методу. Клиент не должен ждать ответа
                array($this, 'processWork')	#функция обратного вызова - метод, который будет принимать сообщение
            );

            while(count($this->channel->callbacks)) {
                //$this->log->addInfo('Слежу за входящими сообщениями');
                $this->channel->wait();
            }

            $this->__closeConnection();

        }catch(Exception $e){
            //file_put_contents('/webapp/RabbitListen', 'error' .$e->getMessage(), FILE_APPEND);

        }
    }

    /**
     *
     * Метод который вызывается воркером в качестве колбека при получении сообщения
     * реализация в конкретных воркерах-consumer-ах
     *
     * @param AMQPMessage $msg
     * @return mixed
     */
    abstract public function processWork(AMQPMessage $msg);



}