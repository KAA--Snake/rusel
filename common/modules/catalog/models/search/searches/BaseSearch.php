<?php
/**
 * Created by PhpStorm.
 * User: Sergei
 * Date: 11.12.17
 * Time: 15:04
 */

namespace common\modules\catalog\models\search\searches;

use common\models\elasticsearch\Product;
use Yii;

abstract class BaseSearch
{

    public  $productArticles;
    public  $foundGoodResultsCount = 0;

    protected function getProducts(){
        $productModel = new Product();
        $productsList = $productModel->getProductsByArticles($this->productArticles);

        return $productsList;
    }

    protected function _isLengthIsGood($artikul){
        $catalogModule = Yii::$app->getModule('catalog');
        $searchConfig = $catalogModule->params['search'];

        if(strlen($artikul) < $searchConfig['min_artikul_length'] || strlen($artikul) > $searchConfig['max_artikul_length']) return false;

        return true;
    }

    protected function _getMultyQuery($queryString) {
        return explode(';', trim($queryString));
    }

    public function getGoodResultsCount(){
        return $this->foundGoodResultsCount;
    }


}