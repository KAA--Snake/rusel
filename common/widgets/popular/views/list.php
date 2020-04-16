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
        <ul class="useful-info_list">

            <?if(!empty($models)){?>
                <?foreach($models as $oneInfo){?>

                    <li class="useful-info_item">
                        <a href="<?=$oneInfo->url;?>" target="<?=$oneInfo->target;?>">
                            <div class="useful-info_img" style="background-image: url('/upload/<?=$oneInfo->url;?>')"></div>
                            <img src="/upload/<?=$oneInfo->big_img_src;?>" width="<?=$oneInfo->html_width;?>" height="<?=$oneInfo->html_height;?>" />
                        </a>
                    </li>

                <?}?>
            <?}?>

        </ul>
    </div>
</div>


