<?php

/* @var $this yii\web\View */

$this->title = 'admin Slider page';
?>


<div class="inner_wrap mw1180">
    <div class="back-link-wrap ">
        <a href="/admin" class="back-link btn btn-blue">←  Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для загрузки слайдера</h1>

    <form action="" id="slider_add-form" class="slider_add-form">
        <div class="label">Картинка:</div>
        <div class="uploaded_img"></div>
        <div class="img_instructions">Размер картинки: <span class="img-size">940 x 325 px</span></div>

        <div class="btns-block">
            <input type="file" class="slider-img-upload hidden">
            <button class="slider-upload_btn btn btn-blue">Загрузить</button>
            <button class="slider-delete_btn btn btn-transparent">Удалить</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список всех слайдеров</h2>

        <div class="previous-item-item">
            <span class="name">Слайдер 1</span>
            <span class="date">20.11.17</span>
        </div>

        <div class="previous-item-item">
            <span class="name">Слайдер 1</span>
            <span class="date">20.11.17</span>
        </div>

    </div>
</div>

