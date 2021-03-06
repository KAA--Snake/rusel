<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\widgets\catalog\CatalogMenu;
use common\widgets\search\WSearch;

$this->title = 'My Yii Application';


//меню каталога доступно в $catalog_menu. Раскомментируй отладку ниже чтобы посмотреть его структуру
//\yii\helpers\VarDumper::dump($catalog_menu, 10, true);



?>

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
                        <div class="icon ">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 35 35" enable-background="new 0 0 35 35" xml:space="preserve">
<path d="M7.2,23.2c3.4,4.1,7.6,7.3,12.3,9.6c1.8,0.8,4.2,1.9,6.9,2c0.2,0,0.3,0,0.5,0c1.8,0,3.2-0.6,4.4-1.9c0,0,0,0,0,0
	c0.4-0.5,0.9-1,1.4-1.4c0.3-0.3,0.7-0.7,1-1c1.5-1.6,1.5-3.6,0-5.2L29.3,21c-0.7-0.8-1.6-1.2-2.5-1.2c-0.9,0-1.8,0.4-2.6,1.2
	l-2.6,2.6c-0.2-0.1-0.5-0.3-0.7-0.4c-0.3-0.1-0.6-0.3-0.8-0.4c-2.3-1.5-4.5-3.4-6.5-5.9c-1-1.3-1.7-2.4-2.2-3.5
	c0.7-0.6,1.3-1.2,1.9-1.9c0.2-0.2,0.4-0.4,0.7-0.7c0.8-0.8,1.2-1.7,1.2-2.6S14.8,6.4,14,5.6l-2.1-2.1c-0.3-0.3-0.5-0.5-0.7-0.7
	c-0.5-0.5-1-1-1.5-1.4C8.9,0.5,8,0.2,7.1,0.2c-0.9,0-1.8,0.4-2.6,1.1L1.9,4c-1,1-1.5,2.2-1.6,3.5c-0.1,1.7,0.2,3.5,1,5.7
	C2.5,16.7,4.4,19.8,7.2,23.2z M2,7.7c0.1-1,0.5-1.8,1.1-2.4l2.7-2.7c0.4-0.4,0.9-0.6,1.3-0.6c0.4,0,0.9,0.2,1.3,0.6
	C8.9,3,9.4,3.5,9.8,4c0.2,0.3,0.5,0.5,0.7,0.8l2.1,2.1c0.4,0.4,0.7,0.9,0.7,1.3c0,0.4-0.2,0.9-0.7,1.3c-0.2,0.2-0.4,0.5-0.7,0.7
	c-0.7,0.7-1.3,1.3-2,1.9c0,0,0,0,0,0c-0.6,0.6-0.5,1.2-0.4,1.6c0,0,0,0,0,0.1c0.6,1.3,1.3,2.6,2.5,4.1c2.2,2.7,4.4,4.7,6.9,6.3
	c0.3,0.2,0.6,0.4,1,0.5c0.3,0.1,0.6,0.3,0.8,0.4c0,0,0.1,0,0.1,0c0.2,0.1,0.5,0.2,0.7,0.2c0.6,0,1-0.4,1.1-0.5l2.7-2.7
	c0.4-0.4,0.9-0.6,1.3-0.6c0.5,0,1,0.3,1.3,0.6l4.3,4.3c0.9,0.9,0.9,1.8,0,2.7c-0.3,0.3-0.6,0.6-1,1c-0.5,0.5-1,1-1.5,1.6
	c-0.8,0.9-1.8,1.3-3.1,1.3c-0.1,0-0.3,0-0.4,0c-2.4-0.2-4.6-1.1-6.2-1.9c-4.5-2.2-8.4-5.2-11.7-9.1c-2.7-3.2-4.5-6.2-5.7-9.4
	C2.1,10.7,1.9,9.1,2,7.7z"/>
</svg>
                        </div>
                        <div class="contact">
                            <div class="top">8 (495) 066-42-14</div>
                            <!--<div class="bottom js-recall_popup_trigger">Обратный звонок</div>-->
                            <div class="bottom">Пн-Пт 9:00-18:00(МСК)</div>
                        </div>
                    </div>
                    <div class="contact_item mail">
                        <div class="icon">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 35 35" enable-background="new 0 0 35 35" xml:space="preserve">
                            <path fill="#336699" d="M0,6.6v21.8h35V6.6H0z M32.1,8.1L17.5,19.9L2.9,8.1H32.1z M1.5,26.9v-18l16,12.9l16-12.9v18L1.5,26.9 L1.5,26.9z"/>
                        </svg>
                        </div>
                        <div class="contact">
                            <div class="top">zapros@rusel24.ru</div>
                            <div class="bottom"><a class="mailto-link" href="mailto:zapros@rusel24.ru">Отправить письмо</a></div>
                        </div>
                    </div>
                    <div class="contact_item order">
                        <div class="icon">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 35 35" enable-background="new 0 0 35 35" xml:space="preserve">
<g>
    <path d="M28.5,0l-0.8,4H0.5l2.5,15.1h21.5l-0.7,3.5H4v1.7H25l4.8-22.7h4.7V0H28.5z M24.8,17.5H4.4L2.4,5.7h24.8L24.8,17.5z"/>
    <path d="M4.9,27.3c-2.1,0-3.8,1.7-3.8,3.8S2.8,35,4.9,35s3.8-1.7,3.8-3.8S7,27.3,4.9,27.3z M6.4,32.7c-0.4,0.4-1,0.6-1.5,0.6
		c-1.2,0-2.2-1-2.2-2.2s1-2.2,2.2-2.2S7,30,7,31.2C7,31.7,6.8,32.3,6.4,32.7z"/>
    <path d="M22.9,27.3c-2.1,0-3.8,1.7-3.8,3.8s1.7,3.8,3.8,3.8s3.8-1.7,3.8-3.8S25,27.3,22.9,27.3z M22.9,33.3c-1.2,0-2.2-1-2.2-2.2
		s1-2.2,2.2-2.2s2.2,1,2.2,2.2S24.1,33.3,22.9,33.3z"/>
</g>
</svg>
                        </div>
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

<div class="subheader">


</div>

<div class="content_wrap mw1180">

    <div class="content_inner_wrap col_940">

        <div class="slider">
            <div class="slider_item">
                <img src="<?= Url::to('@web/img/slider/1.png');?>" alt="">
            </div>
            <div class="slider_item">
                <img src="<?= Url::to('@web/img/slider/2.png');?>" alt="">
            </div>
            <div class="slider_item">
                <img src="<?= Url::to('@web/img/slider/3.png');?>" alt="">
            </div>
        </div>
        

        <?=\common\widgets\offers\WOffers::widget();?>

        <div class="content_block specials specials2">
            <h2 class="content_header">Полезная информация</h2>
            <div class="content_body">
                <ul class="specials_list">
                    <li class="specials_item new_row">
                        <a href="/">
                            <div class="specials_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>

                            <div class="specials_name">
                                Скидка на платы от Gigabyte Technology
                            </div>
                        </a>
                    </li>

                    <li class="specials_item">
                        <a href="/">
                            <div class="specials_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>
                            <div class="specials_name">
                                Скидка на платы от Gigabyte Technology
                            </div>
                        </a>
                    </li>

                    <li class="specials_item">
                        <a href="/">
                            <div class="specials_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>
                            <div class="specials_name">
                                Скидка на платы от Gigabyte Technology
                            </div>
                        </a>
                    </li>

                    <li class="specials_item">
                        <a href="/">
                            <div class="specials_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>
                            <div class="specials_name">
                                Скидка на платы от фирмы Gigabyte Technology
                            </div>
                        </a>
                    </li>



                </ul>
            </div>
        </div>

        <?= \common\widgets\offers\WInfo::widget();?>
    </div>
</div>
