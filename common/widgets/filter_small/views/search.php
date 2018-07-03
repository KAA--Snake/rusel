<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.18
 * Time: 12:09
 */
use yii\helpers\Url;

?>

<div class="filter_counter fll">
    Показать: <span class="show_in_stock js-selected_show_in_stock_vars">все</span>
    <div class="show_in_stock_vars hidden">
        <div class="top_corner"></div>
        <ul class="show_in_stock_list">
            <li class="show_in_stock_item"><a class="js-filter-show_in_stock" data-type="all" href="">все</a></li>
            <li class="show_in_stock_item"><a class="js-filter-show_in_stock" data-type="on_stores" href="">доступные на складах</a></li>
            <li class="show_in_stock_item"><a class="js-filter-show_in_stock" data-type="marketing" href="">спец.предложения</a></li>
        </ul>
    </div>
    &nbsp;&nbsp;&nbsp;<span class="arr">→</span>&nbsp;&nbsp;&nbsp;
    Найдено: <span class="filter_num"><?=$totalProductsFound;?></span> позиций
</div>