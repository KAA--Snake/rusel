<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.18
 * Time: 12:09
 */
use yii\helpers\Url;


/*foreach($models as $oneNews){
    \Yii::$app->pr->print_r2($oneNews->getAttributes());
}*/
?>
<div class="content_block useful-info">
    <h2 class="content_header">Обзор категорий</h2>
    <div class="content_body">
        <ul class="useful-info_list">

            <?if(!empty($models)){?>
                <?foreach($models as $oneInfo){?>

                    <li class="useful-info_item">
                        <a href="<?=$oneInfo->url;?>">
                            <div class="useful-info_img" style="background-image: url('<?=$oneInfo->small_img_src;?>')"></div>

                            <div class="useful-info_name">
                                <?=$oneInfo->name;?> - <?=$oneInfo->full_text;?>
                            </div>

                        </a>
                    </li>

                <?}?>
            <?}?>

        </ul>
    </div>
</div>


