<?php

use yii\helpers\Url;

//здесь выводится все по товару
//\Yii::$app->pr->print_r2($oneProduct);
//print_r($product['properties']);

$url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['url']).'/');
?>
<?php //Yii::$app->pr->print_r2($oneProduct);?>

<div class="product_cards_block _detail">


    <div class="product_card js-tab_collapsed">
        <table class="product_card_inner_wrap">
            <tr>
                <td>
                    <div class="card_part name">
                        <div class="model">
                            <a href="<?=$url;?>"><?=$oneProduct['artikul'];?></a>
                        </div>
                        <div class="firm_name">
                            <?php /** @TODO здесь будет ссылка на фильтр по производителю !!*/?>
                            <a href=""><?=$oneProduct['properties']['proizvoditel'];?></a>
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
                        <?php if(!empty($oneProduct['marketing']['price']) && $oneProduct['marketing']['price'] > 0){ ?>

                            <div class="special_tape"><?= $oneProduct['marketing']['name']; ?></div>
                            <div class="price_vars">
                                <div class="price_var_item clear">
                                    <span class="count fll">1+<!-- - НЕТ ДАННЫХ ДЛЯ ЭТОГО ПОЛЯ В ВЫГРУЗКЕ !--></span>
                                    <span class="price flr"><?= $oneProduct['marketing']['price']; ?> р/шт</span>
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
                                                        ?>

                                                        <div class="price_var_item clear">
                                                            <span class="count fll"><?= $singlePrices['range'];?></span>
                                                            <span class="price flr"><?= $singlePrices['value'];?> р/шт</span>
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
                    <?php /** @TODO этот блок не готов- сделать как будет функционал покупок !! */?>
                    <div class="card_part order">
                        <input type="text" class="order_input" placeholder="Введите количество">

                        <div class="ordered_input hidden">
                            <span class="ordered_icon"></span>
                            <span class="ordered_count">25 000 шт</span>
                            <span class="ordered_price">252 000 Р.</span>
                        </div>

                        <div class="ordered_btn add">Добавить в запрос</div>
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

                <?php foreach ($oneProduct['other_properties']['property'] as $singleProp) { ?>
                    <tr>
                        <td class="param_name"><?= $singleProp['name']; ?></td>
                        <td class="param_value"><?= $singleProp['value']; ?></td>
                    </tr>
                <?php } ?>

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
            <?= $this->render('productInclude', ['currentSectionProducts' => $oneProduct['accessories']]); ?>
    </div>
    <?php }?>
</div>
