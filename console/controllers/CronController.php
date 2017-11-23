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
use common\modules\catalog\models\rabbit\Order\RabbitOrder;
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
     * Раббит демон для рассылки заказов в ЕРП, вызов висит на супервизорде
     */
    public function actionRabbitListenOrder()
    {
        $rabbitOrder = new RabbitOrder('order_queue');
        $rabbitOrder->listenWorker();
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