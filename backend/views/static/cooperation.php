<?php

/* @var $this yii\web\View */

$this->title = 'admin cooperation page';

if($model){
    $errors = $model->getErrors();
    if(!empty($errors)){
        \Yii::$app->pr->print_r2($errors);
    }

}
?>

<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'.tiny_textarea' });</script>-->



<div class="inner_wrap mw1180">
    <div class="back-link-wrap ">
        <a href="/admin" class="back-link btn btn-blue">←  Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для редактирования страницы "Сотрудничество"</h1>

    <form action="/admin/static/add/" method="post" id="static_add-form" class="static_add-form" enctype="multipart/form-data">

        <input type="hidden" name="Artikle[type]" value="cooperation" />
        <input type="hidden" name="Artikle[id]" value="<?=$model->id;?>" />

        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Картинка:</div>
                <div class="uploaded_img" style="background-image: url(<?=$model->big_img_src;?>);">
                    <img class="js-filereader-target" src="backend/web/img/no_photo.png" alt="">
                </div>
                <input type="file" name="Artikle[file]" class="static-img-upload js-img-upload_input hidden">
                <div class="img_instructions">Размер картинки: <span class="img-size">220 x 170 px</span></div>
                <button class="static-upload_btn js-img-upload_btn btn btn-transparent">Загрузить</button>
            </div>

            <div class="right_wrap static-textarea_block">
                <textarea class="static_textarea" name="Artikle[full_text]"><?=$model->full_text;?></textarea>
            </div>
        </div>


        <div class="divider-gray"></div>


        <div class="btns-block">
            <button class="static-save_btn btn btn-blue">Сохранить</button>
            <button class="static-cancel_btn btn btn-transparent">Отмена</button>
        </div>
    </form>


</div>


