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
	    //\Yii::$app->pr->print_r2($product);

        if(empty($product['productData'])) return false;

        foreach($product['productData']['prices']['storage'] as $oneStorage){

			if($oneStorage['id'] == $product['storageId']){

				//если есть маркетинг, юзаем ТОЛЬКО его
				if
				(
					isset($oneStorage['marketing'])
					//&&
					//isset($oneStorage['marketing']['status'])
					//&&
					//$oneStorage['marketing']['status'] == 1
				)
				{
					$allowedBuyPrice['currency'] = $oneStorage['marketing']['currency'];
					$allowedBuyPrice['value'] = $oneStorage['marketing']['price'];
					//\Yii::$app->pr->print_r2($allowedBuyPrice);

				}
				else if(isset($oneStorage['prices'])){

					if(isset($oneStorage['prices']['price_range']) && count($oneStorage['prices']['price_range']) > 0){

						$allPrices = [];
						//\Yii::$app->pr->print_r2($oneStorage);

						//соберем массив цен
						foreach($oneStorage['prices']['price_range'] as $onePriceArr){
							$allPrices[$onePriceArr['range']] = $onePriceArr;
						}

						//распределим их по возрастанию доступных количеств
						asort($allPrices);

						//\Yii::$app->pr->print_r2($product);

						//проходим по отсортированному массиву
						foreach($allPrices as $priceRange => $onePriceArr){

							//находим доступный диапазон цен для выбранного склада
							if($oneStorage['id'] == $product['storageId']){
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
					$product['price'] = $price;
					//$product['overallPrice'] = $price * $product['count'];

					/**
					 *
					 * "короче сделай что бы было 643 ) т.е. та валюта в которой цены на сайте"
					 */
					$product['currency'] = 643;
					//\Yii::$app->pr->print_r2($product);
					/** а здесь ниже нормальный вариант */
					//$product['currency'] = $allowedBuyPrice['currency'];
				}


			}

        }

        //\Yii::$app->pr->print_r2($product);

        return true;
    }


}