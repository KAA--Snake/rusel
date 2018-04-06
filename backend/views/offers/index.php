<?php

/* @var $this yii\web\View */

$this->title = 'admin Offer page';
?>

<div class="inner_wrap mw1180">
    <div class="back-link-wrap ">
        <a href="/admin" class="back-link btn btn-blue">←  Вернуться в меню админки</a>
    </div>

    <h1 class="header_h1">Форма для загрузки специальных предложений</h1>
    <form action="/admin/offers/add" method="post" id="offer_add-form" class="offer_add-form" enctype="multipart/form-data">

        <input type="hidden" name="Offers[id]" value="<?=$model->id;?>">


        <div class="flex_wrap">
            <div class="left_wrap">
                <div class="label">Картинка:</div>
                <div class="uploaded_img">
                    <img class="js-filereader-target" src="<?=$model->big_img_src;?>" alt="">
                </div>
                <input type="file" name="Offers[file]" class="offer-img-upload js-img-upload_input hidden">
                <div class="img_instructions">Размер картинки: <span class="img-size">220 x 170 px</span></div>
                <button class="offer-upload_btn js-img-upload_btn btn btn-transparent">Загрузить</button>
            </div>

            <div class="right_wrap">
                <div class="label">Заглавие:</div>
                <textarea name="Offers[name]" id="offer_head" class="offer_head" placeholder="Введите текст"><?=$model->name;?></textarea>
                <div class="label">URL:</div>
                <input class="offer-id" type="text" name="Offers[url]" value="<?=$model->url;?>">

                <div class="label">ID свойств:</div>
                <textarea name="Offers[property_ids]" id="offer_head" class="offer_goods_list" placeholder="Введите текст"><?=$model->property_ids;?></textarea>


                <div class="label">ID товаров:</div>
                <textarea name="Offers[product_ids]" id="offer_head" class="offer_goods_list" placeholder="Введите текст"><?=$model->product_ids;?></textarea>


            </div>
        </div>


        <div class="divider-gray"></div>


        <div class="btns-block">
            <button class="offer-save_btn btn btn-blue">Сохранить</button>
            <button class="news-delete_btn js-article-delete-btn btn btn-transparent" data-article-id="/admin/offers/delete/<?=$model->id;?>">Удалить</button>
        </div>
    </form>

    <div class="previous-item-block">
        <h2 class="header_bord-bot">Список полезной информации</h2>

        <?if($models){?>
            <?if(count($models) > 0){?>
                <?foreach($models as $oneModel){?>

                    <div class="previous-item-item">
                        <span class="name" onclick="location.href='/admin/offers/<?=$oneModel->id;?>'"><?=$oneModel->name;?></span>
                        <span class="delete js-article-delete-btn" data-article-id="/admin/offers/delete/<?=$oneModel->id;?>">удалить</span>
                    </div>
                <?}?>
            <?}?>
        <?}?>


    </div>
</div>

