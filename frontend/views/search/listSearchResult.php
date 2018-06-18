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

                    <?php if (count($articleProducts) > 0) { ?>
                        <?php foreach ($articleProducts as $oneProduct) {
                            if ($foundProducts > 0) {
                            $json = json_encode($oneProduct);
                            $url = Url::to('@catalogDir/' . str_replace('|', '/', $oneProduct['_source']['url']) . '/');

                            /** Если склад один, то приведем его к массиву, чтобы не гемороиться дальше */
                            if($oneProduct['_source']['prices']['stores'] == 1){
                                $singleStorage = $oneProduct['_source']['prices']['storage'];
                                unset($oneProduct['_source']['prices']['storage']);
                                $oneProduct['_source']['prices']['storage'][] = $singleStorage;
                            }
                            ?>
                            <?php //\Yii::$app->pr->print_r2($oneProduct);?>
                            <div class="product_card js-product_card js-tab_collapsed">
                                <table class="product_card_inner_wrap">
                                    <tr>
                                        <td class="product_name_td">
                                            <div class="card_part name">
                                                <div class="model">
                                                    <a target="_blank" href="<?= $url; ?>"><?= $oneProduct['_source']['artikul']; ?></a>
                                                </div>
                                                <div class="firm_name">
                                                    <a target="_blank" href="/manufacturer/<?= $oneProduct['_source']['properties']['proizvoditel']; ?>/"><?= $oneProduct['_source']['properties']['proizvoditel']; ?></a>
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
                                        <td class="product_name_td">
                                            <div class="card_part img">
                                                <?php if (isset($oneProduct['_source']['properties']['main_picture']) && !is_array($oneProduct['_source']['properties']['main_picture'])) { ?>
                                                    <img src="<?= Url::to('@catImages/' . $oneProduct['_source']['properties']['main_picture']); ?>"
                                                         alt="">
                                                <?php } ?>
                                            </div>
                                        </td>

                                        <td>
                                            <table class="card_part stores">
                                                <!-- --><?php
                                                /*                                    //флаг- есть ли хоть 1 товар в доступных ?
                                                                                    $isAnyAvailable = false;
                                                                                    $isAnyAvailablePartner = false; */ ?>


                                                <?php if ($oneProduct['_source']['prices']['stores'] > 0) { ?>
                                                    <?php
                                                    $i = 0;
                                                    $len = count($oneProduct['_source']['prices']['storage']);
                                                    ?>
                                                    <?php foreach ($oneProduct['_source']['prices']['storage'] as $oneStorage) { ?>
                                                        <tr>
                                                            <td class="stores_amount left_bordered">
                                                                <table class="in_stock">
                                                                    <?php /*if (empty($oneStorage['quantity']['stock']['count'])) {
		                                                    \Yii::$app->pr->print_r2($oneProduct);
		                                                    die();
	                                                    }*/?>
                                                                    <?php if (!empty($oneStorage['quantity']['stock']['count']) && $oneStorage['quantity']['stock']['count'] > 0) { ?>
                                                                        <tr>
                                                                            <!--<td class="square_mark"><span></span></td>-->
                                                                            <td class="instock_def first_def">Доступно:</td>
                                                                            <td class="instock_count">
                                                                                <?= $oneStorage['quantity']['stock']['count']; ?> <?= $oneProduct['_source']['ed_izmerenia']; ?>

                                                                                <?php if (!empty($oneStorage['quantity']['stock']['description'])) { ?>
                                                                                    <span class="count_tooltip_trigger"><?= $oneStorage['quantity']['stock']['description']; ?>
                                                                                        <span class="count_tooltip">Срок отгрузки со склада РУСЭЛ.24 после оплаты счета <span
                                                                                                    class="corner"></span></span></span>

                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>

                                                                    <?php } else { ?>

                                                                        <tr>
                                                                            <td class="instock_def">Доступно:</td>
                                                                            <td class="instock_count">
                                                                                0 <?= $oneProduct['_source']['ed_izmerenia']; ?></td>
                                                                        </tr>

                                                                    <?php } ?>

                                                                    <?php if (isset($oneStorage['datacode'])) { ?>
                                                                        <tr>
                                                                            <td class="instock_def">DC:</td>
                                                                            <td class="instock_count">
                                                                                <?= $oneStorage['datacode']; ?></td>
                                                                        </tr>
                                                                    <?php } ?>

                                                                    <?php if (isset($oneStorage['quantity']['for_order']['description'])) {

                                                                        if (!is_array($oneProduct['_source']['quantity']['for_order']['description'])) {
                                                                            $overText = 'Доп. заказ:';
                                                                            if ($oneStorage['quantity']['stock']['count'] == 0) {
                                                                                $overText = 'Под заказ:';
                                                                            } ?>
                                                                            <tr>
                                                                                <td class="instock_def"><?= $overText; ?></td>
                                                                                <td class="instock_count">
                                                                                    <?php if (!empty($oneStorage['quantity']['for_order']['description']) && !is_array($oneStorage['quantity']['for_order']['description'])) { ?>
                                                                                        <?= $oneStorage['quantity']['for_order']['description']; ?>
                                                                                    <?php } ?>
                                                                                </td>
                                                                            </tr>

                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                    <tr>
                                                                        <td><br></td>
                                                                        <td><br></td>
                                                                    </tr>
                                                                    <?php if (isset($oneStorage['product_logic']['norma_upakovki'])) { ?>
                                                                        <tr>
                                                                            <td class="instock_def">Упаковка:</td>
                                                                            <td class="instock_count">
                                                                                <?= $oneStorage['product_logic']['norma_upakovki']; ?> <?= $oneProduct['_source']['ed_izmerenia']; ?>
                                                                                <?php if (isset($oneStorage['type'])) { ?>
                                                                                    (<?= $oneStorage['type']; ?>)
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } else { ?>
                                                                        <tr>
                                                                            <td class="instock_def"></td>
                                                                            <td class="instock_count">
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>

                                                                    <tr>
                                                                        <td class="instock_def">Мин. партия:</td>
                                                                        <td class="instock_count">
                                                                            <?php if (isset($oneStorage['product_logic']['min_zakaz'])) { ?>
                                                                                <?= $oneStorage['product_logic']['min_zakaz']; ?> <?= $oneProduct['_source']['ed_izmerenia']; ?>
                                                                            <?php } else { ?>
                                                                                по запросу
                                                                            <?php } ?>

                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>





                                                            <td class="stores_prices left_bordered">
                                                                <div class="card_part prices">
                                                                    <?php if (!empty($oneStorage['marketing']['price']) && $oneStorage['marketing']['price'] > 0) { ?>
                                                                        <?
                                                                        //\Yii::$app->pr->print_r2($oneProduct['_source']['marketing']);
                                                                        $price = Currency::getPriceForCurrency(
                                                                            $oneStorage['marketing']['currency'],
                                                                            $oneStorage['marketing']['price'],
                                                                            2
                                                                        );
                                                                        ?>
                                                                        <div class="special_tape"><?= $oneStorage['marketing']['name']; ?></div>
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
                                                                            if (!empty($oneStorage['prices']) && count($oneStorage['prices']) > 0) {

                                                                                if (isset($oneStorage['prices']['price_not_available'])) {
                                                                                    ?>

                                                                                    <div class="price_var_item js-price_not_available clear">
                                                                                        <span class="price flr"><?= $oneStorage['price_not_available']['value']; ?></span>
                                                                                    </div>

                                                                                    <?php

                                                                                } else {

                                                                                    if (isset($oneStorage['prices']['price_range']['value'])) {
                                                                                        ?>

                                                                                        <div class="price_var_item js-price_available clear">
                                                                                            <span class="count fll"><?= $oneStorage['prices']['price_range']['range']; ?></span>
                                                                                            <?
                                                                                            $price = Currency::getPriceForCurrency(
                                                                                                $oneStorage['prices']['price_range']['currency'],
                                                                                                $oneStorage['prices']['price_range']['value'],
                                                                                                2
                                                                                            );
                                                                                            ?>
                                                                                            <span class="price flr"><?= $price; ?> <?= Currency::getCurrencyName(); ?>
                                                                                                /<?= $oneProduct['_source']['ed_izmerenia']; ?></span>
                                                                                        </div>

                                                                                        <?php

                                                                                    } else {

                                                                                        foreach ($oneStorage['prices'] as $onePrice) {

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
                                                                            } else { ?>
                                                                                <div class="price_var_item js-price_not_available clear">
                                                                                    <span class="price flr">Цены по запросу</span>
                                                                                </div>
                                                                            <?php }; ?>
                                                                        </div>

                                                                    <?php } ?>

                                                                </div>
                                                            </td>



                                                            <td class="stores_order left_bordered">
                                                                <div class="card_part order js-order_data"
                                                                     data-product-prices="<?= urlencode(json_encode($oneStorage['prices'])); ?>"
                                                                     data-product-norma_upakovki="<?= urlencode(json_encode($oneStorage['product_logic']['norma_upakovki'])); ?>"
                                                                     data-product-min_zakaz="<?= urlencode(json_encode($oneStorage['product_logic']['min_zakaz'])); ?>"
                                                                     data-product-partner-count="<?= urlencode(json_encode($oneStorage['quantity']['partner_stock']['count'])); ?>"
                                                                     data-product-count="<?= urlencode(json_encode($oneStorage['quantity']['stock']['count'])); ?>"
                                                                     data-product-marketing-price="<?= urlencode(json_encode($oneStorage['marketing']['price'])); ?>"
                                                                     data-product-marketing-price-currency="<?= urlencode(json_encode($oneStorage['marketing']['currency'])); ?>"
                                                                     data-product_id="<?= $oneProduct['_id']; ?>"
                                                                     data-product-storage-id="<?= $oneStorage['id']; ?>"
                                                                >

                                                                    <div class="order_block">
                                                                        <input type="text" class="order_input js-order_count"
                                                                               placeholder="Введите количество">
                                                                        <div class="order_btn add js-add_to_cart">
                                                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
                                                                        <div class="ordered_count">В запросе: <span class="bold"> </span></div>
                                                                        <br>
                                                                        <div class="ordered_price">Сумма: <span class="bold">по запросу</span></div>

                                                                    </div>


                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php if($i != $len - 1){?>
                                                            <tr class="store_row">
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <?php $i++; ?>
                                                    <?php } ?>
                                                <?php } else {
	                                                $oneStorage = false;
                                                    ?>
                                                    <tr>
                                                        <td class="stores_amount left_bordered">
                                                            <table class="in_stock">
                                                                <tbody><tr>
                                                                    <!--<td class="square_mark"><span></span></td>-->
                                                                    <td class="instock_def first_def">Доступно:</td>
                                                                    <td class="instock_count">
                                                                        0 шт


                                                                    </td>
                                                                </tr>



                                                                <tr>
                                                                    <td><br></td>
                                                                    <td><br></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="instock_def"></td>
                                                                    <td class="instock_count">
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="instock_def">Мин. партия:</td>
                                                                    <td class="instock_count">
                                                                        по запросу

                                                                    </td>
                                                                </tr>
                                                                </tbody></table>
                                                        </td>





                                                        <td class="stores_prices left_bordered">
                                                            <div class="card_part prices">

                                                                <div class="price_vars">
                                                                    <div class="price_var_item js-price_not_available clear">
                                                                        <span class="price flr">Цены по запросу</span>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </td>



                                                        <td class="stores_order left_bordered">
                                                            <div class="card_part order js-order_data"
                                                                 data-product-prices="<?= urlencode(json_encode($oneStorage['prices'])); ?>"
                                                                 data-product-norma_upakovki="<?= urlencode(json_encode($oneStorage['product_logic']['norma_upakovki'])); ?>"
                                                                 data-product-min_zakaz="<?= urlencode(json_encode($oneStorage['product_logic']['min_zakaz'])); ?>"
                                                                 data-product-partner-count="<?= urlencode(json_encode($oneStorage['quantity']['partner_stock']['count'])); ?>"
                                                                 data-product-count="<?= urlencode(json_encode($oneStorage['quantity']['stock']['count'])); ?>"
                                                                 data-product-marketing-price="<?= urlencode(json_encode($oneStorage['marketing']['price'])); ?>"
                                                                 data-product-marketing-price-currency="<?= urlencode(json_encode($oneStorage['marketing']['currency'])); ?>"
                                                                 data-product_id="<?= $oneProduct['_id']; ?>"
                                                                 data-product-storage-id="null"
                                                            >

                                                                <div class="order_block">
                                                                    <input type="text" class="order_input js-order_count" placeholder="Введите количество ">
                                                                    <div class="order_btn add js-add_to_cart">
                                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 35 35" enable-background="new 0 0 35 35" xml:space="preserve">
                                            <g>
                                                <path d="M28.5,0l-0.8,4H0.5l2.5,15.1h21.5l-0.7,3.5H4v1.7H25l4.8-22.7h4.7V0H28.5z M24.8,17.5H4.4L2.4,5.7h24.8L24.8,17.5z"></path>
                                                <path d="M4.9,27.3c-2.1,0-3.8,1.7-3.8,3.8S2.8,35,4.9,35s3.8-1.7,3.8-3.8S7,27.3,4.9,27.3z M6.4,32.7c-0.4,0.4-1,0.6-1.5,0.6
                                                    c-1.2,0-2.2-1-2.2-2.2s1-2.2,2.2-2.2S7,30,7,31.2C7,31.7,6.8,32.3,6.4,32.7z"></path>
                                                <path d="M22.9,27.3c-2.1,0-3.8,1.7-3.8,3.8s1.7,3.8,3.8,3.8s3.8-1.7,3.8-3.8S25,27.3,22.9,27.3z M22.9,33.3c-1.2,0-2.2-1-2.2-2.2
                                                    s1-2.2,2.2-2.2s2.2,1,2.2,2.2S24.1,33.3,22.9,33.3z"></path>
                                            </g>
                                        </svg>
                                                                    </div>

                                                                </div>

                                                                <div class="ordered_block hidden">
                                                                    <div class="ordered_icon_close js-cancel-order flr"></div>
                                                                    <div class="ordered_count">В запросе: <span class="bold"> </span></div>
                                                                    <br>
                                                                    <div class="ordered_price">Сумма: <span class="bold">по запросу</span></div>

                                                                </div>


                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>

                                <?php /*\Yii::$app->pr->print_r2($oneProduct);*/ ?>
                                <div class="product_card_more collapsed">
                                    <div class="product_tab">
                                        <ul class="product_specs_list">
                                            <?php if (isset($oneProduct['_source']['properties']['detail_text']) && count($oneProduct['_source']['properties']['detail_text']) > 0) { ?>
                                                <li class="product_tab_item"><a href="#description">Описание</a></li>
                                            <?php } ?>
                                            <?php if (!empty($oneProduct['_source']['other_properties']['property']) && count($oneProduct['_source']['other_properties']['property']) > 0) { ?>
                                                <li class="product_tab_item"><a href="#params">Параметры</a></li>
                                            <? } ?>
                                            <? if (isset($oneProduct['_source']['properties']['teh_doc_file'])) { ?>
                                                <li class="product_tab_item"><a href="#techdoc">Техническая документация</a></li>
                                            <? } ?>
                                            <?php /** товары внутри вкладки принадлежности*/ ?>
                                            <?php if (isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0) { ?>
                                                <li class="product_tab_item"><a href="#appurtenant">Принадлежности</a></li>
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



                    <?php /* кусок базовой верстки тут ?>
    <div class="product_card js-tab_collapsed">
        <div class="card_part name">
            <div class="model">
                <a href="">DF-0394 HJ75</a>
            </div>
            <div class="firm_name">
                <a href="">Bionic</a>
            </div>
            <div class="firm_descr">
                Оборудование для плат
            </div>
            <div class="more js-expand-tabs">
                <a href="">Подробнее ↓</a>
            </div>
        </div>

        <div class="card_part img">
            <img src="<?= Url::to('@web/img/card_img.png'); ?>" alt="">
        </div>

        <div class="card_part in_stock">
            <div class="in_stock_item available">Доступно: <span class="avilable_count">123 шт (1-2 дня)</span></div>
            <div class="in_stock_item preorder">Дополнительно: <span class="preorder_count">4-5 недель</span></div>
            <br>
            <div class="in_stock_item pack">Упаковка: <span class="pack_count">50 шт/span></div>
            <div class="in_stock_item minorder">Мин.заказ: <span class="minorder_count">100 шт/span></div>
        </div>
        <div class="card_part prices">
            <div class="special_tape">Специальная цена</div>
            <div class="price_vars">
                <div class="price_var_item clear">
                    <span class="count fll">1+</span>
                    <span class="price flr">100.00 Р/шт/span>
                </div>
                <div class="price_var_item clear">
                    <span class="count fll">1+</span>
                    <span class="price flr">100.00 Р/шт/span>
                </div>
                <div class="price_var_item clear">
                    <span class="count fll">1+</span>
                    <span class="price flr">100.00 Р/шт/span>
                </div>
            </div>
        </div>
        <div class="card_part order">
            <input type="text" class="order_input" placeholder="Введите количество">

            <div class="ordered_input hidden">
                <span class="ordered_icon"></span>
                <span class="ordered_count">25 000 шт</span>
                <span class="ordered_price">252 000 Р.</span>
            </div>

            <div class="ordered_btn add">Добавить в запрос</div>
        </div>
        <div class="product_card_more collapsed">
            <div class="product_tab">
                <ul class="product_specs_list">
                    <li class="product_tab_item"><a href="#params">Параметры</a></li>
                    <li class="product_tab_item"><a href="#techdoc">Техническая документация</a></li>
                    <li class="product_tab_item"><a href="#appurtenant">Принадлежности</a></li>
                </ul>
                <div class="product_tab_content" id="params">
                    <table class="params_tab">
                        <tr>
                            <td class="param_name">Серия</td>
                            <td class="param_value">-</td>
                        </tr>
                        <tr>
                            <td class="param_name">Номинальная емкость, мкФ</td>
                            <td class="param_value">100</td>
                        </tr>
                        <tr>
                            <td class="param_name">Рабочее напряжение, В</td>
                            <td class="param_value">50</td>
                        </tr>
                        <tr>
                            <td class="param_name">Допуск номинальной емкости,%</td>
                            <td class="param_value">20</td>
                        </tr>
                        <tr>
                            <td class="param_name">Рабочая температура,С</td>
                            <td class="param_value">-40...105</td>
                        </tr>
                        <tr>
                            <td class="param_name">Тангенс угла потерь,%</td>
                            <td class="param_value">-</td>
                        </tr>
                        <tr>
                            <td class="param_name">Ток утечки макс.,мкА</td>
                            <td class="param_value">-</td>
                        </tr>
                        <tr>
                            <td class="param_name">Выводы/корпус</td>
                            <td class="param_value">string</td>
                        </tr>
                        <tr>
                            <td class="param_name">Диаметр корпуса 0,мм</td>
                            <td class="param_value">10</td>
                        </tr>
                        <tr>
                            <td class="param_name">Длина корпуса 1_,мм</td>
                            <td class="param_value">12.5</td>
                        </tr>
                        <tr>
                            <td class="param_name">Особенности</td>
                            <td class="param_value">-</td>
                        </tr>
                        <tr>
                            <td class="param_name">Производитель/td>
                            <td class="param_value">Panasonic</td>
                        </tr>
                    </table>
                </div>
                <div class="product_tab_content" id="techdoc">
                    <p>
                        какая то Техническая документация
                    </p>

                </div>
                <div class="product_tab_content" id="appurtenant">
                    <p>
                        какие то Принадлежности
                    </p>
                </div>
            </div>
            <div class="hide_tabs_wrap">
                <div class="hide_tabs_btn">Свернуть</div>
            </div>
        </div>
    </div>
    <?php */ ?>

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
