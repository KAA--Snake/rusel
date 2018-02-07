<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\widgets\catalog\CatalogMenu;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=1200px, initial-scale=0.0">
    <meta name="format-detection" content="telephone=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="popup_container recall hidden">
    <div class="flex_wrap">
        <div class="popup recall-popup">
            <div class="close js-recall_popup_close"></div>
            <div class="phone">
                <span class="phone-ico"></span>
                <span class="phone-num">8 (495) 066-42-14</span>
            </div>
            <div class="divider"></div>
            <div class="button_wrap">
                <div class="popup-button call_from_site">Позвонить с сайта</div>
            </div>
            <div class="divider__wide"></div>
            <div class="popup-header">Обратный звонок</div>
            <div class="divider"></div>
            <form action="" class="popup-form">
                <input name="name" type="text" placeholder="Введите ваше ФИО" class="popup-input name_input">
                <input name="phone" type="text" placeholder="Введите Ваш телефон" class="popup-input phone_input">
                <textarea name="comment" id="" cols="30" rows="10" placeholder="Примечание к звонку"
                          class="popup-input textarea comment"></textarea>
                <div class="recaptcha"></div>
                <input type="submit" class="popup-button" value="Заказать">
            </form>
        </div>
    </div>


    <div class="overlay"></div>
</div>

<div class="wrap">
    <div class="container main">

        <? echo \Yii::$app->view->renderFile('@app/views/includes/layout_v1/header.php');?>

        <div class="content_wrap mw1180">

            <div class="col_220 fll">

                <div class="supply_program">
                    <? echo $this->render('@app/views/includes/manufacturers_fullwidth.php', [
                        'manufacturers' => $this->params['manufacturers'],
                    ]);?>
                </div>

            </div>


            <div class="content_top col_940">
                <?=CatalogMenu::widget(['maket' => 'menu_full_width']);?>

                <div class="search_block">
                    <input type="text" placeholder="Введите искомый артикул" class="search_field">
                    <button class="submit_search">Найти</button>
                    <a href="/search/" class="list_seach">Поиск по списку</a>
                </div>

            </div>

            <div class="breadcrumbs_menu col_1180">
                <?= Breadcrumbs::widget([
                    'options'       =>  [
                        //'id'        =>  'breadCrumbs',
                        'class'        =>  'breadcrumbs_list',
                    ],
                    'homeLink' => ['label' => 'Навигация по каталогу:'],
                    'itemTemplate' => "<li class='breadcrumbs_item breadcrumbs_head'>{link}</li>", // for main
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);?>

            </div>


            <div class="content_inner_wrap left0 col_1180 search_by_list">

                <?= Alert::widget() ?>
                <?= $content ?>


            </div>
        </div>


    </div>
</div>
</div>


<footer class="footer">
    <? echo \Yii::$app->view->renderFile('@app/views/includes/layout_v1/footer.php');?>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
