<?php

/* @var $this yii\web\View */

$this->title = 'admin Slider page';

//Возможные ошибки будут лежать тут: $uploadResult['errors'] !!!!

?>


<div class="inner_wrap mw1180">
    <div class="back-link-wrap ">
        <a href="/admin" class="back-link btn btn-blue">←  Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для загрузки слайдера</h1>

    <form action="/admin/slider/add" method="post" name="slide" enctype="multipart/form-data" id="slider_add-form" class="slider_add-form">
        <div class="label">Картинка:</div>
        <div class="uploaded_img" style="background-image: url(<?=$slide->big_img_src;?>);"></div>
        <div class="img_instructions">Размер картинки: <span class="img-size"><?=$slide->big_img_width;?> x <?=$slide->big_img_height;?> px</span></div>

        <div class="btns-block">
            <input type="file" name="Slider[file]" class="slider-img-upload hidden">

            <?/* Эту строку оставить скрытой, иначе не будет работать :)*/?>
            <input type="hidden" name="Slider[slide_url]" >

            <button class="slider-upload_btn btn btn-blue">Загрузить</button>
            <button class="slider-delete_btn btn btn-transparent" onclick="window.location.href='/admin/slider/delete/<?=$slide->id;?>'">Удалить</button>
        </div>
        <button type="submit">Отправить</button>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список всех слайдеров</h2>

        <?
        if($slides){?>
            <?if(count($slides) > 0){?>
                <?foreach($slides as $oneSlide){?>
                    <div class="previous-item-item">
                        <span class="name" onclick="location.href='/admin/slider/<?=$oneSlide->id;?>'">Слайдер <?=$oneSlide->id;?></span>
                        <span class="date"><?=$oneSlide->big_img_width;?> x <?=$oneSlide->big_img_height;?> px</span>
                        <span class="date" onclick="window.location.href='/admin/slider/delete/<?=$oneSlide->id;?>'">удалить</span>
                    </div>
                <?}?>
            <?}?>
        <?}?>


    </div>
</div>

