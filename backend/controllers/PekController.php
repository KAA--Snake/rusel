<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 22.09.17
 * Time: 11:21
 */

namespace backend\controllers;


use yii\rest\ActiveController;
use yii\web\Controller;
use yii\filters\AccessControl;


class PekController extends Controller
{
    //public $modelClass = 'app\models\User';

    private function sendCurl($params){

        $params = [
            "query" => [
                'index' => 'product',
                "match_all" => new \stdClass()
            ]
        ];
        $ch = curl_init( 'https://pecom.ru/ru/calc/towns.php' );
        # Setup request to send json via POST.
        /*$payload = json_encode( array(
            "login"=> 'elastic',
            "password"=> 'changeme',
        ) );*/
        //curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        //curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        //curl_setopt($ch, CURLOPT_USERPWD, Elastic::$user . ":" . Elastic::$pass);


        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
        //var_dump($result);
    }


    /**
     * Получает список ВСЕХ городов ПЭК
     *
     * @TODO ОБЯЗАТЕЛЬНО СДЕЛАТЬ КЕШИРОВАНИЕ ! Сейчас пишет в сессию- это ТОЛЬКО для тестирования !
     *
     * @return mixed
     */
    public function actionGetTowns(){
        $session = \Yii::$app->session;

        $pekTowns = $session->get('pek-towns');

        if(!isset($pekTowns) || empty($pekTowns)){

            $ch = curl_init( 'https://pecom.ru/ru/calc/towns.php' );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            $result = curl_exec($ch);
            curl_close($ch);

            $session->set('pek-towns', $result);
        }else{

            $result = $pekTowns;
        }

        return $result;
        //echo json_encode($result,JSON_PRETTY_PRINT);
        //echo json_decode($result);
        //\Yii::$app->pr->print_r2($result);
    }


    /**
     * Получает расчет по доставке для городов from-to
     *
     * @TODO ОБЯЗАТЕЛЬНО СДЕЛАТЬ КЕШИРОВАНИЕ ! Сейчас пишет в сессию- это ТОЛЬКО для тестирования !
     *
     * @param int $take
     * @param int $delivery
     * @return mixed
     */
    public function actionGetDelivery($take=63123, $delivery=63123){
        $session = \Yii::$app->session;

        $pekDelivery = $session->get('pek-delivery');


        if(isset($pekDelivery)){
            $pekDelivery = json_decode($pekDelivery);
            if(isset($pekDelivery->$take->$delivery) && !empty($pekDelivery->$take->$delivery)){
                return $pekDelivery->$take->$delivery;
            }
        }


        $ch = curl_init( 'http://calc.pecom.ru/bitrix/components/pecom/calc/ajax.php?places[0]&take[town]='.$take.'&deliver[town]='.$delivery );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
        $pekDelivery = [];
        $pekDelivery[$take][$delivery] = $result;
        $session->set('pek-delivery', json_encode($pekDelivery));

        //echo 'nocache';
        return $result;



    }



}