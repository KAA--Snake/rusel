<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\widgets\catalog\CatalogMenu;
use common\widgets\main_slider\MainSlider;
use common\widgets\search\WSearch;
use common\widgets\review\WReview;
use common\widgets\popular\WPopular;

$this->title = 'RUSEL24: Комплексное снабжение комплектующими';


//меню каталога доступно в $catalog_menu. Раскомментируй отладку ниже чтобы посмотреть его структуру
//\yii\helpers\VarDumper::dump($catalog_menu, 10, true);



?>



<div class="subheader">


</div>

<div class="content_wrap mw1180">


    <div class="content_inner_wrap left0">

        <?= \common\widgets\review\WReview::widget();?>

        <?= \common\widgets\popular\WPopular::widget();?>

        <?= \common\widgets\offers\WOffers::widget();?>

        <?= \common\widgets\news\WNews::widget();?>
    </div>
</div>
