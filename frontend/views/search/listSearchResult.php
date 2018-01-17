<?

use yii\helpers\Url;
use common\modules\catalog\models\currency\Currency;

?>

<div class="search_by_list">
    <h1>Поиск по списку</h1>

    <div class="file_name_block">
        <div>
            Список:
            <span class="uploaded_file_name"><?= Yii::$app->session->getFlash('uploadedFileName'); ?></span>
            <div class="by-artikuls_submit_btn_fin">Поиск завершен</div>
        </div>
    </div>

    <div class="fake_divider"></div>
    <?
    /**
     * Обрати внимание, найденные товары идут в такой же очередности что и артикулы
     * т.е. для артикула $artiklesList[0] результат поиска будет лежать в $productsList[0]
     *
     */
    ?>

    <div class="articles_list">
        <? foreach ($artiklesList as $productKey => $oneArticle) {
            $articleProducts = $productsList[$productKey];

            if (isset($articleProducts['error'])) {
                $foundProducts = 0;
            } else {
                $foundProducts = count($articleProducts);
            }

            /*Yii::$app->pr->print_r2($articleProducts);*/
            ?>
            <div class="articles_item collapsed">

                <div class="articles_item_head">
                    <table class="table-head-inner" style="width: 100%">
                        <tr>
                            <td class="table-head-inner_name" style="text-align: left;">
                                <span class="article_name">
                        <span class="square_icon"></span>
                                    <?= $oneArticle; ?>
                    </span>
                            </td>
                            <td class="table-head-inner_count">
                                <span class="article_count">Найдено: <span
                                            class="article_count_num"><?= $foundProducts; ?></span></span>
                            </td>
                            <td class="table-head-inner_btn" style="text-align: right">
                                <span class="head-article_collapse-btn article_expand-btn">
                        <span class="js-word">Подробнее</span>
                        <span class="arrow"></span>
                    </span>
                            </td>
                        </tr>
                    </table>


                </div>

                <div class="articles_item_body product_cards_block">

                    <? /*Yii::$app->pr->print_r2($articleProducts);*/ ?>
                    <?php if (count($articleProducts) > 0) { ?>

                        <?php foreach ($articleProducts as $k => $oneProduct) {
                            if ($foundProducts > 0) {
                                $json = json_encode($oneProduct);

                                $url = Url::to('@catalogDir/' . str_replace('|', '/', $oneProduct['_source']['url']) . '/');
                                //\Yii::$app->pr->print_r2($oneProduct);
                                ?>

                                <div class="product_card js-product_card js-tab_collapsed <?php if($k > 9){?>product_card--hidden<?php }?>">
                                    <table class="product_card_inner_wrap">
                                        <tr>
                                            <td>
                                                <div class="card_part name">
                                                    <div class="model">
                                                        <a href="<?= $url; ?>"><?= $oneProduct['_source']['artikul']; ?></a>
                                                    </div>
                                                    <div class="firm_name">
                                                        <a href="/manufacturer/<?= $oneProduct['_source']['properties']['proizvoditel']; ?>/"><?= $oneProduct['_source']['properties']['proizvoditel']; ?></a>
                                                    </div>
                                                    <div class="firm_descr">
                                                        <?= $oneProduct['_source']['name']; ?>
                                                    </div>
                                                    <?php if (!empty($oneProduct['_source']['other_properties']['property']) || !empty($oneProduct['_source']['properties']['teh_doc_file']) || !empty($oneProduct['_source']['properties']['detail_text']) || (isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0)) { ?>
                                                        <div class="more js-expand-tabs">
                                                            <a href="">Подробнее ↓</a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                            <td>

                                            </td>
                                            <td>
                                                <div class="card_part img">
                                                    <?php if (isset($oneProduct['_source']['properties']['main_picture']) && !is_array($oneProduct['_source']['properties']['main_picture'])) { ?>
                                                        <img src="<?= Url::to('@catImages/' . $oneProduct['_source']['properties']['main_picture']); ?>"
                                                             alt="">
                                                    <?php } ?>
                                                </div>
                                            </td>
                                            <td class="left_bordered">
                                                <div class="card_part in_stock">
                                                    <?php
                                                    //флаг- есть ли хоть 1 товар в доступных ?
                                                    $isAnyAvailable = false;
                                                    $isAnyAvailablePartner = false; ?>

                                                    <table class="instock">
                                                        <?php if (isset($oneProduct['_source']['quantity']['stock']['count']) && $oneProduct['_source']['quantity']['stock']['count'] > 0) {
                                                            $isAnyAvailable = true;
                                                            ?>
                                                            <tr>
                                                                <td class="instock_def">Доступно:</td>
                                                                <td class="instock_count">
                                                                    <?= $oneProduct['_source']['quantity']['stock']['count']; ?> <?= $oneProduct['_source']['ed_izmerenia']; ?>

                                                                    <?php if (!empty($oneProduct['_source']['quantity']['stock']['description'])) { ?>
                                                                        <span class="count_tooltip_trigger"><?= $oneProduct['_source']['quantity']['stock']['description']; ?>
                                                                            <span class="count_tooltip">Срок отгрузки со склада РУСЭЛ.24 после оплаты счета <span
                                                                                        class="corner"></span></span></span>

                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>

                                                        <?php if (isset($oneProduct['_source']['quantity']['partner_stock']['count']) && $oneProduct['_source']['quantity']['partner_stock']['count'] > 0) {
                                                            $isAnyAvailablePartner = true;
                                                            ?>
                                                            <tr>
                                                                <td class="instock_def"> <?php if (!$isAnyAvailable) { ?>Доступно:<?php } ?></td>
                                                                <td class="instock_count partner">
                                                                    <?= $oneProduct['_source']['quantity']['partner_stock']['count']; ?> <?= $oneProduct['_source']['ed_izmerenia']; ?>

                                                                    <?php if (!empty($oneProduct['_source']['quantity']['partner_stock']['description']) && !is_array($oneProduct['_source']['quantity']['partner_stock']['description'])) { ?>
                                                                        <span class="count_tooltip_trigger"><?= $oneProduct['_source']['quantity']['partner_stock']['description']; ?>
                                                                            <span class="count_tooltip">Срок отгрузки со склада РУСЭЛ.24 после оплаты счета <span
                                                                                        class="corner"></span></span></span>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>

                                                        <?php } ?>

                                                        <?php if (!$isAnyAvailable && !$isAnyAvailablePartner) { ?>
                                                            <tr>
                                                                <td class="instock_def">Доступно:</td>
                                                                <td class="instock_count">
                                                                    0 <?= $oneProduct['_source']['ed_izmerenia']; ?></td>
                                                            </tr>
                                                        <?php } ?>

                                                        <?php if (isset($oneProduct['_source']['quantity']['for_order']['description'])) {

                                                            if (!is_array($oneProduct['_source']['quantity']['for_order']['description'])) {
                                                                $overText = 'Доп. заказ:';
                                                                if (!$isAnyAvailable && !$isAnyAvailablePartner) {
                                                                    $overText = 'Под заказ:';
                                                                } ?>
                                                                <tr>
                                                                    <td class="instock_def"><?= $overText; ?></td>
                                                                    <td class="instock_count">
                                                                        <?php if (!empty($oneProduct['_source']['quantity']['for_order']['description']) && !is_array($oneProduct['_source']['quantity']['for_order']['description'])) { ?>
                                                                            <?= $oneProduct['_source']['quantity']['for_order']['description']; ?>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>

                                                            <?php } ?>
                                                        <?php } ?>
                                                        <tr>
                                                            <td><br></td>
                                                            <td><br></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="instock_def">Упаковка:</td>
                                                            <td class="instock_count"><?= $oneProduct['_source']['product_logic']['norma_upakovki']; ?> <?= $oneProduct['_source']['ed_izmerenia']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="instock_def">Мин. партия:</td>
                                                            <td class="instock_count"><?= $oneProduct['_source']['product_logic']['min_zakaz']; ?> <?= $oneProduct['_source']['ed_izmerenia']; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                            <td class="left_bordered">
                                                <div class="card_part prices">
                                                    <?php if (!empty($oneProduct['_source']['marketing']['price']) && $oneProduct['_source']['marketing']['price'] > 0) { ?>

                                                        <?
                                                        //\Yii::$app->pr->print_r2($oneProduct['_source']['marketing']);
                                                        $price = Currency::getPriceForCurrency(
                                                            $oneProduct['_source']['marketing']['currency'],
                                                            $oneProduct['_source']['marketing']['price'],
                                                            2
                                                        );
                                                        ?>
                                                        <div class="special_tape"><?= $oneProduct['_source']['marketing']['name']; ?></div>
                                                        <div class="price_vars">
                                                            <div class="price_var_item clear">
                                                                <span class="count fll"></span>
                                                                <span class="price flr"><?= $price; ?>
                                                                    <?= Currency::getCurrencyName(); ?>
                                                                    /<?= $oneProduct['_source']['ed_izmerenia']; ?></span>
                                                            </div>
                                                        </div>

                                                    <?php } else { ?>

                                                        <div class="price_vars">
                                                            <?php
                                                            if (!empty($oneProduct['_source']['prices']) && count($oneProduct['_source']['prices']) > 0) {

                                                                if (isset($oneProduct['_source']['prices']['price_not_available'])) {
                                                                    ?>

                                                                    <div class="price_var_item js-price_not_available clear">
                                                                        <span class="price flr"><?= $oneProduct['_source']['prices']['price_not_available']['value']; ?></span>
                                                                    </div>

                                                                    <?php

                                                                } else {

                                                                    if (isset($oneProduct['_source']['prices']['price_range']['value'])) {
                                                                        ?>

                                                                        <div class="price_var_item js-price_available clear">
                                                                            <span class="count fll"><?= $oneProduct['_source']['prices']['price_range']['range']; ?></span>
                                                                            <?
                                                                            $price = Currency::getPriceForCurrency(
                                                                                $oneProduct['_source']['prices']['price_range']['currency'],
                                                                                $oneProduct['_source']['prices']['price_range']['value'],
                                                                                2
                                                                            );
                                                                            ?>
                                                                            <span class="price flr"><?= $price; ?> <?= Currency::getCurrencyName(); ?>
                                                                                /<?= $oneProduct['_source']['ed_izmerenia']; ?></span>
                                                                        </div>

                                                                        <?php

                                                                    } else {

                                                                        foreach ($oneProduct['_source']['prices'] as $onePrice) {

                                                                            if (count($onePrice) > 0) {
                                                                                foreach ($onePrice as $singlePrices) {

                                                                                    $price = Currency::getPriceForCurrency(
                                                                                        $singlePrices['currency'],
                                                                                        $singlePrices['value'],
                                                                                        2
                                                                                    );
                                                                                    ?>

                                                                                    <div class="price_var_item js-price_available clear">
                                                                                        <span class="count fll"><?= $singlePrices['range']; ?></span>
                                                                                        <span class="price flr"><?= $price; ?> <?= Currency::getCurrencyName(); ?>
                                                                                            /<?= $oneProduct['_source']['ed_izmerenia']; ?></span>
                                                                                    </div>

                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </div>

                                                    <?php } ?>

                                                </div>
                                            </td>
                                            <td class="left_bordered">

                                                <div class="card_part order js-order_data"
                                                     data-product-prices="<?= urlencode(json_encode($oneProduct['_source']['prices'])); ?>"
                                                     data-product-norma_upakovki="<?= urlencode(json_encode($oneProduct['_source']['product_logic']['norma_upakovki'])); ?>"
                                                     data-product-min_zakaz="<?= urlencode(json_encode($oneProduct['_source']['product_logic']['min_zakaz'])); ?>"
                                                     data-product-partner-count="<?= urlencode(json_encode($oneProduct['_source']['quantity']['partner_stock']['count'])); ?>"
                                                     data-product-count="<?= urlencode(json_encode($oneProduct['_source']['quantity']['stock']['count'])); ?>"
                                                     data-product-marketing-price="<?= urlencode(json_encode($oneProduct['_source']['marketing']['price'])); ?>"
                                                     data-product-marketing-price-currency="<?= urlencode(json_encode($oneProduct['_source']['marketing']['currency'])); ?>"
                                                     data-product_id="<?= $oneProduct['_id']; ?>"
                                                >

                                                    <div class="order_block">
                                                        <input type="text" class="order_input js-order_count"
                                                               placeholder="Введите количество">
                                                        <div class="order_btn add js-add_to_cart">
                                                            <svg version="1.1" id="Layer_1"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                 y="0px"
                                                                 viewBox="0 0 35 35" enable-background="new 0 0 35 35"
                                                                 xml:space="preserve">
                                            <g>
                                                <path d="M28.5,0l-0.8,4H0.5l2.5,15.1h21.5l-0.7,3.5H4v1.7H25l4.8-22.7h4.7V0H28.5z M24.8,17.5H4.4L2.4,5.7h24.8L24.8,17.5z"/>
                                                <path d="M4.9,27.3c-2.1,0-3.8,1.7-3.8,3.8S2.8,35,4.9,35s3.8-1.7,3.8-3.8S7,27.3,4.9,27.3z M6.4,32.7c-0.4,0.4-1,0.6-1.5,0.6
                                                    c-1.2,0-2.2-1-2.2-2.2s1-2.2,2.2-2.2S7,30,7,31.2C7,31.7,6.8,32.3,6.4,32.7z"/>
                                                <path d="M22.9,27.3c-2.1,0-3.8,1.7-3.8,3.8s1.7,3.8,3.8,3.8s3.8-1.7,3.8-3.8S25,27.3,22.9,27.3z M22.9,33.3c-1.2,0-2.2-1-2.2-2.2
                                                    s1-2.2,2.2-2.2s2.2,1,2.2,2.2S24.1,33.3,22.9,33.3z"/>
                                            </g>
                                        </svg>
                                                        </div>

                                                    </div>

                                                    <div class="ordered_block hidden">
                                                        <div class="ordered_icon_close js-cancel-order flr"></div>
                                                        <div class="ordered_count">В запросе: <span
                                                                    class="bold"> </span></div>
                                                        <br>
                                                        <div class="ordered_price">На сумму: <span
                                                                    class="bold">0 Р.</span></div>

                                                    </div>


                                                </div>
                                                <?php /**-------------------------------------------------------------------------*/ ?>
                                            </td>
                                        </tr>
                                    </table>

                                    <?php /*\Yii::$app->pr->print_r2($oneProduct);*/ ?>
                                    <div class="product_card_more collapsed">
                                        <div class="product_tab">
                                            <ul class="product_specs_list">
                                                <?php if (isset($oneProduct['_source']['properties']['detail_text']) && count($oneProduct['_source']['properties']['detail_text']) > 0) { ?>
                                                    <li class="product_tab_item"><a href="#description">Описание</a>
                                                    </li>
                                                <?php } ?>
                                                <?php if (!empty($oneProduct['_source']['other_properties']['property']) && count($oneProduct['_source']['other_properties']['property']) > 0) { ?>
                                                    <li class="product_tab_item"><a href="#params">Параметры</a></li>
                                                <? } ?>
                                                <? if (isset($oneProduct['_source']['properties']['teh_doc_file'])) { ?>
                                                    <li class="product_tab_item"><a href="#techdoc">Техническая
                                                            документация</a></li>
                                                <? } ?>
                                                <?php /** товары внутри вкладки принадлежности*/ ?>
                                                <?php if (isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0) { ?>
                                                    <li class="product_tab_item"><a
                                                                href="#appurtenant">Принадлежности</a></li>
                                                <?php } ?>

                                            </ul>

                                            <?php if (isset($oneProduct['_source']['properties']['detail_text'])) { ?>
                                                <div class="product_tab_content" id="description">


                                                    <?= $oneProduct['_source']['properties']['detail_text']; ?>


                                                    <div class="hide_tabs_wrap">
                                                        <div class="hide_tabs_btn">Свернуть</div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <?php if (!empty($oneProduct['_source']['other_properties']['property']) && count($oneProduct['_source']['other_properties']['property']) > 0) { ?>
                                                <div class="product_tab_content" id="params">
                                                    <table class="params_tab">


                                                        <? echo $this->render('@common/modules/catalog/views/includes/other_props.php', [
                                                            'oneProduct' => $oneProduct['_source'],
                                                        ]); ?>
                                                    </table>
                                                    <div class="hide_tabs_wrap">
                                                        <div class="hide_tabs_btn">Свернуть</div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <? if (isset($oneProduct['_source']['properties']['teh_doc_file'])) {
                                                $docs = explode(';', $oneProduct['_source']['properties']['teh_doc_file']);
                                                //\Yii::$app->pr->print_r2($docs);

                                                ?>
                                                <div class="product_tab_content" id="techdoc">

                                                    <? if (count($docs) > 0) { ?>
                                                        <ul class="docs_list">
                                                            <? foreach ($docs as $oneDoc) {
                                                                if (empty($oneDoc)) continue;
                                                                ?>
                                                                <li class="docs_item pdf">
                                                                    <a class="docs_file_link "
                                                                       href="<?= Url::to('@catDocs/' . $oneDoc); ?>"><?= $oneDoc; ?></a>
                                                                </li>
                                                            <? } ?>
                                                        </ul>
                                                    <? } ?>
                                                    <div class="hide_tabs_wrap">
                                                        <div class="hide_tabs_btn">Свернуть</div>
                                                    </div>
                                                </div>
                                            <? } ?>
                                            <?php /** товары внутри вкладки принадлежности*/ ?>
                                            <?php if (isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0) { ?>
                                                <div class="product_tab_content" id="appurtenant">


                                                    <?= $this->render('@common/modules/catalog/views/default/productInclude', ['currentSectionProducts' => $oneProduct['_source']['accessories']]); ?>


                                                    <div class="hide_tabs_wrap">
                                                        <div class="hide_tabs_btn">Свернуть</div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <!--<div class="hide_tabs_wrap">
                                            <div class="hide_tabs_btn">Свернуть</div>
                                        </div>-->
                                    </div>

                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                </div>

                <div class="articles_item_foot">

                    <table class="foot_tab_btns_wrap">
                        <tr>
                            <td class="left">
                                <?php if ($foundProducts > 0) { ?>

                                    <?php if (count($articleProducts) > 10) { ?>
                                        <span class="show_btn show_10">Отображено первые 10 строк</span>&nbsp;&nbsp;&nbsp;
                                        <span class="show_btn show_all js-show-product_card--hidden">Показать все</span>
                                    <?php } ?>


                                <? } else { ?>
                                    <span class="not_found">Не найдено ни одного совпадения</span>
                                <? } ?>

                            </td>
                            <td class="right">
                                <?php if ($foundProducts > 0) { ?>
                                <span class="show_btn foot-article_collapse-btn article_expand-btn">
                                    <span class="js-word">Свернуть</span>
                                    <span class="arrow_up"></span>
                                </span>
                                <? } ?>
                            </td>
                        </tr>
                    </table>


                </div>
            </div>
            <div class="fake_divider collapsed"></div>


        <? } ?>

    </div>

    <!-- Были загружены следующие артикулы:

    <form name="by-artikuls" method="post" action="/search/by-artikuls/">
        <input type="hidden" name="<? /*= \Yii::$app->request->csrfParam; */ ?>"
               value="<? /*= \Yii::$app->request->getCsrfToken(); */ ?>"/>
        <? /* foreach ($artiklesList as $oneArticle) { */ ?>
            <p>
                <input name="articles[]" type="text" value="<? /*= $oneArticle; */ ?>">

            </p>
        <? /* } */ ?>
        <br/>
        <br/>
        <input type="submit" value="Подтвердить">
    </form>-->

    <style>
        .container.main .content_wrap .content_inner_wrap .search_by_list {
            padding-bottom: 0;
        }
    </style>
</div>

</div>
