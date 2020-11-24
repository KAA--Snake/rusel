<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.12.17
 * Time: 14:20
 */

namespace common\modules\catalog\models\search\searches;


use common\helpers\minifilter\MiniFilterHelper;
use common\models\CacheHelper;
use common\models\elasticsearch\Product;
use common\modules\catalog\models\elastic\Elastic;
use Yii;
use yii\redis\Cache;
use common\modules\catalog\models\Section;

class StockProductsSearch extends ProductsSearch
{
    //отключаем ограничение по длине для поиска в http://rusel24.ru/stock_info_1
    function _isLengthIsGood($artikul){
        return true;
    }
}