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

        $ch = curl_init( 'https://188.120.237.24:9999/exchange?type=site_answer&answer='.$fileName );
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
     * @param $orderData
     * @return mixed
     */
    public function sendOrderToErp($orderData){

        unset($orderData->products); //для Прохора, чтоб он не пугался x_x

        $jsonData = json_encode($orderData);

        $payload = array(
            'type' => 'client_query',
            'order' => $jsonData,

        );

        echo 'на адрес https://188.120.237.24:9999/exchange?type=client_query <br> ';
        echo 'уходят следующие данные, используя метод POST: <br> ';

        \Yii::$app->pr->print_r2($payload);


        //$url ="http://rusel24.fvds.ru/test/post/";
        $url ="https://188.120.237.24:9999/exchange?type=client_query";

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array("X-HTTP-Method-Override:'POST','Content-Type:application/x-www-form-urlencoded','Content-Length: '" .     strlen(http_build_query($payload))));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLINFO_HEADER_OUT, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
        $result = curl_exec( $ch );

        curl_close($ch);

        return $result;

    }


    /**
     *
     * Отправляет данные по заказу в ЕРП.
     *
     * @param $orderJson
     * @return bool
     */
    public function exportOrder($orderJson){

        $orderData = json_decode($orderJson);

        //\Yii::$app->pr->print_r2($orderData);
        //return;


        $result = $this->sendOrderToErp($orderData);

        echo '<br /> ответ ЕРП:'. $result;

        if($result == 'client_query:ok'){

            //если успешно отправилось, записать в заказ
            $orderModel = new Order();

            if(empty($orderData->id) || $orderData->id <= 0){
                //если нет заказа, прекратим очередь для этого экспорта. Пусть разбираются сами в причине.
                return true;
            }

            $orderFind = $orderModel::find()->where(['id' => $orderData->id])->one();

            $orderFind->setAttribute('is_sent_to_erp', 1);
            $orderFind->update();

            return true;
        }

        //@TODO удалить после тестирования !!
        file_put_contents('/webapp/orderErpError', print_r($orderData, true), FILE_APPEND);

        return false;
    }









}