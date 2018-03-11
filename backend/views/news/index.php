<?php

/* @var $this yii\web\View */

$this->title = 'admin news page';
?>

<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'.tiny_textarea' });</script>-->



<div class="inner_wrap mw1180">
    <div class="back-link-wrap ">
        <a href="/admin" class="back-link btn btn-blue">←  Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для создания/редактирования новостей</h1>

    <form action="" id="news_add-form" class="news_add-form">
        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Название заголовка для новости:</div>
                <input class="news-name" type="text">
            </div>
            <div class="right_wrap news-id_block">
                <div class="label">Дата:</div>
                <input class="news-id" type="text">
            </div>
        </div>
        <div class="flex_wrap news-content_row">
            <div class="left_wrap">
                <div class="label">Картинка:</div>
                <div class="uploaded_img"></div>
                <input type="file" class="offer-img-upload hidden">
                <div class="img_instructions">Размер картинки: <span class="img-size">220 x 170 px</span></div>
                <button class="news-upload_btn btn btn-transparent">Загрузить</button>
            </div>

            <div class="right_wrap news-textarea_block">
                <textarea class="news_textarea"></textarea>
            </div>
        </div>


        <div class="divider-gray"></div>


        <div class="btns-block">
            <button class="news-save_btn btn btn-blue">Сохранить</button>
            <button class="news-delete_btn btn btn-transparent">Удалить</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список всех новостей</h2>

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


