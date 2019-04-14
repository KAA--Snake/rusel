<?php

/* @var $this yii\web\View */

$this->title = 'admin new static page';

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
        <a href="/admin" class="back-link btn btn-blue">← Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для добавления новой статической страницы</h1>

    <form action="/admin/static/add/" method="post" id="static_add-form" class="static_add-form" enctype="multipart/form-data">

        <input type="text" name="Artikle[type]" placeholder="delivery (ENGLISH !!)" value="" />
        <?/*?><input type="hidden" name="Artikle[id]" value="" /><?*/?>

        <input type="text" name="Artikle[name]" placeholder="Название" value="" />

        <div class="divider-gray"></div>

        <div class="btns-block">
            <button class="static-save_btn btn btn-blue">Сохранить</button>
            <button class="static-cancel_btn btn btn-transparent">Отмена</button>
        </div>
    </form>

</div>


