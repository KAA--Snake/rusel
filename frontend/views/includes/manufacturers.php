<?php
//\Yii::$app->pr->print_r2($manufacturers);

use yii\helpers\Url;
?>
<div class="sp_header sp_expanded">ПРОГРАММА ПОСТАВОК</div>
<div class="sp_body js-sp_list_wrap">
    <div class="sp_filter_block">
        <input type="text" class="sp_filter" placeholder="Поиск производителя">
    </div>
    <ul class="sp_list js-scroll-pane">
        <? if(count($manufacturers) > 0) {?>
            <? foreach($manufacturers as $manufacturer) {?>

                <li class="sp_item"><a href="<?=Url::to('/manufacturer/'.$manufacturer['m_name'].'/');?>"><?=$manufacturer['m_name'];?></a></li>
            <?}?>
        <?}?>
    </ul>
</div>
