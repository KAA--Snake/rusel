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
    <h2 class="content_header">Новости</h2>
    <div class="content_body">
        <ul class="news_list">
            <?if(!empty($models)){?>
                <?foreach($models as $oneNews){?>
                    <li class="news_item">
                        <div class="news_pic" style="background-image: url('<?= $oneNews->big_img_src;?>')"></div>
                        <div class="news_item_text_wrap">
                            <h3 class="news_item_header"><?= $oneNews->name;?></h3>
                            <!--<div class="news_item_date">
                            <span class="clock_icon"></span>
                            <span class="date_text"><?/*= $oneNews->date;*/?></span>
                        </div>-->
                            <div class="news_item_preview"><?= $oneNews->preview_text;?></div>
                        </div>

                        <div class="shadow"></div>
                        <div class="news_item_link_wrap">
                            <a href="/sitenews/<?= $oneNews->url;?>/" class="news_item_link">
                                Подробнее&nbsp;&nbsp;&nbsp;→
                            </a>
                        </div>

                    </li>
                <?}?>
            <?}?>




        </ul>
    </div>
</div>
