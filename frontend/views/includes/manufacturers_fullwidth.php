<?php
//\Yii::$app->pr->print_r2($manufacturers);

use yii\helpers\Url;
?>
<div class="sp_header sp_collapsed sp_header-fullwidth">ПРОГРАММА ПОСТАВОК</div>
<div class="sp_body-fullwidth js-sp_list_wrap">
    <div class="sp_corner"></div>
    <div class="sp_filter_block">
        <input type="text" class="sp_filter js-sp_filter" placeholder="Поиск производителя">
    </div>
    <div class="sp_list js-scroll-pane">
        <? if(count($manufacturers) > 0) {?>
            <ul class="inner_list flex-row-layout">
            <? foreach($manufacturers as $key => $manufacturer) {?>
                <li class="sp_item js-sp_item <?=$lastKey?>"><a href="<?=Url::to('/manufacturer/'.$manufacturer['m_name'].'/');?>"><?=$manufacturer['m_name'];?></a></li>
            <?}?>
            </ul>
        <?}?>
    </div>
</div>
