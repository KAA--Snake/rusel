<?php

/* @var $this yii\web\View */

$this->title = 'admin seo text manufacturers';
if($model){
    $errors = $model->getErrors();
    if(!empty($errors)){
        foreach ($errors as $oneError) {?>
            <div class="back-link-wrap ">
                $oneError
            </div>
<?php
        }
    }
}

?>

<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'.tiny_textarea' });</script>-->


<div class="inner_wrap mw1180">
    <div class="back-link-wrap ">
        <a href="/admin" class="back-link btn btn-blue">←  Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для создания/редактирования СЕО текста производителя</h1>

    <form action="/admin/seo/manufacturer/add" method="post" id="news_add-form" class="news_add-form" enctype="multipart/form-data">
        <input class="info-id" type="hidden" name="SeoManufacturer[id]" value="<?=$model->id;?>">


        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Название для отображения</div>
                <input class="news-name" type="text" name="SeoManufacturer[name]" value="<?=$model->name;?>">
            </div>

            <div class="right_wrap news-id_block">
                <div class="label">ID производителя:</div>
                <input class="news-id" type="text" name="SeoManufacturer[manufacturer_id]" value="<?=$model->manufacturer_id;?>">
            </div>
        </div>

        <div class="flex_wrap news-content_row">
            <div class="left_wrap">
                <div class="label">Картинка:</div>
                <div class="uploaded_img" style="background-image: url(<?=$model->big_img_src;?>);">
                    <img class="js-filereader-target" src="backend/web/img/no_photo.png" alt="">
                </div>
                <input type="file" name="SeoManufacturer[file]" class="offer-img-upload hidden js-img-upload_input">
                <div class="img_instructions">Размер картинки: <span class="img-size">220 x 170 px</span></div>
                <button class="news-upload_btn js-img-upload_btn btn btn-transparent">Загрузить</button>
            </div>

            <div class="right_wrap news-textarea_block">
                <textarea class="static_textarea" cols="100" rows="10" name="SeoManufacturer[text]"><?=$model->text;?></textarea>
            </div>
        </div>

        <div class="divider-gray"></div>

        <div class="btns-block">
            <button class="news-save_btn btn btn-blue">Сохранить</button>
            <button class="news-delete_btn js-article-delete-btn btn btn-transparent" data-article-id="/admin/seo/manufacturer/delete/<?=$model->id;?>">Удалить</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список всех СЕО текстов производителей:</h2>

        <?
        if($models){?>
            <?if(count($models) > 0){?>
                <?foreach($models as $oneModel){?>

                    <div class="previous-item-item">
                        <span class="name" onclick="location.href='/admin/seo/manufacturer/<?=$oneModel->id;?>'"><?=$oneModel->name;?></span>
                        <span class="date"></span>
                        <span class="delete js-article-delete-btn" data-article-id="/admin/seo/manufacturer/delete/<?=$oneModel->id;?>">удалить</span>
                    </div>
                <?}?>
            <?}?>
        <?}?>

    </div>
</div>


