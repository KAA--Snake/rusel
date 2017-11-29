<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.11.17
 * Time: 15:45
 */

namespace common\helpers\cart;


use common\modules\catalog\models\currency\Currency;

class BuyHelper
{

    /**
     * добавляет к товару текущую цену в пересчете на курс
     *
     * @param $product
     * @return bool
     */
    public static function setPriceForOrderProduct(&$product){

        $allowedBuyPrice = [];

        //если есть маркетинг, юзаем ТОЛЬКО его
        if
        (
            isset($product['marketing'])
            &&
            isset($product['marketing']['status'])
            &&
            $product['marketing']['status'] == 1
        )
        {
            $allowedBuyPrice['currency'] = $product['marketing']['currency'];
            $allowedBuyPrice['value'] = $product['marketing']['price'];

        }
        else if(isset($product['prices'])){

            //\Yii::$app->pr->print_r2($product);

            if(isset($product['prices']['price_range']) && count($product['prices']['price_range']) > 0){

                $allPrices = [];


                //соберем массив цен
                foreach($product['prices']['price_range'] as $onePriceArr){
                    $allPrices[$onePriceArr['range']] = $onePriceArr;
                }

                //распределим их по возрастанию доступных количеств
                asort($allPrices);


                //проходим по отсортированному массиву
                foreach($allPrices as $priceRange => $onePriceArr){

                    //находим доступный диапазон цен для выбранного количества
                    if($product['count'] >= $priceRange){
                        $allowedBuyPrice = $onePriceArr;

                        break;
                    }
                }

            }

        }

        //если цена найдена, добавим выборку по курсу валюты и сохраним ее в массиве заказа
        if(count($allowedBuyPrice) > 0){

            $price = Currency::getPriceForCurrency(
                $allowedBuyPrice['currency'],
                $allowedBuyPrice['value']
            );
            $product['buyPrice'] = $price;
            $product['overallPrice'] = $price * $product['count'];
        }
        //\Yii::$app->pr->print_r2($product);



        return true;
    }
}