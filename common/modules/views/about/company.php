<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use common\widgets\Alert;


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
                                    <div class="top">Форма запроса</div>
                                    <div class="bottom">Выбрано: <span class="order_count">0</span></div>
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
                    <? echo $this->render('@app/views/includes/manufacturers.php', [
                        'manufacturers' => $this->params['manufacturers'],
                    ]);?>
                </div>

            </div>


            <div class="content_top col_940">
                <div class="goods_catalog js-dropdown-catalog">
                    <div class="gc_header">Каталог</div>
                    <ul class="gc_list gc_list-lvl0">
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
                    <a href="/search/" class="list_seach">Поиск по списку</a>
                </div>

            </div>

            <div class="content_inner_wrap left0 col_1180 about_company">
                <h1>О проекте</h1>
                <img src="<?= Url::to('@web/img/about_1.png');?>" alt="" class="fll">

                <p>Равным образом рамки и место обучения кадров в значительной степени обуславливает создание модели развития. Товарищи! сложившаяся структура организации позволяет выполнять важные задания по разработке существенных финансовых и административных условий.</p>

                <p>Товарищи! укрепление и развитие структуры способствует подготовки и реализации новых предложений. Таким образом консультация с широким активом влечет за собой процесс внедрения и модернизации систем массового участия. Идейные соображения высшего порядка, а также постоянный количественный рост и сфера нашей активности требуют от нас анализа новых предложений.</p>

                <p>Таким образом постоянный количественный рост и сфера нашей активности влечет за собой процесс внедрения и модернизации дальнейших направлений развития. Товарищи! новая модель организационной деятельности позволяет выполнять важные задания по разработке позиций.</p>

                <p>Равным образом рамки и место обучения кадров в значительной степени обуславливает создание модели развития. Товарищи! сложившаяся структура организации позволяет выполнять важные задания по разработке существенных финансовых и административных условий.</p>

                <p>Равным образом рамки и место обучения кадров в значительной степени обуславливает создание модели развития. Товарищи! сложившаяся структура организации позволяет выполнять важные задания по разработке существенных финансовых и административных условий.</p>

                <p>Товарищи! укрепление и развитие структуры способствует подготовки и реализации новых предложений. Таким образом консультация с широким активом влечет за собой процесс внедрения и модернизации систем массового участия. Идейные соображения высшего порядка, а также постоянный количественный рост и сфера нашей активности требуют от нас анализа новых предложений.</p>

                <img src="<?= Url::to('@web/img/about_2.png');?>" alt="" class="flr">

                <ul class="reddot_list">
                    <li>Равным образом рамки и место обучения кадров в значительной степени обуславливает создание
                        модели развития. </li>
                    <li>Товарищи сложившаяся структура организации позволяет выполнять важные задания по разработке существенных финансовых и административных условий.</li>
                    <li>Идейные соображения высшего порядка, а также постоянный количественный рост.</li>
                </ul>

                <p>Равным образом рамки и место обучения кадров в значительной степени обуславливает создание модели развития. Товарищи! сложившаяся структура организации позволяет выполнять важные задания по разработке существенных финансовых и административных условий.</p>


            </div>
        </div>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
