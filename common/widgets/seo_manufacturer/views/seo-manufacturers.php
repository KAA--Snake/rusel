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

<div class="seo__img">
    <img src="<?=$model->big_img_src;?>" alt="">
</div>
<div class="seo__text-block">
    <h2 class="seo__header"><?=$model->name;?></h2>
    <div class="seo__text"><?=$model->text;?></div>
</div>


