<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.09.2017
 * Time: 20:33
 */

namespace console\controllers;


use common\modules\catalog\models\currency\Currency;
use yii\console\Controller;

class CronController extends Controller
{

    /**
     * Получает валюты по крону
     */
    public function actionGetCurrency(){

        Currency::updateCurrencies();
        file_put_contents('/webapp/CronGetCurrency', date("d/m/Y"));
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