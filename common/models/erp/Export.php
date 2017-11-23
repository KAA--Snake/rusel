<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.11.17
 * Time: 16:14
 */

namespace common\models\erp;


use common\modules\catalog\models\Order;

class Export
{


    /**
     * Отправляет запрос на ерп сервер по окончанию обработки выгрузки
     */
    public function sendRespondToErp($fileName, $result){

        $ch = curl_init( 'https://31.132.168.141:9999/exchange?type=site_answer&answer='.$fileName );
        # Setup request to send json via POST.

        file_put_contents('result.res', json_encode($result));

        $payload = array(
            'type' => 'site_answer',
            'answer' => $fileName,
            'file' => '@result.res',
        ) ;

        //$payload = http_build_query($payload);

        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        //curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        //curl_setopt($ch, CURLOPT_USERPWD, Elastic::$user . ":" . Elastic::$pass);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
        //curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        $result = curl_exec($ch);
        file_put_contents('test_result', print_r($result, true));
        //file_put_contents('test_payload', print_r($payload, true));

        curl_close($ch);

    }


    /**
     * Отправляет запрос на ерп сервер данные по созданному заказу
     * отправка готова, @TODO осталось написать остальной функционал
     */
    public function sendOrderToErp($order){

        $ch = curl_init( 'https://31.132.168.141:9999/exchange?type=client_query' );
        # Setup request to send json via POST.

        $payload = array(
            'type' => 'client_query',
            'order' => $order,
        );

        echo 'на адрес https://31.132.168.141:9999/exchange?type=client_query <br> ';
        echo 'уходят следующие данные, используя метод POST: <br> ';

        \Yii::$app->pr->print_r2($payload);

        //var_dump($payload);

        //$payload = http_build_query($payload);

        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        //curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        //curl_setopt($ch, CURLOPT_USERPWD, Elastic::$user . ":" . Elastic::$pass);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
        //curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        $result = curl_exec($ch);

        //file_put_contents('test_result', print_r($result, true));
        //file_put_contents('test_payload', print_r($payload, true));

        curl_close($ch);

        return $result;

    }


    public function exportOrder($order){
        $erpParams = \Yii::$app->getModule('catalog')->params['erp'];

        $result = $this->sendOrderToErp($order);

        echo '<br>';
        echo 'Ответ от сервера: <br>';
        \Yii::$app->pr->print_r2($result);

        //var_dump($result);

        if($result == 'client_query:ok'){

            //если успешно отправилось, записать в заказ
            $orderModel = new Order();

            $orderData = json_decode($order);

            if(empty($orderData->id) || $orderData->id <= 0){
                //если нет заказа, прекратим очередь для этого экспорта. Пусть разбираются сами в причине.
                return true;
            }

            $orderFind = $orderModel::find()->where(['id' => $orderData->id])->one();

            $orderFind->setAttribute('is_sent_to_erp', 1);
            $orderFind->update();

            return true;
        }

        return false;
    }









}