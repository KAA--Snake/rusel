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

<div class="subheader">


</div>

<div class="content_wrap mw1180">

    <div class="col_220 fll">

        <div class="supply_program">
            <div class="sp_header">ПРОГРАММА ПОСТАВОК</div>
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
                    <li class="sp_item"><a href="">AIMTEC</a></li>
                    <li class="sp_item"><a href="">ALLEGRO</a></li>
                    <li class="sp_item"><a href="">ALPHAO</a></li>
                    <li class="sp_item"><a href="">ALTERA</a></li>
                    <li class="sp_item"><a href="">AMBER</a></li>
                    <li class="sp_item"><a href="">AMD</a></li>
                    <li class="sp_item"><a href="">AMPHENOL</a></li>
                    <li class="sp_item"><a href="">ANAREN</a></li>
                    <li class="sp_item"><a href="">ARW_EPC</a></li>
                    <li class="sp_item"><a href="">ARW_OCS</a></li>
                    <li class="sp_item"><a href="">ASTRODYNE</a></li>
                    <li class="sp_item"><a href="">AUO</a></li>
                    <li class="sp_item"><a href="">AVAGO</a></li>
                    <li class="sp_item"><a href="">AVX</a></li>
                    <li class="sp_item"><a href="">AXON</a></li>
                    <li class="sp_item"><a href="">BELDEN</a></li>
                    <li class="sp_item"><a href="">BOURNS</a></li>
                    <li class="sp_item"><a href="">CARCLO</a></li>
                    <li class="sp_item"><a href="">CCT</a></li>
                    <li class="sp_item"><a href="">CK</a></li>
                    <li class="sp_item"><a href="">CMLIT</a></li>
                    <li class="sp_item"><a href="">CONNECTB</a></li>
                    <li class="sp_item"><a href="">CONTELEC</a></li>
                    <li class="sp_item"><a href="">COOPERTOOL</a></li>
                    <li class="sp_item"><a href="">CORTINA</a></li>
                    <li class="sp_item"><a href="">CRC</a></li>
                    <li class="sp_item"><a href="">CREE</a></li>
                    <li class="sp_item"><a href="">CRYDOM</a></li>
                    <li class="sp_item"><a href="">CYPRESS</a></li>
                    <li class="sp_item"><a href="">DIGISOUND</a></li>
                    <li class="sp_item"><a href="">DIGITALVW</a></li>
                    <li class="sp_item"><a href="">DIODES</a></li>
                    <li class="sp_item"><a href="">DIODEZETEX</a></li>
                    <li class="sp_item"><a href="">DIOTEC</a></li>
                    <li class="sp_item"><a href="">DOMINANT</a></li>
                    <li class="sp_item"><a href="">EAO</a></li>
                    <li class="sp_item"><a href="">EBKTELTOW</a></li>
                    <li class="sp_item"><a href="">EBMPAPST</a></li>
                    <li class="sp_item"><a href="">ECLIPTEK</a></li>
                    <li class="sp_item"><a href="">EFB</a></li>
                    <li class="sp_item"><a href="">EPCOS</a></li>
                    <li class="sp_item"><a href="">ERNI</a></li>
                    <li class="sp_item"><a href="">EUR</a></li>
                    <li class="sp_item"><a href="">EVERLIGHT</a></li>
                    <li class="sp_item"><a href="">EVERSPIN</a></li>
                    <li class="sp_item"><a href="">EVERVISION</a></li>
                    <li class="sp_item"><a href="">EXAR</a></li>
                    <li class="sp_item"><a href="">FAGOR</a></li>
                    <li class="sp_item"><a href="">FAIRCHILD</a></li>
                    <li class="sp_item"><a href="">FAIRRITE</a></li>
                    <li class="sp_item"><a href="">FASTRON</a></li>
                    <li class="sp_item"><a href="">FCI</a></li>
                    <li class="sp_item"><a href="">FERROXCUBE</a></li>
                    <li class="sp_item"><a href="">FINDER</a></li>
                    <li class="sp_item"><a href="">FISCHERELE</a></li>
                    <li class="sp_item"><a href="">FOHRENBACH</a></li>
                    <li class="sp_item"><a href="">FOX</a></li>
                    <li class="sp_item"><a href="">FRAEN</a></li>
                    <li class="sp_item"><a href="">FUJITSU</a></li>
                    <li class="sp_item"><a href="">GENNUM</a></li>
                    <li class="sp_item"><a href="">GNS</a></li>
                    <li class="sp_item"><a href="">HAHN</a></li>
                    <li class="sp_item"><a href="">HANLONG</a></li>
                    <li class="sp_item"><a href="">HARTMANN</a></li>
                    <li class="sp_item"><a href="">HELLERMANN</a></li>
                    <li class="sp_item"><a href="">HONEYWELL</a></li>
                    <li class="sp_item"><a href="">IDT</a></li>
                    <li class="sp_item"><a href="">INFINEON</a></li>
                    <li class="sp_item"><a href="">INFINITEPS</a></li>
                    <li class="sp_item"><a href="">INTEL</a></li>
                    <li class="sp_item"><a href="">IQDFREQ</a></li>
                    <li class="sp_item"><a href="">ISSI</a></li>
                    <li class="sp_item"><a href="">ITT</a></li>
                    <li class="sp_item"><a href="">ITWPANCON</a></li>
                    <li class="sp_item"><a href="">IXYS</a></li>
                    <li class="sp_item"><a href="">JOHANSON</a></li>
                    <li class="sp_item"><a href="">JSTGERMANY</a></li>
                    <li class="sp_item"><a href="">KAIMEI</a></li>
                    <li class="sp_item"><a href="">KAMAYA</a></li>
                    <li class="sp_item"><a href="">KEMET</a></li>
                    <li class="sp_item"><a href="">KHATOD</a></li>
                    <li class="sp_item"><a href="">KINGBRIGHT</a></li>
                    <li class="sp_item"><a href="">KINGSTON</a></li>
                    <li class="sp_item"><a href="">KNITTER</a></li>
                    <li class="sp_item"><a href="">KONFEKTRON</a></li>
                    <li class="sp_item"><a href="">KYOCERA</a></li>
                    <li class="sp_item"><a href="">LAIRD</a></li>
                    <li class="sp_item"><a href="">LAPP</a></li>
                    <li class="sp_item"><a href="">LEDIL</a></li>
                    <li class="sp_item"><a href="">LELON</a></li>
                    <li class="sp_item"><a href="">LIGHTECH</a></li>
                    <li class="sp_item"><a href="">LINEAGE</a></li>
                    <li class="sp_item"><a href="">LITEON</a></li>
                    <li class="sp_item"><a href="">LITTELFUSE</a></li>
                    <li class="sp_item"><a href="">LOGICPD</a></li>
                    <li class="sp_item"><a href="">LOWEKO</a></li>
                    <li class="sp_item"><a href="">LSI</a></li>
                    <li class="sp_item"><a href="">LUCAS</a></li>
                    <li class="sp_item"><a href="">LUMBERG</a></li>
                    <li class="sp_item"><a href="">MACRONIX</a></li>
                    <li class="sp_item"><a href="">MAKRONIX</a></li>
                    <li class="sp_item"><a href="">MATROX</a></li>
                    <li class="sp_item"><a href="">MCCSEMI</a></li>
                    <li class="sp_item"><a href="">MEANWELL</a></li>
                    <li class="sp_item"><a href="">METROFUNK</a></li>
                    <li class="sp_item"><a href="">MICRON</a></li>
                    <li class="sp_item"><a href="">MICROSOFT</a></li>
                    <li class="sp_item"><a href="">MICROTRONX</a></li>
                    <li class="sp_item"><a href="">MINWA</a></li>
                    <li class="sp_item"><a href="">MOLEX</a></li>
                    <li class="sp_item"><a href="">MURATA</a></li>
                    <li class="sp_item"><a href="">N2POWER</a></li>
                    <li class="sp_item"><a href="">NATIONAL</a></li>
                    <li class="sp_item"><a href="">NEXPERIA</a></li>
                    <li class="sp_item"><a href="">NICHICON</a></li>
                    <li class="sp_item"><a href="">NKK</a></li>
                    <li class="sp_item"><a href="">NXP</a></li>
                    <li class="sp_item"><a href="">OKW</a></li>
                    <li class="sp_item"><a href="">OMRON</a></li>
                    <li class="sp_item"><a href="">ONSEMI</a></li>
                    <li class="sp_item"><a href="">OSRAMOPTO</a></li>
                    <li class="sp_item"><a href="">PANASONIC</a></li>
                    <li class="sp_item"><a href="">PANDUIT</a></li>
                    <li class="sp_item"><a href="">PEW</a></li>
                    <li class="sp_item"><a href="">PHOENIX</a></li>
                    <li class="sp_item"><a href="">PLETRONICS</a></li>
                    <li class="sp_item"><a href="">PORTWELL</a></li>
                    <li class="sp_item"><a href="">POWERSYS</a></li>
                    <li class="sp_item"><a href="">PRECIDIP</a></li>
                    <li class="sp_item"><a href="">PSZELEC</a></li>
                    <li class="sp_item"><a href="">PULSE</a></li>
                    <li class="sp_item"><a href="">RADIALL</a></li>
                    <li class="sp_item"><a href="">RECOM</a></li>
                    <li class="sp_item"><a href="">REDPINE</a></li>
                    <li class="sp_item"><a href="">RENESAS</a></li>
                    <li class="sp_item"><a href="">SAMSUNG</a></li>
                    <li class="sp_item"><a href="">SAMSUNGEM</a></li>
                    <li class="sp_item"><a href="">SANDISK</a></li>
                    <li class="sp_item"><a href="">SCHAFFNER</a></li>
                    <li class="sp_item"><a href="">SCHROFF</a></li>
                    <li class="sp_item"><a href="">SCHURTER</a></li>
                    <li class="sp_item"><a href="">SECO</a></li>
                    <li class="sp_item"><a href="">SEMIKRON</a></li>
                    <li class="sp_item"><a href="">SENSATA</a></li>
                    <li class="sp_item"><a href="">SHARP</a></li>
                    <li class="sp_item"><a href="">SIBA</a></li>
                    <li class="sp_item"><a href="">SIEMENS</a></li>
                    <li class="sp_item"><a href="">SILICONLAB</a></li>
                    <li class="sp_item"><a href="">SITIME</a></li>
                    <li class="sp_item"><a href="">SKS</a></li>
                    <li class="sp_item"><a href="">SKSKONTAKT</a></li>
                    <li class="sp_item"><a href="">SMCBV</a></li>
                    <li class="sp_item"><a href="">SOURIAU</a></li>
                    <li class="sp_item"><a href="">SPANSION</a></li>
                    <li class="sp_item"><a href="">STEC</a></li>
                    <li class="sp_item"><a href="">STMICRO</a></li>
                    <li class="sp_item"><a href="">SUMIDA</a></li>
                    <li class="sp_item"><a href="">SUPERMICRO</a></li>
                    <li class="sp_item"><a href="">TADIRAN</a></li>
                    <li class="sp_item"><a href="">TAIWANSEMI</a></li>
                    <li class="sp_item"><a href="">TDK</a></li>
                    <li class="sp_item"><a href="">TDKLAMBDA</a></li>
                    <li class="sp_item"><a href="">TE</a></li>
                    <li class="sp_item"><a href="">TELIT</a></li>
                    <li class="sp_item"><a href="">TI</a></li>
                    <li class="sp_item"><a href="">TOSHIBA</a></li>
                    <li class="sp_item"><a href="">TOUCH</a></li>
                    <li class="sp_item"><a href="">TRACO</a></li>
                    <li class="sp_item"><a href="">TRIDENT</a></li>
                    <li class="sp_item"><a href="">TXC</a></li>
                    <li class="sp_item"><a href="">UNKNOWNARW</a></li>
                    <li class="sp_item"><a href="">VANSON</a></li>
                    <li class="sp_item"><a href="">VISHAY</a></li>
                    <li class="sp_item"><a href="">VISHAYPG</a></li>
                    <li class="sp_item"><a href="">VITROHM</a></li>
                    <li class="sp_item"><a href="">WALSIN</a></li>
                    <li class="sp_item"><a href="">WEEN</a></li>
                    <li class="sp_item"><a href="">WELLER</a></li>
                    <li class="sp_item"><a href="">WELWYN</a></li>
                    <li class="sp_item"><a href="">WESTERNDIG</a></li>
                    <li class="sp_item"><a href="">WIMA</a></li>
                    <li class="sp_item"><a href="">WINBOND</a></li>
                    <li class="sp_item"><a href="">WINDBOND</a></li>
                    <li class="sp_item"><a href="">YAGEO</a></li>
                    <li class="sp_item"><a href="">ZENARO</a></li>
                </ul>
            </div>
        </div>

    </div>


    <div class="content_top col_940">

        <?=CatalogMenu::widget();?>


        <div class="search_block">
            <input type="text" placeholder="Введите искомый артикул" class="search_field">
            <button class="submit_search">Найти</button>
            <button class="list_seach">Поиск по списку</button>
        </div>

    </div>


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
