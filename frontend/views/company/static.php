<?php
use common\widgets\catalog\CatalogMenu;
use common\widgets\search\WSearch;
?>
<div class="content_wrap mw1180">

    <div class="col_220 fll">

        <div class="supply_program">
            <? echo $this->render('@app/views/includes/manufacturers_fullwidth.php', [
                'manufacturers' => $this->params['manufacturers'],
            ]);?>
        </div>

    </div>


    <div class="content_top col_940">

        <?=CatalogMenu::widget();?>

        <?=WSearch::widget();?>

    </div>

    <div class="content_inner_wrap left0 col_1180 static_container">
        <h1><?= $model->name; ?></h1>

        <div class="static_inner_wrap">
            <div class="left_col">
                <img src="<?= $model->big_img_src; ?>" alt="<?= $model->name; ?>" class="static-img">
            </div>
            <div class="right_col">
                <div class="right_col"><?= $model->full_text; ?></div>
            </div>
        </div>

    </div>
</div>


