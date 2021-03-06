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
use common\widgets\search\WSearch;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
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

        <header class="header">
            <div class="mw1180">
                <nav class="top_menu">
                    <a href="" class="nav_item">О проекте</a>
                    <a href="" class="nav_item">Оплата и доставка</a>
                    <a href="" class="nav_item">Публичная оферта</a>
                    <a href="" class="nav_item">Сотрудничество</a>
                    <a href="" class="nav_item">Вакансии</a>
                    <a href="" class="nav_item">Контакты</a>
                </nav>

                <div class="header_info clear">
                    <div class="fll">
                        <a href="/" class="logo_link">
                            <div class="logo_ico"></div>
                            <div class="logo_name"></div>
                        </a>
                    </div>

                    <div class="flr">
                        <div class="contact_block">
                            <div class="contact_item phone">
                                <div class="icon "></div>
                                <div class="contact">
                                    <div class="top">8 (495) 066-42-14</div>
                                    <!--<div class="bottom js-recall_popup_trigger">Обратный звонок</div>-->
                                    <div class="bottom">Пн-Пт 9:00-18:00(МСК)</div>
                                </div>
                            </div>
                            <div class="contact_item mail">
                                <div class="icon"></div>
                                <div class="contact">
                                    <div class="top">zapros@rusel24.ru</div>
                                    <div class="bottom"><a class="mailto-link" href="mailto:zapros@rusel24.ru">Отправить письмо</a></div>
                                </div>
                            </div>
                            <div class="contact_item order">
                                <div class="icon"></div>
                                <div class="contact">
                                    <a href="/cart/">
                                        <div class="top">Форма запроса</div>
                                        <div class="bottom">Выбрано: <span class="order_count">0</span></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="content_wrap mw1180">

            <div class="breadcrumbs_menu col_1180">
                <?= Breadcrumbs::widget([
                    'options'       =>  [
                        //'id'        =>  'breadCrumbs',
                        'class'        =>  'breadcrumbs_list',
                    ],
                    'homeLink' => ['label' => 'Каталог:'],
                    'itemTemplate' => "<li class='breadcrumbs_item breadcrumbs_head'>{link}</li>", // for main
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);?>

            </div>


            <div class="content_inner_wrap left0 col_1180 search_by_list">

                <?= Alert::widget() ?>
                <?= $content ?>


            </div>
        </div>

        <?php
        /*    NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>';
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            */ ?>


    </div>
</div>

<footer class="footer">
    <? echo \Yii::$app->view->renderFile('@app/views/includes/layout_v1/footer.php');?>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
