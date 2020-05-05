<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 02.04.2020
 * Time: 12:09
 */
use yii\helpers\Url;


/*foreach($models as $oneNews){
    \Yii::$app->pr->print_r2($oneNews->getAttributes());
}*/
?>
<div class="content_block useful-info">
    <h2 class="content_header">Популярные линейки</h2>
    <div class="content_body">
        <ul class="popular-items_list">

            <?if(!empty($models)){?>
                <?foreach($models as $oneInfo){?>

                    <li class="popular-items_item">
                        <a href="<?=$oneInfo->url;?>" target="<?=$oneInfo->target;?>">
                            <div class="popular-items_img" style="background-image: url('/upload/<?=$oneInfo->big_img_src;?>');"></div>
                        </a>
                    </li>

                <?}?>
            <?}?>

        </ul>
    </div>
</div>


