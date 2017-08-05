<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\widgets\catalog\CatalogMenu;

$this->title = 'My Yii Application';


//меню каталога доступно в $catalog_menu. Раскомментируй отладку ниже чтобы посмотреть его структуру
//\yii\helpers\VarDumper::dump($catalog_menu, 10, true);



?>

<header class="header">
    <div class="mw1180">
        <nav class="top_menu">
            <a href="" class="nav_item">О проекте</a>
            <a href="" class="nav_item">Оплата и доставка</a>
            <a href="" class="nav_item">Контакты</a>
            <a href="" class="nav_item">Дилерам и агентам</a>
            <a href="" class="nav_item">Команда</a>
            <a href="" class="nav_item">Техподдержка</a>
            <a href="" class="nav_item">Вакансии</a>
            <a href="" class="nav_item">Вопрос техническому специалисту</a>
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
                            <div class="top">8 (495) 589-34-23</div>
                            <div class="bottom">Обратный звонок</div>
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

<div class="subheader">


</div>

<div class="content_wrap mw1180">

    <div class="col_220 fll">

        <div class="supply_program">
            <div class="sp_header">линия поставок</div>
            <div class="sp_body">
                <div class="sp_filter_block">
                    <input type="text" class="sp_filter" placeholder="Поиск по названию">
                </div>
                <ul class="sp_list">
                    <li class="sp_item subheader">ПОпулярные:</li>
                    <li class="sp_item">AAVID Thermalloy</li>
                </ul>
            </div>
        </div>

    </div>


    <div class="content_top col_940">

        <?=CatalogMenu::widget();?>


        <div class="search_block">
            <input type="text" class="search_field">
            <button class="submit_search">Найти</button>
            <button class="list_seach">Поиск по списку</button>
        </div>

    </div>


    <div class="content_inner_wrap col_940">

        <div class="slider">
            <div class="slider_item">
                <img src="<?= Url::to('@web/img/slider_img.png');?>" alt="">
            </div>
            <div class="slider_item">
                <img src="<?= Url::to('@web/img/slider_img.png');?>" alt="">
            </div>
        </div>
        
        <div class="content_block specials">
            <h2 class="content_header">Специальные предложения</h2>
            <div class="content_body">
                <ul class="specials_list">
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

                    <li class="specials_item new_row">
                        <a href="/">
                            <div class="specials_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>

                            <div class="specials_name">
                                Скидка на платы от фирмы Gigabyte Technology
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

                    <li class="specials_item">
                        <a href="/">
                            <div class="specials_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>
                            <div class="specials_name">
                                Скидка на платы от фирмы Gigabyte Technology
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

        <div class="content_block news">
            <h2 class="content_header">Новости</h2>
            <div class="content_body">
                <ul class="news_list">
                    <li class="news_item">
                        <div class="news_pic" style="background-image: url('<?= Url::to('@web/img/news_pic.png');?>')"></div>
                        <h3 class="news_item_header">Скидка на платы от фирмы Gigabyte Technology</h3>
                        <div class="news_item_date">
                            <span class="clock_icon"></span>
                            <span class="date_text">26.02.17</span>
                        </div>
                        <div class="news_item_preview">Не следует, однако забывать, что постоянный количественный рост и сфера нашей активности влечет за собой.процесс внедрения и модернизации форм развития.</div>
                        <div class="news_item_link_wrap">
                            <a href="/" class="news_item_link">
                                Подробнее&nbsp;&nbsp;&nbsp;→
                            </a>
                        </div>

                    </li>

                    <li class="news_item">
                        <div class="news_pic" style="background-image: url('<?= Url::to('@web/img/news_pic.png');?>')"></div>
                        <h3 class="news_item_header">Скидка на платы от фирмы Gigabyte Technology</h3>
                        <div class="news_item_date">
                            <span class="clock_icon"></span>
                            <span class="date_text">26.02.17</span>
                        </div>
                        <div class="news_item_preview">Не следует, однако забывать, что постоянный количественный рост и сфера нашей активности влечет за собой.процесс внедрения и модернизации форм развития.</div>
                        <div class="news_item_link_wrap">
                            <a href="/" class="news_item_link">
                                Подробнее&nbsp;&nbsp;&nbsp;→
                            </a>
                        </div>
                    </li>

                    <li class="news_item">
                        <div class="news_pic" style="background-image: url('<?= Url::to('@web/img/news_pic.png');?>')"></div>
                        <h3 class="news_item_header">Скидка на платы от фирмы Gigabyte Technology</h3>
                        <div class="news_item_date">
                            <span class="clock_icon"></span>
                            <span class="date_text">26.02.17</span>
                        </div>
                        <div class="news_item_preview">Не следует, однако забывать, что постоянный количественный рост и сфера нашей активности влечет за собой.процесс внедрения и модернизации форм развития.</div>
                        <div class="news_item_link_wrap">
                            <a href="/" class="news_item_link">
                                Подробнее&nbsp;&nbsp;&nbsp;→
                            </a>
                        </div>
                    </li>

                    <li class="news_item">
                        <div class="news_pic" style="background-image: url('<?= Url::to('@web/img/news_pic.png');?>')"></div>
                        <h3 class="news_item_header">Скидка на платы от фирмы Gigabyte Technology</h3>
                        <div class="news_item_date">
                            <span class="clock_icon"></span>
                            <span class="date_text">26.02.17</span>
                        </div>
                        <div class="news_item_preview">Не следует, однако забывать, что постоянный количественный рост и сфера нашей активности влечет за собой.процесс внедрения и модернизации форм развития.</div>
                        <div class="news_item_link_wrap">
                            <a href="/" class="news_item_link">
                                Подробнее&nbsp;&nbsp;&nbsp;→
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
