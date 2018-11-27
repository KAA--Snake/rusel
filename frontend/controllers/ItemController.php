<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.10.17
 * Time: 17:21
 */

namespace frontend\controllers;

use common\models\elasticsearch\Product;
use common\modules\catalog\models\Manufacturer;
use common\modules\catalog\models\search\searches\ProductsSearch;
use common\modules\catalog\models\Section;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\HttpException;

class ItemController extends Controller
{

   // public $layout = 'manufacturer';

    public function behaviors()
    {
        return [];
    }


    /**
     * Cтраница поиска по названию производителя
     *
     * @throws HttpException
     */
    public function actionIndex($item = ''){

        $item = (int)$item;

        if(empty($item) || $item == '' || $item <= 0){
            throw new HttpException(404);
            return false;
        }

        $productSearch = new ProductsSearch();
        $product = $productSearch->getProductByIds($item);

        if($product['total'] === 0){
            throw new HttpException(404);
            return false;
        }
        $url = '/catalog/'.str_replace('|', '/', $product['hits'][0]['_source']['url']);

        return $this->redirect($url, 302);

    }
}