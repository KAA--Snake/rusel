<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.12.17
 * Time: 10:10
 */

namespace common\modules\catalog\models\search\searches\byFiles;


use common\modules\catalog\models\search\searches\BaseSearch;
use common\models\elasticsearch\Product;

abstract class BaseFileSearch extends BaseSearch
{
    public $filePath;
    public $productArticles;

    public function __construct($filePath){
        $this->filePath = $filePath;
    }


    protected function _isLengthIsGood($artikul){
        if(strlen($artikul) <= 4 || strlen($artikul) > 100) return false;

        return true;
    }

    protected function getProducts(){
        $productModel = new Product();
        $productsList = $productModel->getProductsByArticles($this->productArticles);

        return $productsList;
    }

}