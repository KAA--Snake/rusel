<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.09.2017
 * Time: 18:29
 */

namespace common\modules\catalog\models\currency;


class Currency
{
    public static function getCurrencies(){

    }


    public static function getPriceForCurrency($currencyCode, $price){

        return 1000;
    }

    public static function getCurrencyName($currencyCode){

        return 'p';
    }

}