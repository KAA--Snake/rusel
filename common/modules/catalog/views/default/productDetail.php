<?php

use yii\helpers\Url;
use common\modules\catalog\models\currency\Currency;

//здесь выводится все по товару
//\Yii::$app->pr->print_r2($oneProduct);
//print_r($product['properties']);

$url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['url']).'/');
?>
<?php //Yii::$app->pr->print_r2($oneProduct);?>

<div class="product_cards_block _detail">


    <div class="product_card js-product_card js-tab_collapsed">
        <table class="product_card_inner_wrap">
            <tr>
                <td>
                    <div class="card_part name">
                        <div class="model">
                            <a href="<?=$url;?>"><?=$oneProduct['artikul'];?></a>
                        </div>
                        <div class="firm_name">
                            <a href="/manufacturer/<?=$oneProduct['_source']['properties']['proizvoditel'];?>/"><?=$oneProduct['properties']['proizvoditel'];?></a>
                        </div>
                        <div class="firm_descr">
                            <?=$oneProduct['name'];?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="card_part img">
                        <?php if(isset($oneProduct['properties']['main_picture']) && !is_array($oneProduct['properties']['main_picture'])){ ?>
                            <img src="<?= Url::to('@catImages/'.$oneProduct['properties']['main_picture']); ?>" alt="">
                        <?php } ?>
                    </div>
                </td>
                <td class="left_bordered">
                    <div class="card_part in_stock">
                        <?php
                        //флаг- есть ли хоть 1 товар в доступных ?
                        $isAnyAvailable = false;
                        $isAnyAvailablePartner = false;?>

                        <table class="instock">
                            <?php if(isset($oneProduct['quantity']['stock']['count']) && $oneProduct['quantity']['stock']['count'] > 0){
                                $isAnyAvailable = true;
                                ?>
                                <tr>
                                    <td class="instock_def">Доступно:</td>
                                    <td class="instock_count">
                                        <?= $oneProduct['quantity']['stock']['count'];?> шт

                                        <?php if(!empty($oneProduct['quantity']['stock']['description'])){?>
                                            <span class="count_tooltip_trigger"><?= $oneProduct['quantity']['stock']['description'];?> <span class="count_tooltip">Срок отгрузки со склада РУСЭЛ.24 после оплаты счета <span class="corner"></span></span></span>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if(isset($oneProduct['quantity']['partner_stock']['count']) && $oneProduct['quantity']['partner_stock']['count'] > 0){
                                $isAnyAvailablePartner = true;
                                ?>
                                <tr>
                                    <td class="instock_def"> <?php if(!$isAnyAvailable) {?>Доступно:<?php }?></td>
                                    <td class="instock_count partner">
                                        <?= $oneProduct['quantity']['partner_stock']['count'];?> шт

                                        <?php if(!empty($oneProduct['quantity']['partner_stock']['description']) && !is_array($oneProduct['quantity']['partner_stock']['description'])){?>
                                            <span class="count_tooltip_trigger"><?= $oneProduct['quantity']['partner_stock']['description'];?><span class="count_tooltip">Срок отгрузки со склада РУСЭЛ.24 после оплаты счета <span class="corner"></span></span></span>
                                        <?php }?>
                                    </td>
                                </tr>

                            <?php } ?>

                            <?php if(!$isAnyAvailable && !$isAnyAvailablePartner) {?>
                                <tr>
                                    <td class="instock_def">Доступно:</td>
                                    <td class="instock_count">0 шт</td>
                                </tr>
                            <?php }?>

                            <?php if( isset($oneProduct['quantity']['for_order']['description']) ){

                                if(!is_array($oneProduct['quantity']['for_order']['description'])){
                                    $overText = 'Доп. заказ:';
                                    if(!$isAnyAvailable && !$isAnyAvailablePartner) {
                                        $overText = 'Под заказ:';
                                    }?>
                                    <tr>
                                        <td class="instock_def"><?= $overText;?></td>
                                        <td class="instock_count">
                                            <?php if(!empty($oneProduct['quantity']['for_order']['description']) && !is_array($oneProduct['quantity']['for_order']['description'])){?>
                                                <?= $oneProduct['quantity']['for_order']['description'];?>
                                            <?php }?>
                                        </td>
                                    </tr>

                                <?php } ?>
                            <?php } ?>
                            <tr>
                                <td><br></td>
                                <td><br></td>
                            </tr>

                            <tr>
                                <td class="instock_def">Упаковка: </td>
                                <td class="instock_count"><?= $oneProduct['product_logic']['norma_upakovki'];?> шт</td>
                            </tr>

                            <tr>
                                <td class="instock_def">Мин. партия: </td>
                                <td class="instock_count"><?= $oneProduct['product_logic']['min_zakaz'];?> шт</td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td class="left_bordered">
                    <div class="card_part prices">
                        <?php if(!empty($oneProduct['marketing']['price']) && $oneProduct['marketing']['price'] > 0){
                            $price = Currency::getPriceForCurrency(
                                $oneProduct['marketing']['currency'],
                                $oneProduct['marketing']['price'],
                                2
                            );
                            ?>

                            <div class="special_tape"><?= $oneProduct['marketing']['name']; ?></div>
                            <div class="price_vars">
                                <div class="price_var_item clear">
                                    <span class="count fll"></span>
                                    <span class="price flr"><?= $price ?> р/шт</span>
                                </div>
                            </div>

                        <?php }else{ ?>

                            <div class="price_vars">
                                <?php
                                if(!empty($oneProduct['prices']) && count($oneProduct['prices']) > 0){

                                    if(isset($oneProduct['prices']['price_not_available'])){
                                        ?>

                                        <div class="price_var_item clear">
                                            <span class="price flr"><?= $oneProduct['prices']['price_not_available']['value'];?></span>
                                        </div>

                                        <?php

                                    }else{

                                        if(isset($oneProduct['prices']['price_range']['value'])){
                                            ?>

                                            <div class="price_var_item clear">
                                                <span class="count fll"><?= $oneProduct['prices']['price_range']['range'];?></span>
                                                <span class="price flr"><?= $oneProduct['prices']['price_range']['value'];?> Р/шт</span>
                                            </div>

                                            <?php

                                        }else{

                                            foreach($oneProduct['prices'] as $onePrice){

                                                if(count($onePrice) > 0){
                                                    foreach($onePrice as $singlePrices){

                                                        $price = Currency::getPriceForCurrency(
                                                            $singlePrices['currency'],
                                                            $singlePrices['value'],
                                                            2
                                                        );

                                                        ?>

                                                        <div class="price_var_item clear">
                                                            <span class="count fll"><?= $singlePrices['range'];?></span>
                                                            <span class="price flr"><?= $price;?> р/шт</span>
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
                         data-product-prices="<?=urlencode(json_encode($oneProduct['prices']));?>"
                         data-product-norma_upakovki="<?=urlencode(json_encode($oneProduct['product_logic']['norma_upakovki']));?>"
                         data-product-min_zakaz="<?=urlencode(json_encode($oneProduct['product_logic']['min_zakaz']));?>"
                         data-product-partner-count="<?=urlencode(json_encode($oneProduct['quantity']['partner_stock']['count']));?>"
                         data-product-count="<?=urlencode(json_encode($oneProduct['quantity']['stock']['count']));?>"
                         data-product-marketing-price="<?=urlencode(json_encode($oneProduct['marketing']['price']));?>"
                         data-product-marketing-price-currency="<?=urlencode(json_encode($oneProduct['marketing']['currency']));?>"
                         data-product_id="<?=$oneProduct['id'];?>"
                    >

                        <div class="order_block">
                            <input type="text" class="order_input js-order_count" placeholder="Введите количество">
                            <div class="order_btn add js-add_to_cart">
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

                        </div>

                        <div class="ordered_block hidden">
                            <div class="ordered_icon_close js-cancel-order flr"></div>
                            <div class="ordered_count">В запросе: <span class="bold"> </span></div>
                            <br>
                            <div class="ordered_price">На сумму: <span class="bold">0 Р.</span></div>

                        </div>


                    </div>
                    <?php /**-------------------------------------------------------------------------*/?>
                </td>
            </tr>
        </table>
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
                            <a class="docs_file_link " href="<?= Url::to('@catDocs/' . $oneDoc); ?>"><?= $oneDoc; ?></a>
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
</div>
