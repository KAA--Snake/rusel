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

<div class="content_block news">
    <div class="flex_wrap">
        <div class="left_wrap">
            <div class="label"><?=$model->name;?></div>
        </div>
    </div>

    <div class="flex_wrap news-content_row">
        <div class="left_wrap">
            <div class="label"><img class="js-filereader-target" src="<?=$model->big_img_src;?>" alt=""></div>
        </div>

        <div class="right_wrap news-textarea_block">
            <?=$model->text;?>
        </div>
    </div>

    <div class="divider-gray"></div>

</div>
