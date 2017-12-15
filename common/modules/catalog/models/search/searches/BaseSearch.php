<?php
/**
 * Created by PhpStorm.
 * User: Sergei
 * Date: 11.12.17
 * Time: 15:04
 */

namespace common\modules\catalog\models\search\searches;

use common\models\elasticsearch\Product;

abstract class BaseSearch implements iSearch
{

    public $productArticles;

    protected function getProducts(){
        $productModel = new Product();
        $productsList = $productModel->getProductsByArticles($this->productArticles);

        return $productsList;
    }

    protected function _isLengthIsGood($artikul){
        if(strlen($artikul) < 4 || strlen($artikul) > 100) return false;

        return true;
    }

}