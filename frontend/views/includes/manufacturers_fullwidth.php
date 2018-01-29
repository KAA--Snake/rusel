<?php
//\Yii::$app->pr->print_r2($manufacturers);

use yii\helpers\Url;
?>
<div class="sp_header sp_collapsed">ПРОГРАММА ПОСТАВОК</div>
<div class="sp_body-fullwidth js-sp_list_wrap">
    <div class="sp_corner"></div>
    <div class="sp_list js-scroll-pane">
        <? if(count($manufacturers) > 0) {?>
            <?
            $manufacturersCount = count($manufacturers);
            $newRow = ceil($manufacturersCount / 5);
            $lastKey = 0;
            ?>
            <ul class="inner_list <?=$newRow?>">
            <? foreach($manufacturers as $key => $manufacturer) {?>
                <? $lastKey++; ?>
                <li class="sp_item <?=$lastKey?>"><a href="<?=Url::to('/manufacturer/'.$manufacturer['m_name'].'/');?>"><?=$manufacturer['m_name'];?></a></li>
                <?if($lastKey == $newRow) {?>
            </ul>
                    <ul class="inner_list">
                    <?
                    $lastKey = 0;
                }?>
            <?}?>
            </ul>
        <?}?>
    </div>
</div>
