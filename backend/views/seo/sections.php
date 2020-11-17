<?php

/* @var $this yii\web\View */

$this->title = 'Sections Seo Texts';
if($model){
    $errors = $model->getErrors();
    if(!empty($errors)){
        foreach ($errors as $oneError) {?>
            <div class="back-link-wrap ">
                <?php \Yii::$app->pr->printR2WOChecks($oneError); ?>
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

    <h1 class="header_h1">Форма для создания/редактирования СЕО текста категории каталога</h1>

    <form action="/admin/seo/section/add" method="post" id="news_add-form" class="news_add-form" enctype="multipart/form-data">
        <input class="info-id" type="hidden" name="SeoSection[id]" value="<?=$model->id;?>">


        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Название для отображения</div>
                <input class="news-name" type="text" name="SeoSection[name]" value="<?=$model->name;?>">
            </div>

            <div class="right_wrap news-id_block">
                <div class="label">ID категории:</div>
                <input class="news-id" type="text" name="SeoSection[section_id]" value="<?=$model->section_id;?>">
            </div>
        </div>

        <div class="flex_wrap news-content_row">
            <div class="right_wrap news-textarea_block">
                <textarea class="static_textarea" cols="100" rows="10" name="SeoSection[text]"><?=$model->text;?></textarea>
            </div>
        </div>

        <div class="divider-gray"></div>

        <div class="btns-block">
            <button class="news-save_btn btn btn-blue">Сохранить</button>
            <button class="news-delete_btn js-article-delete-btn btn btn-transparent" data-article-id="/admin/seo/section/delete/<?=$model->id;?>">Удалить</button>
            <button class="news-new_btn btn" onclick="window.location.href='/admin/seo/section'; return false;" >Новый</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список всех СЕО текстов категорий:</h2>

        <?
        if($models){?>
            <?if(count($models) > 0){?>
                <?foreach($models as $oneModel){?>

                    <div class="previous-item-item">
                        <span class="name" onclick="location.href='/admin/seo/section/<?=$oneModel->id;?>'"><?=$oneModel->name;?></span>
                        <span class="date"></span>
                        <span class="delete js-article-delete-btn" data-article-id="/admin/seo/section/delete/<?=$oneModel->id;?>">удалить</span>
                    </div>
                <?}?>
            <?}?>
        <?}?>

    </div>
</div>


