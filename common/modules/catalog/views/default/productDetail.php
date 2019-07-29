<?php

use yii\helpers\Url;
use common\modules\catalog\models\currency\Currency;

//здесь выводится все по товару
//\Yii::$app->pr->print_r2($oneProduct);
//print_r($product['properties']);

$url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['url']).'/');

/** Если склад один, то приведем его к массиву, чтобы не гемороиться дальше */
/*if($oneProduct['_source']['prices']['stores'] == 1){
    $singleStorage = $oneProduct['_source']['prices']['storage'];
    unset($oneProduct['_source']['prices']['storage']);
    $oneProduct['_source']['prices']['storage'][] = $singleStorage;
}*/

$this->title = $oneProduct['artikul'].' | '.$oneProduct['properties']['proizvoditel'].' | Каталог';
?>
<?php //Yii::$app->pr->print_r2($oneProduct);?>


<div class="product_cards_block _detail">

    <div class="product-card2 js-product_card">
        <div class="product-card2__info-wrap">
            <ul class="product-card2__creds-list">
                <li class="product-card2__creds-item">
                    <div class="product-card2__creds-item_name">Артикул:</div>
                    <h1 class="product-card2__creds-item_artikul"><?= $oneProduct['artikul']; ?></h1>
                </li>
                <li class="product-card2__creds-item">
                    <div class="product-card2__creds-item_name">Производитель:</div>
                    <a class="product-card2__creds-item_manufacturer" target="_blank" href="/manufacturer/<?= $oneProduct['properties']['proizvoditel']; ?>/"><?= $oneProduct['properties']['proizvoditel']; ?></a>
                </li>
                <li class="product-card2__creds-item">
                    <div class="product-card2__creds-item_name">Наименование:</div>
                    <div class="product-card2__creds-item_product-title"><?= $oneProduct['name']; ?></div>
                </li>
                <!--@todo скрыто пока не сделана передача группы товара в шаблон smu138-->
                <!--<li class="product-card2__creds-item">
                    <div class="product-card2__creds-item_name">Группа:</div>
                    <a class="product-card2__creds-item_group" href="">какая-то группа</a>
                </li>-->
            </ul>
            <div class="product-card2__img">
                <?php if (isset($oneProduct['properties']['main_picture']) && !is_array($oneProduct['properties']['main_picture'])) { ?>
                    <img src="<?= Url::to('@catImages/' . $oneProduct['properties']['main_picture']); ?>"
                         alt="<?= $oneProduct['artikul']; ?>" title="<?= $oneProduct['artikul']; ?>">
                <?php } else { ?>
                    <img src="/img/nofoto.png"
                         alt="<?= $oneProduct['artikul']; ?>" title="<?= $oneProduct['artikul']; ?>">
                <?php }  ?>
            </div>
            <div class="product-card2__controls">
                <!--<div class="product-card2__btn">Хотите дешевле?</div>-->
                <a class="product-card2__manufact-icon" target="_blank" href="/manufacturer/<?= $oneProduct['properties']['proizvoditel']; ?>/">
                    <img src="/upload/images/logo-mnf/<?=$oneProduct['properties']['proizv_id'];?>.jpg" alt="">
                    <div class="text">Каталог продукции</div>
                </a>

                <div class="product-card2__share-block">
                    <div class="product-card2__share-block_head">Поделиться:</div>
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-bare data-services="vkontakte,facebook,twitter,whatsapp,skype,telegram"></div>
                </div>
            </div>
        </div>
        <div class="product-card2__stores-wrap">
            <table class="product-card2__stores-table">
                <thead>
                <tr>
                    <td style="width: 160px">Срок поставки</td>
                    <td style="width: 160px">Доступно</td>
                    <td style="width: 240px">Цена</td>
                    <td style="width: 290px">Примечание</td>
                    <td>Выбрать</td>
                </tr>
                </thead>
                <tbody>
                <?php if ($oneProduct['prices']['stores'] > 0 ) { ?>
                    <?php
                    $i = 0;
                    $len = count($oneProduct['prices']['storage']);
                    ?>
                <?php foreach ($oneProduct['prices']['storage'] as $oneStorage) { ?>
                        <?php
                        $i++;
                        ?>
                        <tr
                            <?php if($i > 5) {?> class="js-hidden-store" style="display: none;" <?php } ?>
                        >
                            <td>

                                <?php if (!empty($oneStorage['quantity']['stock']['description'])) { ?>
                                    <?= $oneStorage['quantity']['stock']['description']; ?>
                                <?php } else { ?>
                                    <?php if (!empty($oneStorage['quantity']['for_order']['description']) && !is_array($oneStorage['quantity']['for_order']['description'])) { ?>
                                        <?= $oneStorage['quantity']['for_order']['description']; ?>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                            <td>
                        <?php if ($oneStorage['quantity']['stock']['count'] > 0) { ?>
                            <?= $oneStorage['quantity']['stock']['count']; ?> <?= $oneProduct['ed_izmerenia']; ?>
                        <?php } else { ?>
                            под заказ
                        <?php } ?>
                            </td>
                            <td>
                                <!--prices----------------------------------------------------------------------------->
                                <!--prices----------------------------------------------------------------------------->
                                <!--prices----------------------------------------------------------------------------->
                                <div class="card_part prices">
                                    <?php if (!empty($oneStorage['marketing']['price']) && $oneStorage['marketing']['price'] > 0) { ?>
                                        <?

                                        $price = Currency::getPriceForCurrency(
                                            $oneStorage['marketing']['currency'],
                                            $oneStorage['marketing']['price'],
                                            2
                                        );
                                        ?>

                                        <div class="price_vars">
                                            <div class="price_var_item clear">
                                                <span class="count fll"></span>
                                                <span class="price_marketing flr"><?= $price; ?>
                                                    <?= Currency::getCurrencyName(); ?>
                                                    /<?= $oneProduct['ed_izmerenia']; ?></span>
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
                                                            <span class="count fll">от <?= $oneStorage['prices']['price_range']['range']; ?> <?= $oneProduct['ed_izmerenia']; ?></span>
                                                            <?
                                                            $price = Currency::getPriceForCurrency(
                                                                $oneStorage['prices']['price_range']['currency'],
                                                                $oneStorage['prices']['price_range']['value'],
                                                                2
                                                            );
                                                            ?>
                                                            <span class="price flr"><?= $price; ?> <?= Currency::getCurrencyName(); ?></span>
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
                                                                        <span class="count fll">от <?= $singlePrices['range']; ?> <?= $oneProduct['ed_izmerenia']; ?></span>
                                                                        <span class="price flr"><?= $price; ?> &#8381;</span>
                                                                    </div>

                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            } else { ?>
                                                <div class="price_var_item js-price_not_available clear">
                                                    <span class="price flr" style="position: static">Цены по запросу</span>
                                                </div>
                                            <?php }; ?>
                                        </div>

                                    <?php } ?>

                                </div>
                                <!--/prices---------------------------------------------------------------------------->
                                <!--/prices---------------------------------------------------------------------------->
                                <!--/prices---------------------------------------------------------------------------->
                            </td>
                            <td>
                                <?php if (!empty($oneStorage['marketing']['price']) && $oneStorage['marketing']['price'] > 0) { ?>

                                    <div class="special_tape"><?= $oneStorage['marketing']['name']; ?></div>

                                <?php } ?>
                                <?php if (isset($oneStorage['product_logic']['min_zakaz'])) { ?>
                                    Минимум: <span class=""><?= $oneStorage['product_logic']['min_zakaz']; ?> <?= $oneProduct['ed_izmerenia']; ?></span><br>
                                <?php } ?>
                                <?php if (isset($oneStorage['product_logic']['norma_upakovki'])) { ?>
                                    Кратность: <span class=""><?= $oneStorage['product_logic']['norma_upakovki']; ?> <?= $oneProduct['ed_izmerenia']; ?></span> <br>
                                    <?php if (isset($oneStorage['type'])) { ?>
                                        Тип упаковки:  <span class=""><?= $oneStorage['type']; ?></span><br>
                                    <?php } ?>
                                <?php } ?>



                                <?php if (isset($oneStorage['datacode'])) { ?>
                                    DC: <span class=""><?= $oneStorage['datacode']; ?></span>
                                <?php } ?>
                            </td>
                            <td class="product-card2__order-block">
                                <div class="card_part order js-order_data"
                                     data-product-prices="<?= urlencode(json_encode($oneStorage['prices'])); ?>"
                                     data-product-norma_upakovki="<?= urlencode(json_encode($oneStorage['product_logic']['norma_upakovki'])); ?>"
                                     data-product-min_zakaz="<?= urlencode(json_encode($oneStorage['product_logic']['min_zakaz'])); ?>"
                                     data-product-partner-count="<?= urlencode(json_encode($oneStorage['quantity']['partner_stock']['count'])); ?>"
                                     data-product-count="<?= urlencode(json_encode($oneStorage['quantity']['stock']['count'])); ?>"
                                     data-product-marketing-price="<?= urlencode(json_encode($oneStorage['marketing']['price'])); ?>"
                                     data-product-marketing-price-currency="<?= urlencode(json_encode($oneStorage['marketing']['currency'])); ?>"
                                     data-product_id="<?= $oneProduct['id']; ?>"
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
                                        <div class="ordered_count">В корзине: <span class="bold"> </span></div>
                                        <br>
                                        <div class="ordered_price">Сумма: <span class="bold">0 Р.</span></div>

                                    </div>


                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td></td>
                        <td>Под заказ</td>
                        <td>По запросу</td>
                        <td></td>
                        <td class="product-card2__order-block">
                            <div class="card_part order js-order_data"
                                 data-product-prices="<?= urlencode(json_encode($oneStorage['prices'])); ?>"
                                 data-product-norma_upakovki="<?= urlencode(json_encode($oneStorage['product_logic']['norma_upakovki'])); ?>"
                                 data-product-min_zakaz="<?= urlencode(json_encode($oneStorage['product_logic']['min_zakaz'])); ?>"
                                 data-product-partner-count="<?= urlencode(json_encode($oneStorage['quantity']['partner_stock']['count'])); ?>"
                                 data-product-count="<?= urlencode(json_encode($oneStorage['quantity']['stock']['count'])); ?>"
                                 data-product-marketing-price="<?= urlencode(json_encode($oneStorage['marketing']['price'])); ?>"
                                 data-product-marketing-price-currency="<?= urlencode(json_encode($oneStorage['marketing']['currency'])); ?>"
                                 data-product_id="<?= $oneProduct['id']; ?>"
                                 data-product-storage-id="null"
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
                                    <div class="ordered_count">В корзине: <span class="bold"> </span></div>
                                    <br>
                                    <div class="ordered_price">Сумма: <span class="bold">0 Р.</span></div>

                                </div>


                            </div>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
            <?php if($len > 5) {?>
                <div class="show-more-stores__block js-show-more-stores_block">
                    <span class="show-more-stores__btn js-show-more-stores_btn">Показать еще</span>
                </div>
            <?php } ?>
        </div>
    </div>




    <?php if(isset($oneProduct['properties']['detail_text'])) { ?>
        <div class="_detail_section description">
            <h2>Описание</h2>

            <?=$oneProduct['properties']['detail_text'];?>

        </div>
    <?php }?>

    <?php if (!empty($oneProduct['other_properties']['property']) && count($oneProduct['other_properties']['property']) > 0) { ?>
        <div class="_detail_section product_params">
            <h2>Параметры</h2>
            <table class="params_tab">

                <? echo $this->render('@common/modules/catalog/views/includes/other_props.php', [
                    'oneProduct' => $oneProduct,
                ]);?>

            </table>
        </div>
    <?php } ?>

    <? if (isset($oneProduct['properties']['teh_doc_file'])) {
        $docs = explode(';', $oneProduct['properties']['teh_doc_file']);
        //\Yii::$app->pr->print_r2($docs);

        ?>
        <div class="_detail_section tech_docs">
            <h2>Техническая документация</h2>
            <? if (count($docs) > 0) { ?>
                <ul class="docs_list">
                    <? foreach ($docs as $oneDoc) {
                        if (empty($oneDoc)) continue;
                        ?>
                        <li class="docs_item pdf">
                            <a class="docs_file_link " target="_blank" rel="nofollow" href="<?= $oneDoc; ?>"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                   viewBox="0 0 174.7 212.3" style="enable-background:new 0 0 174.7 212.3;" xml:space="preserve">
<g>
    <path class="st0" fill="#336699"  d="M101.2,171.1l-2.2,5.6h5.5l-2.1-5.6c-0.2-0.4-0.4-1-0.6-1.8C101.7,169.9,101.5,170.5,101.2,171.1z"/>
    <path class="st0" fill="#336699" d="M129.2,176.1c-0.7-0.5-1.8-0.8-3.3-0.8h-3v6.7h3.2c1.4,0,2.4-0.3,3.1-0.8c0.7-0.6,1-1.4,1-2.7
		C130.3,177.5,129.9,176.6,129.2,176.1z"/>
    <path class="st0" fill="#336699" d="M73.7,171.1l-2.2,5.6h5.5l-2.1-5.6c-0.2-0.4-0.4-1-0.6-1.8C74.1,169.9,73.9,170.5,73.7,171.1z"/>
    <path class="st0" fill="#336699" d="M98.1,64.4H72.4v5h25.7c1.4,0,2.5-1.1,2.5-2.5C100.6,65.5,99.5,64.4,98.1,64.4z"/>
    <path class="st0" fill="#336699" d="M98.1,84.8H63.9c-1.4,0-2.5,1.1-2.5,2.5s1.1,2.5,2.5,2.5h34.2c1.4,0,2.5-1.1,2.5-2.5S99.5,84.8,98.1,84.8z"/>
    <polygon class="st0" fill="#336699" points="76.8,26.3 123.5,26.3 123.5,34 130.4,34 130.4,93.7 128.2,93.7 128.2,99.7 136.4,99.7 136.4,30.3
		126.6,20.3 70.8,20.3 70.8,30 76.8,30 	"/>
    <path class="st0" fill="#336699" d="M98.1,74.6H72.4v5h25.7c1.4,0,2.5-1.1,2.5-2.5S99.5,74.6,98.1,74.6z"/>
    <path class="st0" fill="#336699" d="M0.1,0v141h0v71.3h174.6V142h0.1V0H0.1z M54.3,169.2c-1.1-0.6-2.3-0.8-3.6-0.8c-1.9,0-3.5,0.6-4.6,1.9
		c-1.1,1.2-1.7,2.9-1.7,5.1c0,2.2,0.5,3.9,1.6,5.1c1.1,1.2,2.6,1.8,4.5,1.8c1.3,0,2.5-0.2,3.6-0.5v1c-1,0.4-2.3,0.5-3.8,0.5
		c-2.2,0-3.9-0.7-5.1-2.1s-1.9-3.4-1.9-5.9c0-1.6,0.3-3,0.9-4.2c0.6-1.2,1.5-2.1,2.6-2.8c1.1-0.7,2.4-1,3.9-1c1.5,0,2.9,0.3,4.1,0.8
		L54.3,169.2z M79.6,183.1l-2.1-5.5h-6.3l-2.2,5.5h-1.2h-1.5l-7.7-7.9v7.9h-1.1v-15.5h1.1v7.5l7.4-7.5h1.4l-7.5,7.5l7.7,8l6.2-15.5
		h0.7l6.1,15.5H79.6z M93.1,183.1h-1.1v-6.7c-1.8,0.7-3.5,1.1-4.9,1.1c-1.4,0-2.5-0.3-3.3-1s-1.1-1.6-1.1-2.9v-6h1.1v6
		c0,1.9,1.1,2.8,3.4,2.8c0.7,0,1.4-0.1,2-0.2c0.7-0.1,1.6-0.4,2.8-0.8v-7.8h1.1V183.1z M107.1,183.1l-2.1-5.5h-6.3l-2.2,5.5h-1.2
		l6.2-15.5h0.7l6.1,15.5H107.1z M119.6,168.6h-5v14.5h-1.1v-14.5h-5v-1h11.1V168.6z M130.1,181.9c-0.9,0.8-2.1,1.1-3.8,1.1h-4.4
		v-15.5h1.1v6.8h3.1c1.8,0,3.1,0.3,4,1c0.9,0.7,1.3,1.7,1.3,3.2C131.4,180.1,131,181.2,130.1,181.9z M172.8,140H2.1V2h170.7V140z"/>
    <path class="st0" fill="#336699" d="M98.1,105.3H63.9c-1.4,0-2.5,1.1-2.5,2.5s1.1,2.5,2.5,2.5h34.2c1.4,0,2.5-1.1,2.5-2.5S99.5,105.3,98.1,105.3z"
    />
    <polygon class="st0" fill="#336699" points="65.8,38.6 112.5,38.6 112.5,46.2 119.4,46.2 119.4,105.9 117.2,105.9 117.2,111.9 125.4,111.9
		125.4,42.6 115.6,32.6 59.8,32.6 59.8,42.2 65.8,42.2 	"/>
    <polygon class="st0" fill="#336699" points="53.8,59.3 53.8,50.7 100.5,50.7 100.5,58.4 107.5,58.4 107.5,118 53.8,118 53.8,82.9 47.8,82.9
		47.8,124 113.5,124 113.5,54.7 103.6,44.7 47.8,44.7 47.8,59.3 	"/>
    <path class="st0" fill="#336699" d="M98.1,95H63.9c-1.4,0-2.5,1.1-2.5,2.5c0,1.4,1.1,2.5,2.5,2.5h34.2c1.4,0,2.5-1.1,2.5-2.5
		C100.6,96.1,99.5,95,98.1,95z"/>
</g>
                                    <g>
                                        <path class="st1" fill="#961C28" d="M39.2,67.2h-2.9v4.6h2.8c0.8,0,1.5-0.2,1.9-0.6s0.7-1,0.7-1.7c0-0.7-0.2-1.3-0.7-1.7S40,67.2,39.2,67.2z"/>
                                        <path class="st1" fill="#961C28" d="M26.4,59.3v23.6h46V59.3H26.4z M42.2,72.1c-0.7,0.6-1.7,0.9-3.1,0.9h-2.8v4.6h-1.6V65.9h4.3c1.3,0,2.3,0.3,3,1
		c0.7,0.7,1.1,1.5,1.1,2.6C43.2,70.6,42.9,71.5,42.2,72.1z M53.7,72.1c0,1.1-0.2,2.1-0.6,2.9c-0.4,0.8-1,1.5-1.8,1.9
		s-1.7,0.7-2.8,0.7h-3.3V65.9h3.3c1,0,1.9,0.2,2.7,0.7c0.8,0.5,1.4,1.1,1.8,1.9c0.4,0.8,0.6,1.8,0.7,2.9V72.1z M63.4,67.2h-5.7v4
		h4.9v1.3h-4.9v5.2h-1.6V65.9h7.3V67.2z"/>
                                        <path class="st1" fill="#961C28" d="M48.6,67.2h-1.8v9.2h1.6c1.2,0,2.1-0.4,2.8-1.1c0.7-0.7,1-1.8,1-3.2v-0.7c0-1.3-0.3-2.4-0.9-3.1
		C50.6,67.5,49.7,67.2,48.6,67.2z"/>
                                    </g>
</svg></a>
                            <?/* <a class="docs_file_link " href="<?= Url::to('@catDocs/' . $oneDoc); ?>"><?= $oneDoc; ?></a><?*/?>
                        </li>
                    <? } ?>
                </ul>
            <? } ?>
        </div>
    <? } ?>

    <?php /** товары внутри вкладки принадлежности*/ ?>
    <?php if(isset($oneProduct['accessories']) && count($oneProduct['accessories']) > 0){ ?>
    <div class="_detail_section _appurtenants">
        <h2>Принадлежности</h2>
            <?= $this->render('@common/modules/catalog/views/default/productInclude', ['currentSectionProducts' => $oneProduct['accessories']]); ?>
    </div>
    <?php }?>
    <div class="_detail_section description">
        <h2>Информация</h2>
        <?=$seoText;?>
    </div>
</div>



