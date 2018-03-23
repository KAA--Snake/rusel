<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\widgets\catalog\CatalogMenu;
use common\widgets\main_slider\MainSlider;

$this->title = 'My Yii Application';


//меню каталога доступно в $catalog_menu. Раскомментируй отладку ниже чтобы посмотреть его структуру
//\yii\helpers\VarDumper::dump($catalog_menu, 10, true);



?>



<div class="subheader">


</div>

<div class="content_wrap mw1180">

    <div class="col_220 fll">

        <div class="supply_program">
            <? echo $this->render('@app/views/includes/manufacturers.php', [
                'manufacturers' => $this->params['manufacturers'],
            ]);?>
        </div>

    </div>


    <div class="content_top col_940">

        <?=CatalogMenu::widget();?>


        <div class="search_block">
            <input type="text" placeholder="Введите искомый артикул" class="search_field">
            <button class="submit_search">Найти</button>
            <a href="/search/" class="list_seach">Поиск по списку</a>
        </div>

    </div>


    <div class="content_inner_wrap col_940">

        <h1 class="main-page_h1">КОМПЛЕКСНОЕ СНАБЖЕНИЕ КОМПЛЕКТУЮЩИМИ</h1>

        <?=MainSlider::widget();?>
        
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

                </ul>
            </div>
        </div>

        <div class="content_block useful-info">
            <h2 class="content_header">Полезная информация</h2>
            <div class="content_body">
                <ul class="useful-info_list">
                    <li class="useful-info_item">
                        <a href="/">
                            <div class="useful-info_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>

                            <div class="useful-info_name">
                                Не следует, однако забывать, что рамки и
                                место обучения кадров.
                            </div>
                        </a>
                    </li>

                    <li class="useful-info_item">
                        <a href="/">
                            <div class="useful-info_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>
                            <div class="useful-info_name">
                                Скидка на платы от Gigabyte Technology
                            </div>
                        </a>
                    </li>

                    <li class="useful-info_item">
                        <a href="/">
                            <div class="useful-info_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>

                            <div class="useful-info_name">
                                Скидка на платы от Gigabyte Technology
                            </div>
                        </a>
                    </li>

                    <li class="useful-info_item">
                        <a href="/">
                            <div class="useful-info_img" style="background-image: url('<?= Url::to('@web/img/special_img.png');?>')"></div>

                            <div class="useful-info_name">
                                Скидка на платы от Gigabyte Technology
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
                        <h3 class="news_item_header">Скидка на платы от Gigabyte Technology</h3>
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
                        <h3 class="news_item_header">Скидка на платы от Gigabyte Technology</h3>
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
