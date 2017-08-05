<?php
namespace common\widgets\catalog\views;

use yii\helpers\Url;

//\Yii::$app->pr->print_r2($rootSections[0]);
?>


<div class="goods_catalog js-dropdown-catalog">
    <div class="gc_header">Каталог</div>
    <ul class="gc_list gc_list-lvl0" >
        <?php if(count($rootSections) > 0){?>
            <?php foreach($rootSections as $k=>$oneSection){?>
                <li class="gc_item">
                    <a href="<?= Url::toRoute(['@catalogDir/' . $oneSection->url]); ?>"><span><?=$oneSection->name;?></span></a>
                </li>
            <?php }?>
        <?php }?>

    </ul>
</div>