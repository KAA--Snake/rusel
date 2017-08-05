<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <!--<meta name="viewport" content="width=device-width, initial-scale=0.5">-->
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
                <textarea name="comment" id="" cols="30" rows="10" placeholder="Примечание к звонку" class="popup-input textarea comment" ></textarea>
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
                                <div class="bottom js-recall_popup_trigger">Обратный звонок</div>
                            </div>
                        </div>
                        <div class="contact_item mail">
                            <div class="icon"></div>
                            <div class="contact">
                                <div class="top">zapros@rusel24.ru</div>
                                <div class="bottom">Отправить письмо</div>
                            </div>
                        </div>
                        <div class="contact_item order">
                            <div class="icon"></div>
                            <div class="contact">
                                <div class="top">Форма запроса</div>
                                <div class="bottom">Выбрано: <span class="order_count">25</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="content_wrap mw1180">

        <div class="col_220 fll">

            <div class="supply_program">
                <div class="sp_header sp_collapsed">ПРОГРАММА ПОСТАВОК</div>
                <div class="sp_body">
                    <div class="sp_filter_block">
                        <input type="text" class="sp_filter" placeholder="Поиск производителя">
                    </div>
                    <ul class="sp_list js-scroll-pane">
                        <!--<li class="sp_item subheader">ПОпулярные:</li>-->
                        <li class="sp_item"><a href="">AAVID Thermalloy</a></li>
                        <li class="sp_item"><a href="">3M</a></li>
                        <li class="sp_item"><a href="">3MTOUCH</a></li>
                        <li class="sp_item"><a href="">AAVID</a></li>
                        <li class="sp_item"><a href="">ADESTO</a></li>
                        <li class="sp_item"><a href="">ADI</a></li>
                        <li class="sp_item"><a href="">ADVANTECH</a></li>
                    </ul>
                </div>
            </div>

        </div>


        <div class="content_top col_940">
            <div class="goods_catalog js-dropdown-catalog">
                <div class="gc_header">Каталог</div>
                <ul class="gc_list gc_list-lvl0" >
                    <li class="gc_item">
                        <a href="/catalog/electric_products/"><span>Электротехнические изделия</span></a>
                    </li>
                    <li class="gc_item">
                        <a href="/catalog/izmeritelnye-pribory/"><span>Измерительные приборы</span></a>
                    </li>
                    <li class="gc_item">
                        <a href="/catalog/electronic_components/"><span>Электронные компоненты</span></a>
                    </li>
                </ul>
            </div>

            <div class="search_block">
                <input type="text" placeholder="Введите искомый артикул" class="search_field">
                <button class="submit_search">Найти</button>
                <button class="list_seach">Поиск по списку</button>
            </div>

        </div>

        <div class="breadcrumbs_menu col_1180">
            <ul class="breadcrumbs_list">
                <li class="breadcrumbs_item breadcrumbs_head">Навигация по каталогу:</li>
                <li class="breadcrumbs_item">
                    <a href="">Измерительные приборы</a>
                    <span class="arrow_next">→</span>
                </li>
                <li class="breadcrumbs_item">
                    <a href="">Комутационная апаратура</a>
                    <span class="arrow_next">→</span>
                </li>
                <li class="breadcrumbs_item current">
                    Пружинные проходные клеммы
                </li>
            </ul>
        </div>

        <div class="goods_filter_block col_1180">
            <div class="goods_filter_inner_wrap">
                <div class="filter_counter">Найдено: <span class="filter_num">345</span> позиций</div>
                <div class="divider"></div>
                <div class="filter_btn">Фильтр</div>
                <div class="divider"></div>
                <div class="filter_params_applied">Условия фильтра не выбраны</div>
                <div class="divider"></div>
                <div class="filter_reset_btn">Сброс</div>
            </div>
        </div>

        <div class="goods_filter_selector col_1180">
            <div class="goods_filter_selector_section">
                <div class="selector_name"></div>
                <div class="selector_tags">
                    
                </div>
            </div>
        </div>




        <div class="content_inner_wrap left0 col_1180">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
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
        */?>


    </div>
</div>

<footer class="footer">
    <div class="mw1180 clear">
        <div class="footer-left fll">© <?= date('Y') ?> ООО"РУСЭЛ24" Все права защищены.</div>

        <div class="footer-right flr">
            <div class="contact_block">
                <div class="contact_item phone">
                    <div class="icon "></div>
                    <div class="contact">
                        <div class="top">8 (495) 066-42-14</div>
                        <div class="bottom js-recall_popup_trigger">Обратный звонок</div>
                    </div>
                </div>
                <div class="contact_item mail">
                    <div class="icon"></div>
                    <div class="contact">
                        <div class="top">zapros@rusel24.ru</div>
                        <div class="bottom">Отправить письмо</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
