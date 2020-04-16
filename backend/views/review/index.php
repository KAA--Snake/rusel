<?php

use common\widgets\review\WReview;


/* @var $this yii\web\View */

$this->title = 'admin Review page';

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

    <h1 class="header_h1">Форма для загрузки - Обзор Категории</h1>

    <form action="/admin/review/add" method="post" id="info_add-form" class="info_add-form" enctype="multipart/form-data">
        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Картинка:</div>
                <div class="uploaded_img" style="background-image: url(<?=$model->big_img_src;?>);">
                    <img class="js-filereader-target" src="backend/web/img/no_photo.png" alt="">
                </div>
                <input type="file" name="Review[file]" class="info-img-upload js-img-upload_input hidden">
                <div class="img_instructions">Размер картинки: <span class="img-size">110 x 80 px</span></div>
                <button class="info-upload_btn js-img-upload_btn btn btn-transparent">Загрузить</button>
            </div>

            <div class="right_wrap">
                <div class="label">Заглавие:</div>
                <textarea name="Review[name]" id="info_head" class="info_head" placeholder="Введите заголовок"><?php if($model->name) {echo $model->name;}else{echo 'Введите заголовок';}?></textarea>

                <div class="label">Полный текст:</div>
                <textarea name="Review[full_text]" id="info_head" class="info_head" placeholder="Введите текст"><?=$model->full_text;?></textarea>

                <div class="label">Порядок соритровки статьи</div>
                <input class="info-id" type="text" name="Review[sort]" value="<?=$model->sort;?>">

                <div class="label">URL:</div>
                <input class="info-id" type="text" name="Review[url]" value="<?=$model->url;?>">
                <input class="info-id" type="hidden" name="Review[id]" value="<?=$model->id;?>">
            </div>
        </div>


        <div class="divider-gray"></div>


        <div class="btns-block">
            <button class="info-save_btn btn btn-blue">Сохранить</button>
            <button class="info-delete_btn js-article-delete-btn btn btn-transparent" data-article-id="/admin/review/delete/<?=$model->id;?>">Удалить</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список обзоров категорий</h2>

        <?
        if($models){?>
            <?if(count($models) > 0){?>
                <?foreach($models as $oneModel){?>
                    <div class="previous-item-item">
                        <a class="name" href="/admin/review/<?=$oneModel->id;?>"><?=$oneModel->name;?></a>
                        <span class="date"><?=$oneModel->url;?></span>
                        <span>Сортировка: <?=$oneModel->sort;?></span>
                        <span class="delete js-article-delete-btn" data-article-id="/admin/review/delete/<?=$oneModel->id;?>">удалить</span>
                    </div>
                <?}?>
            <?}?>
        <?}?>



    </div>

</div>

<div>
    Блок виджета, категории отсортированы по полю Сортировка:

    <?=WReview::widget();?>

</div>

