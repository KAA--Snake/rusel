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

    /**
     *
     * Взаимозаменяет символы ",.-" между собой и добавляет к запросу это
     *
     * @param array $query
     * @return array
     */
    protected function _replacedSymbolsQuery(array $query) : array 
    {

        foreach ($query as $singleQuery) {

            if (strpos($singleQuery, '.') !== false) {
                $newQuery = str_replace('.', '-', $singleQuery);
                $query[] = $newQuery;

                $newQuery = str_replace('.', ',', $singleQuery);
                $query[] = $newQuery;
            }

            if (strpos($singleQuery, ',') !== false) {
                $newQuery = str_replace(',', '-', $singleQuery);
                $query[] = $newQuery;

                $newQuery = str_replace(',', '.', $singleQuery);
                $query[] = $newQuery;
            }

            if (strpos($singleQuery, '-') !== false) {
                $newQuery = str_replace('-', '.', $singleQuery);
                $query[] = $newQuery;

                $newQuery = str_replace('-', ',', $singleQuery);
                $query[] = $newQuery;
            }

        }

        return $query;
    }

    /**
     * Разбиваем запрос на множество если стоит знак + (склеиваем его по знаку +)
     *
     * @param array $query
     * @return array
     */
    protected function __addToQuery(array $query) : array
    {

        //сохраняем на случай запросов с плюсом, тогда его надо обнулить и встроить запрос из фраз между плюсами
        $returnQuery = $query;

        foreach ($query as $k => $singleQuery) {

            if (strpos($singleQuery, '+') !== false) {
                //обнуляем исходный запрос
                $returnQuery = [];

                $plusQueries = explode('+', $singleQuery);
                foreach ($plusQueries as $onePlusQuery) {
                    if (!empty($onePlusQuery)) {
                        $returnQuery[] = trim($onePlusQuery);
                    }

                }
            }

        }
        //\Yii::$app->pr->print_r2($returnQuery);
        return $returnQuery;
    }


    public function getGoodResultsCount(){
        return $this->foundGoodResultsCount;
    }


}