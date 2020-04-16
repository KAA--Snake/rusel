<?php

use common\widgets\popular\WPopular;


/* @var $this yii\web\View */

$this->title = 'admin Popular page';

if($model){
    $errors = $model->getErrors();
    if(!empty($errors)){
        \Yii::$app->pr->print_r2($errors);
    }

}
?>

<div class="inner_wrap mw1180">
    <div class="back-link-wrap ">
        <a href="/admin" class="back-link btn btn-blue">←  Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для загрузки - Популярные Линейки</h1>

    <form action="/admin/popular/add" method="post" id="info_add-form" class="info_add-form" enctype="multipart/form-data">
        <div class="flex_wrap">

            <div class="right_wrap">
                <div class="label">Название:</div>
                <input class="info-id" type="text" name="Popular[name]" value="<?=$model->name;?>">

                <div class="label">URL тега:</div>
                <input class="info-id" type="text" name="Popular[url]" value="<?=$model->url;?>">

                <div class="label">URL картинки (Без слеша в начале, пример: images/blocks/276.076-405000.jpg):</div>
                <input class="info-id" type="text" name="Popular[big_img_src]" value="<?=$model->big_img_src;?>">

                <div class="label">Порядок сортировки (по умолчанию = 1)</div>
                <input class="info-id" type="text" name="Popular[sort]" value="<?=$model->sort;?>">

                <div class="label">Ширина картинки в теге (по умолчанию = 200):</div>
                <input class="info-id" type="text" name="Popular[html_width]" value="<?=$model->html_width;?>">

                <div class="label">Высота картинки в теге (по умолчанию = 100):</div>
                <input class="info-id" type="text" name="Popular[html_height]" value="<?=$model->html_height;?>">

                <div class="label">Target в теге (по умолчанию = _blank):</div>
                <input class="info-id" type="text" name="Popular[target]" value="<?=$model->target;?>">

                <input class="info-id" type="hidden" name="Popular[id]" value="<?=$model->id;?>">
            </div>
        </div>


        <div class="divider-gray"></div>


        <div class="btns-block">
            <button class="info-save_btn btn btn-blue">Сохранить</button>
            <button class="info-delete_btn js-article-delete-btn btn btn-transparent" data-article-id="/admin/popular/delete/<?=$model->id;?>">Удалить</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список - популярные линейки</h2>

        <?
        if($models){?>
            <?if(count($models) > 0){?>
                <?foreach($models as $oneModel){?>
                    <div class="previous-item-item">
                        <a class="name" href="/admin/popular/<?=$oneModel->id;?>"><?=$oneModel->name;?></a>
                        <span class="date"><?=$oneModel->big_img_src;?></span>
                        <span>---></span>
                        <span>URL: <?=$oneModel->url;?></span>
                        <span>Сортировка: <?=$oneModel->sort;?></span>
                        <span>Тег target: <?=$oneModel->target;?></span>
                        <span>Ширина: <?=$oneModel->html_width;?></span>
                        <span>Высота: <?=$oneModel->html_height;?></span>
                        <span class="delete js-article-delete-btn" data-article-id="/admin/popular/delete/<?=$oneModel->id;?>">удалить</span>
                    </div>
                <?}?>
            <?}?>
        <?}?>



    </div>

</div>

<div>
    Блок виджета. Элементы отсортированы по полю Сортировка:

    <?=WPopular::widget();?>

</div>

