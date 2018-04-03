<?php

/* @var $this yii\web\View */

$this->title = 'admin news page';
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

    <h1 class="header_h1">Форма для создания/редактирования новостей</h1>

    <form action="/admin/news/add" method="post" id="news_add-form" class="news_add-form" enctype="multipart/form-data">
        <input class="info-id" type="hidden" name="News[id]" value="<?=$model->id;?>">

        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Название заголовка для новости:</div>
                <input class="news-name" type="text" name="News[name]" value="<?=$model->name;?>">
            </div>

            <div class="right_wrap news-id_block">
                <div class="label">Дата:</div>
                <input class="news-id" type="text" name="News[date]" placeholder="Day-Month-Year" value="<?=$model->date;?>">
            </div>
        </div>
        <div class="left_wrap">
            <div class="label">Текст превью для новости:</div>
            <input class="news-name" type="text" name="News[preview_text]" value="<?=$model->preview_text;?>">
        </div>
        <div class="left_wrap">
            <div class="label">Урл для новости:</div>
            <input class="news-name" type="text" name="News[url]" value="<?=$model->url;?>">
        </div>
        <div class="flex_wrap news-content_row">
            <div class="left_wrap">
                <div class="label">Картинка:</div>
                <div class="uploaded_img" style="background-image: url(<?=$model->big_img_src;?>);">
                    <img class="js-filereader-target" src="backend/web/img/no_photo.png" alt="">
                </div>
                <input type="file" name="News[file]" class="offer-img-upload hidden js-img-upload_input">
                <div class="img_instructions">Размер картинки: <span class="img-size">220 x 170 px</span></div>
                <button class="news-upload_btn js-img-upload_btn btn btn-transparent">Загрузить</button>
            </div>

            <div class="right_wrap news-textarea_block">
                <textarea class="news_textarea" name="News[full_text]"><?=$model->full_text;?></textarea>
            </div>
        </div>


        <div class="divider-gray"></div>


        <div class="btns-block">
            <button class="news-save_btn btn btn-blue">Сохранить</button>
            <button class="news-delete_btn js-article-delete-btn btn btn-transparent" data-article-id="/admin/news/delete/<?=$model->id;?>">Удалить</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список всех новостей</h2>


        <?
        if($models){?>
            <?if(count($models) > 0){?>
                <?foreach($models as $oneModel){?>

                    <div class="previous-item-item">
                        <span class="name" onclick="location.href='/admin/news/<?=$oneModel->id;?>'"><?=$oneModel->preview_text;?></span>
                        <span class="date"><?=$oneModel->date;?></span>
                        <span class="delete js-article-delete-btn" data-article-id="/admin/news/delete/<?=$oneModel->id;?>">удалить</span>
                    </div>
                <?}?>
            <?}?>
        <?}?>


    </div>
</div>


