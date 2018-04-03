<?php

/* @var $this yii\web\View */

$this->title = 'admin Offer page';
?>

<div class="inner_wrap mw1180">
    <div class="back-link-wrap ">
        <a href="/admin" class="back-link btn btn-blue">←  Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для загрузки специальных предложений</h1>

    <form action="" id="offer_add-form" class="offer_add-form">
        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Картинка:</div>
                <div class="uploaded_img">
                    <img class="js-filereader-target" src="backend/web/img/no_photo.png" alt="">
                </div>
                <input type="file" class="offer-img-upload js-img-upload_input hidden">
                <div class="img_instructions">Размер картинки: <span class="img-size">220 x 170 px</span></div>
                <button class="offer-upload_btn js-img-upload_btn btn btn-transparent">Загрузить</button>
            </div>

            <div class="right_wrap">
                <div class="label">Заглавие:</div>
                <textarea name="offer_head" id="offer_head" class="offer_head" placeholder="Введите текст"></textarea>
                <div class="label">URL:</div>
                <input class="offer-id" type="text">
                <div class="label">ID товаров:</div>
                <textarea name="offer_goods_list" id="offer_head" class="offer_goods_list" placeholder="Введите текст"></textarea>
            </div>
        </div>


        <div class="divider-gray"></div>


        <div class="btns-block">
            <button class="offer-save_btn btn btn-blue">Сохранить</button>
            <button class="offer-delete_btn btn btn-transparent">Удалить</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список полезной информации</h2>

        <div class="previous-item-item">
            <span class="name">Скидка на платы Gigabyte Technology</span>
            <span class="date">20.11.17</span>
        </div>

        <div class="previous-item-item">
            <span class="name">Ленты для обмотки маслонаполненных трансформаторов</span>
            <span class="date">20.11.17</span>
        </div>

    </div>
</div>

