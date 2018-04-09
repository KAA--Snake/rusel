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
<div class="content_block specials">
    <h2 class="content_header">Специальные предложения</h2>
    <div class="content_body">
        <ul class="specials_list">

            <?if(!empty($models)){?>
            <?foreach($models as $oneNews){?>

                    <li class="specials_item">
                        <a href="/special/<?= $oneNews->url;?>">
                            <div class="specials_img" style="background-image: url('<?= $oneNews->big_img_src;?>')"></div>
                            <div class="specials_name">
                                <?= $oneNews->name;?>
                            </div>
                        </a>
                    </li>

                <?}?>
            <?}?>



        </ul>
    </div>
</div>
