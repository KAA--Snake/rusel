<?php

/* @var $this yii\web\View */

$this->title = 'admin Info page';

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

    <h1 class="header_h1">Форма для загрузки полезной информации</h1>

    <form action="/admin/info/add" method="post" id="info_add-form" class="info_add-form" enctype="multipart/form-data">
        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Картинка:</div>
                <div class="uploaded_img" style="background-image: url(<?=$model->big_img_src;?>);">
                    <img class="js-filereader-target" src="backend/web/img/no_photo.png" alt="">
                </div>
                <input type="file" name="Info[file]" class="info-img-upload js-img-upload_input hidden">
                <div class="img_instructions">Размер картинки: <span class="img-size">110 x 80 px</span></div>
                <button class="info-upload_btn js-img-upload_btn btn btn-transparent">Загрузить</button>
            </div>

            <div class="right_wrap">
                <div class="label">Заглавие:</div>
                <textarea name="Info[text]" id="info_head" class="info_head" placeholder="Введите текст"><?=$model->text;?></textarea>
                <div class="label">ID:</div>
                <input class="info-id" type="text" name="Info[url]" value="<?=$model->url;?>">
                <input class="info-id" type="hidden" name="Info[id]" value="<?=$model->id;?>">
            </div>
        </div>


        <div class="divider-gray"></div>


        <div class="btns-block">
            <button class="info-save_btn btn btn-blue">Сохранить</button>
            <button class="info-delete_btn js-article-delete-btn btn btn-transparent" data-article-id="/admin/info/delete/<?=$model->id;?>">Удалить</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список полезной информации</h2>

        <?
        if($models){?>
            <?if(count($models) > 0){?>
                <?foreach($models as $oneModel){?>
                    <div class="previous-item-item">
                        <a class="name" href="/admin/info/<?=$oneModel->id;?>"><?=$oneModel->text;?></a>
                        <span class="date"><?=$oneModel->url;?></span>
                        <span class="delete js-article-delete-btn" data-article-id="/admin/info/delete/<?=$model->id;?>">удалить</span>
                    </div>
                <?}?>
            <?}?>
        <?}?>



    </div>
</div>

