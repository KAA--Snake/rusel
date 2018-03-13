<?php

/* @var $this yii\web\View */

$this->title = 'admin about page';
?>

<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'.tiny_textarea' });</script>-->



<div class="inner_wrap mw1180">
    <div class="back-link-wrap ">
        <a href="/admin" class="back-link btn btn-blue">←  Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для редактирования страницы "Контакты"</h1>

    <form action="" id="static_add-form" class="static_add-form">

        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Картинка:</div>
                <div class="uploaded_img"></div>
                <input type="file" class="static-img-upload hidden">
                <div class="img_instructions">Размер картинки: <span class="img-size">220 x 170 px</span></div>
                <button class="static-upload_btn btn btn-transparent">Загрузить</button>
            </div>

            <div class="right_wrap static-textarea_block">
                <textarea class="static_textarea"></textarea>
            </div>
        </div>


        <div class="divider-gray"></div>


        <div class="btns-block">
            <button class="static-save_btn btn btn-blue">Сохранить</button>
            <button class="static-cancel_btn btn btn-transparent">Отмена</button>
        </div>
    </form>

</div>


