<?php

use yii\helpers\Url;
use common\modules\catalog\models\Section;
use common\modules\catalog\models\currency\Currency;
use yii\helpers\Html;
?>
<?
//\Yii::$app->pr->print_r2($cart);
?>

<div class="product_cards_block _order">
    <h1>Форма запроса</h1>

    <?=$this->render('@frontend/views/includes/flash.php');?>

    <div class="_order_section _selected_products">
        <h2>Выбранные наименования</h2>

        <?php if(count($cart) > 0){?>
            <?php foreach($cart as $oneProduct){
                $json = json_encode($oneProduct);
                $url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['_source']['url']).'/');
                //\Yii::$app->pr->print_r2($oneProduct);
                ?>

                <div class="product_card js-product_card js-tab_collapsed">
                    <table class="product_card_inner_wrap">
                        <tr>
                            <td>
                                <div class="card_part name">
                                    <div class="model">
                                        <a href="<?=$url;?>"><?=$oneProduct['_source']['artikul'];?></a>
                                    </div>
                                    <div class="firm_name">
                                        <a href="/manufacturer/<?=$oneProduct['_source']['properties']['proizvoditel'];?>/"><?=$oneProduct['_source']['properties']['proizvoditel'];?></a>
                                    </div>
                                    <div class="firm_descr">
                                        <?=$oneProduct['_source']['name'];?>
                                    </div>
                                    <?php if(!empty($oneProduct['_source']['other_properties']['property']) || !empty($oneProduct['_source']['properties']['teh_doc_file']) || !empty($oneProduct['_source']['properties']['detail_text']) || (isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0)){?>
                                        <div class="more js-expand-tabs">
                                            <a href="">Подробнее ↓</a>
                                        </div>
                                    <?php }?>
                                </div>
                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="card_part img">
                                    <?php if(isset($oneProduct['_source']['properties']['main_picture']) && !is_array($oneProduct['_source']['properties']['main_picture'])){ ?>
                                        <img src="<?= Url::to('@catImages/'.$oneProduct['_source']['properties']['main_picture']); ?>" alt="">
                                    <?php } ?>
                                </div>
                            </td>
                            <td class="left_bordered">
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
                                                            <div class="special_tape left_bordered"><?= $oneStorage['marketing']['name']; ?></div>
                                                            <div class="price_vars left_bordered">
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
                                                            <div class="ordered_price">На сумму: <span class="bold">0 Р.</span></div>

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
                                    <?php } else { ?>
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
                                                <div class="card_part order js-order_data" data-product-prices="null" data-product-norma_upakovki="null" data-product-min_zakaz="null" data-product-partner-count="null" data-product-count="%221%22" data-product-marketing-price="null" data-product-marketing-price-currency="null" data-product_id="152713" data-product-storage-id="my">

                                                    <div class="order_block">
                                                        <input type="text" class="order_input js-order_count" placeholder="Введите количество">
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
                                                        <div class="ordered_price">На сумму: <span class="bold">0 Р.</span></div>

                                                    </div>


                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>


                        </tr>
                    </table>

                    <?php /*\Yii::$app->pr->print_r2($oneProduct);*/?>
                    <div class="product_card_more collapsed">
                        <div class="product_tab">
                            <ul class="product_specs_list">
                                <?php if(isset($oneProduct['_source']['properties']['detail_text']) && count($oneProduct['_source']['properties']['detail_text']) > 0){ ?>
                                    <li class="product_tab_item"><a href="#description">Описание</a></li>
                                <?php }?>
                                <?php if(!empty($oneProduct['_source']['other_properties']['property']) && count($oneProduct['_source']['other_properties']['property']) > 0){ ?>
                                    <li class="product_tab_item"><a href="#params">Параметры</a></li>
                                <?}?>
                                <?if( isset($oneProduct['_source']['properties']['teh_doc_file']) ){?>
                                    <li class="product_tab_item"><a href="#techdoc">Техническая документация</a></li>
                                <?}?>


                            </ul>

                            <?php if(isset($oneProduct['_source']['properties']['detail_text'])) { ?>
                                <div class="product_tab_content" id="description">


                                    <?=$oneProduct['_source']['properties']['detail_text'];?>


                                    <div class="hide_tabs_wrap">
                                        <div class="hide_tabs_btn">Свернуть</div>
                                    </div>
                                </div>
                            <?php }?>

                            <?php if(!empty($oneProduct['_source']['other_properties']['property']) && count($oneProduct['_source']['other_properties']['property']) > 0){ ?>
                                <div class="product_tab_content" id="params">
                                    <table class="params_tab">

                                        <? echo $this->render('@common/modules/catalog/views/includes/other_props.php', [
                                            'oneProduct' => $oneProduct['_source'],
                                        ]);?>

                                    </table>
                                    <div class="hide_tabs_wrap">
                                        <div class="hide_tabs_btn">Свернуть</div>
                                    </div>
                                </div>
                            <?php }?>
                            <?if( isset($oneProduct['_source']['properties']['teh_doc_file']) ){
                                $docs = explode(';', $oneProduct['_source']['properties']['teh_doc_file']);
                                //\Yii::$app->pr->print_r2($docs);

                                ?>
                                <div class="product_tab_content" id="techdoc">

                                    <?if(count($docs) > 0){?>
                                        <ul class="docs_list">
                                            <?foreach($docs as $oneDoc){
                                                if(empty($oneDoc)) continue;
                                                ?>
                                                <li class="docs_item pdf">
                                                    <a class="docs_file_link " href="<?=Url::to('@catDocs/'.$oneDoc);?>"><?=$oneDoc;?></a>
                                                </li>
                                            <?}?>
                                        </ul>
                                    <?}?>
                                    <div class="hide_tabs_wrap">
                                        <div class="hide_tabs_btn">Свернуть</div>
                                    </div>
                                </div>
                            <?}?>

                        </div>
                        <!--<div class="hide_tabs_wrap">
                            <div class="hide_tabs_btn">Свернуть</div>
                        </div>-->
                    </div>

                </div>
            <?php }?>
        <?php }?>

    </div>

    <div class="_order_section _summary">
        Итого по выбранным наименованиям: <span class="sum_amount bold">000,00 руб</span>
    </div>

    <form action="/order/send/" method="post" name="Order" id="order_request_form" class="order_request_form">

        <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []); ?>

        <div class="_order_section _order_answer_vars">
            <h2>Варианты ответа на запрос</h2>

            <div class="form_part_wrap">
                <input type="radio" id="var1" name="Order[answer_var]" class="radio_btn js-order-type org_required" checked="checked" value="1">
                <label for="var1">Коммерческое предложение</label>

                <input type="radio" id="var2" name="Order[answer_var]" class="radio_btn js-order-type org_required" value="2">
                <label for="var2">Счет на оплату (потребуются данные организации)</label>
            </div>

        </div>

        <div class="_order_section _contact_info">
            <h2>Контактная информация</h2>

            <div class="form_part_wrap">
                <div class="row clear">
                    <div class="col col_3">
                        <label class="text_label" for="fio">ФИО:</label>
                        <input type="text" id="fio" name="Order[fio]" class="_order_inp" data-validation="required" value="<?=$cartFields->fio;?>">
                    </div>

                    <div class="col col_3">
                        <label class="text_label" for="tel">Телефон:</label>
                        <input type="text" id="tel" name="Order[tel]" class="_order_inp" value="<?=$cartFields->tel;?>">
                    </div>

                    <div class="col col_3">
                        <label class="text_label" for="email">E-mail:</label>
                        <input type="text" id="email" name="Order[email]" class="_order_inp" data-validation="email" value="<?=$cartFields->email;?>">
                    </div>

                </div>

                <div class="row">
                    <div class="col col_1">
                        <label class="text_label" for="org">Организация или ИП:</label>
                        <input type="text" id="org" name="Order[org]" data-validation="required" class="_order_inp">
                        <div class="org_tooltip"><span class="org_tooltip_arrow"></span>Введите название, ИНН или адрес</div>
                    </div>
                    <div class="selected_org"></div>
                </div>
            </div>
        </div>

        <div class="_order_section _delivery_terms">
            <h2>Требуемые условия поставки</h2>

            <div class="form_part_wrap">
                <input type="radio" id="delivery_var1" name="Order[delivery_var]" class="radio_btn js-delivery-radio js-delivery-self_dispatch" value="1" checked="checked">
                <label for="delivery_var1">Самовывоз с пункта выдачи заказов (бесплатная услуга)
                    <span class="address">Адрес:
                    <a href=""><span class="addres_icon"></span> ул. Пушкина 24, дом 254, офис 25</a>
                </span>
                </label>

                <input type="radio" id="delivery_var2" name="Order[delivery_var]" class="radio_btn js-delivery-radio js-delivery-half" value="2">
                <label for="delivery_var2">Доставка транспортной компанией до терминала в ближайшем городе покупателя (платная услуга, дополнительно оплачивается покупателем заказа)
                    <a href="">Тарифы</a>
                </label>

                <input type="radio" id="delivery_var3" name="Order[delivery_var]" class="radio_btn js-delivery-radio js-delivery-full" value="3">
                <label for="delivery_var3">Доставка транспортной компанией до «двери» покупателя (платная услуга, дополнительно оплачивается получателем заказа)
                    <a href="">Тарифы</a>
                </label>
            </div>


            <div class="form_part_wrap">
                <div class="address_subheader hidden">
                    Адрес грузополучателя:
                </div>

                <div class="row clear js-delivery-input js-delivery-half hidden">
                    <div class="col col_3">
                        <label class="text_label" for="delivery_city">Выбрать город</label>
                        <select class="_order_sel js-city-select" name="fake[delivery_city]" id="delivery_city">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col col_3">
                        <label class="text_label" for="delivery_contact_person">Контактное лицо:</label>
                        <input type="text" id="delivery_contact_person" name="Order[delivery_contact_person]" class="_order_inp" value="<?=$cartFields->delivery_contact_person;?>">
                    </div>
                    <div class="col col_3">
                        <label class="text_label" for="delivery_tel">Телефон для связи:</label>
                        <input type="text" id="delivery_tel" name="Order[delivery_tel]" class="_order_inp" value="<?=$cartFields->delivery_tel;?>">
                    </div>
                </div>

                <div class="row js-delivery-input js-delivery-full hidden">
                    <div class="col col_1">
                        <label class="text_label" for="delivery_address">Точный адрес для доставки «до двери»:</label>
                        <input type="text" id="delivery_address" name="Order[delivery_address]" class="_order_inp">
                    </div>
                </div>
            </div>
            <div class="delivery_time_text"></div>
        </div>



        <div class="_order_section _comment">
            <h2>Примечание к запросу</h2>
            <label class="text_label" for="order_comment">Текст примечания:</label>
            <textarea name="Order[order_comment]" class="order_comment" id="order_comment" cols="30" rows="10"><?=$cartFields->order_comment;?></textarea>
        </div>

        <div class="_order_submit_wrap">
            <input class="order_submit_btn" type="submit" value="Отправить запрос">
        </div>

        <input type="hidden" name="Order[source]" value="rusel24.ru">
        <input type="hidden" name="Order[date]" value="">
        <input type="hidden" name="Order[time]" value="">
        <input type="hidden" name="Order[client_id]" value="">
        <input type="hidden" name="Order[client_ip]" value="">
        <input type="hidden" name="Order[client_geolocation]" value="">
        <input type="hidden" name="Order[client_shortname]" value="">
        <input type="hidden" name="Order[client_fullname]" value="">
        <input type="hidden" name="Order[client_inn]" value="">
        <input type="hidden" name="Order[client_kpp]" value="">
        <input type="hidden" class="js-delivery_city_index" name="Order[delivery_city_index]" value="">
        <input type="hidden" class="js-delivery_city_name" name="Order[delivery_city]" value="">
        <input type="hidden" class="js-delivery_time" name="Order[delivery_time]" value="">
        <input type="hidden" class="js-client_address" name="Order[client_address]" value="">
        <input type="hidden" class="js-client_address" name="Order[client_city]" value="">
    </form>
</div>