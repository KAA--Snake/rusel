<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\widgets\catalog\CatalogMenu;
use common\widgets\main_slider\MainSlider;

$this->title = 'My Yii Application';


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


        <div class="search_block">
            <input type="text" placeholder="Введите искомый артикул" class="search_field">
            <button class="submit_search">Найти</button>
            <a href="/search/" class="list_seach">Поиск по списку</a>
        </div>

    </div>


    <div class="content_inner_wrap col_940">

        <h1 class="main-page_h1">КОМПЛЕКСНОЕ СНАБЖЕНИЕ КОМПЛЕКТУЮЩИМИ</h1>

        <?=MainSlider::widget();?>

        <?= \common\widgets\news\WOffers::widget();?>

        <?= \common\widgets\info\WInfo::widget();?>

        <?= \common\widgets\news\WOffers::widget();?>
    </div>
</div>
