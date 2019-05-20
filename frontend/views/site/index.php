<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\widgets\catalog\CatalogMenu;
use common\widgets\main_slider\MainSlider;
use common\widgets\search\WSearch;

$this->title = 'RUSEL24: Комплексное снабжение комплектующими';


//меню каталога доступно в $catalog_menu. Раскомментируй отладку ниже чтобы посмотреть его структуру
//\yii\helpers\VarDumper::dump($catalog_menu, 10, true);



?>



<div class="subheader">


</div>

<div class="content_wrap mw1180">

    <div class="col_220 fll">

        <div class="supply_program">
            <? echo $this->render('@app/views/includes/manufacturers.php', [
                'manufacturers' => $this->params['manufacturers'],
            ]);?>
        </div>

    </div>


    <div class="content_top col_940">

        <?=CatalogMenu::widget();?>


        <?=WSearch::widget();?>

    </div>


    <div class="content_inner_wrap col_940">

        <h1 class="main-page_h1">КОМПЛЕКСНОЕ СНАБЖЕНИЕ КОМПЛЕКТУЮЩИМИ</h1>

        <?= MainSlider::widget();?>

        <?= \common\widgets\offers\WOffers::widget();?>

        <?= \common\widgets\info\WInfo::widget();?>

        <?= \common\widgets\news\WNews::widget();?>
    </div>
</div>
