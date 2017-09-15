<?php

/** $currentSectionProducts в данном контексте - это список связанных товаров*/


//\Yii::$app->pr->print_r2($currentSectionProducts);
//die();
use yii\helpers\Url;
use common\modules\catalog\models\currency\Currency;

?>

<?php if(count($currentSectionProducts) > 0){ ?>

    <?php foreach($currentSectionProducts as $oneProduct){
    $url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['_source']['url']).'/');
    ?>
        <div class="product_card product_card_inner js-tab_collapsed">
            <table class="product_card_inner_wrap">
                <tr>
                    <td>
                        <div class="card_part name">
                            <div class="model">
                                <a href="<?=$url;?>"><?=$oneProduct['_source']['artikul'];?></a>
                            </div>
                            <div class="firm_name">
                                <?php /** @TODO здесь будет ссылка на фильтр по производителю !!*/?>
                                <a href=""><?=$oneProduct['_source']['properties']['proizvoditel'];?></a>
                            </div>
                            <div class="firm_descr">
                                <?=$oneProduct['_source']['name'];?>
                            </div>
                            <?php if(!empty($oneProduct['_source']['other_properties']) || (isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0)){?>
                                <div class="more js-expand-tabs">
                                    <a href="">Подробнее ↓</a>
                                </div>
                            <?php }?>
                        </div>
                    </td>
                    <td>
                        <div class="card_part img">
                            <?php if(isset($oneProduct['_source']['properties']['main_picture']) && !is_array($oneProduct['_source']['properties']['main_picture'])){ ?>
                                <img src="<?= Url::to('@catImages/'.$oneProduct['_source']['properties']['main_picture']); ?>" alt="">
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
                                <?php if(isset($oneProduct['_source']['quantity']['stock']['count']) && $oneProduct['_source']['quantity']['stock']['count'] > 0){
                                    $isAnyAvailable = true;
                                    ?>
                                    <tr>
                                        <td class="instock_def">Доступно:</td>
                                        <td class="instock_count">
                                            <?= $oneProduct['_source']['quantity']['stock']['count'];?> <?= $oneProduct['_source']['ed_izmerenia'];?>

                                            <?php if(!empty($oneProduct['_source']['quantity']['stock']['description'])){?>
                                                <span class="count_tooltip_trigger"><?= $oneProduct['_source']['quantity']['stock']['description'];?><span class="count_tooltip">Срок отгрузки со склада РУСЭЛ.24 после оплаты счета <span class="corner"></span></span></span>
                                            <?php }?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if(isset($oneProduct['_source']['quantity']['partner_stock']['count']) && $oneProduct['_source']['quantity']['partner_stock']['count'] > 0){
                                    $isAnyAvailablePartner = true;
                                    ?>
                                    <tr>
                                        <td class="instock_def"> <?php if(!$isAnyAvailable) {?>Доступно:<?php }?></td>
                                        <td class="instock_count partner">
                                            <?= $oneProduct['_source']['quantity']['partner_stock']['count'];?> <?= $oneProduct['_source']['ed_izmerenia'];?>

                                            <?php if(!empty($oneProduct['_source']['quantity']['partner_stock']['description']) && !is_array($oneProduct['_source']['quantity']['partner_stock']['description'])){?>
                                                <span class="count_tooltip_trigger"><?= $oneProduct['_source']['quantity']['partner_stock']['description'];?><span class="count_tooltip">Срок отгрузки со склада РУСЭЛ.24 после оплаты счета <span class="corner"></span></span></span>
                                            <?php }?>
                                        </td>
                                    </tr>

                                <?php } ?>

                                <?php if(!$isAnyAvailable && !$isAnyAvailablePartner) {?>
                                    <tr>
                                        <td class="instock_def">Доступно:</td>
                                        <td class="instock_count">0 <?= $oneProduct['_source']['ed_izmerenia'];?></td>
                                    </tr>
                                <?php }?>

                                <?php if( isset($oneProduct['_source']['quantity']['for_order']['description']) ){

                                    if(!is_array($oneProduct['_source']['quantity']['for_order']['description'])){
                                        $overText = 'Доп. заказ:';
                                        if(!$isAnyAvailable && !$isAnyAvailablePartner) {
                                            $overText = 'Под заказ:';
                                        }?>
                                        <tr>
                                            <td class="instock_def"><?= $overText;?></td>
                                            <td class="instock_count">
                                                <?php if(!empty($oneProduct['_source']['quantity']['for_order']['description']) && !is_array($oneProduct['_source']['quantity']['for_order']['description'])){?>
                                                    <?= $oneProduct['_source']['quantity']['for_order']['description'];?>
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
                                    <td class="instock_count"><?= $oneProduct['_source']['product_logic']['norma_upakovki'];?> <?= $oneProduct['_source']['ed_izmerenia'];?></td>
                                </tr>

                                <tr>
                                    <td class="instock_def">Мин. партия: </td>
                                    <td class="instock_count"><?= $oneProduct['_source']['product_logic']['min_zakaz'];?> <?= $oneProduct['_source']['ed_izmerenia'];?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td class="left_bordered">
                        <div class="card_part prices">
                            <?php if(!empty($oneProduct['_source']['marketing']['price']) && $oneProduct['_source']['marketing']['price'] > 0){ ?>
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
                                        <span class="count fll">1+<!-- - НЕТ ДАННЫХ ДЛЯ ЭТОГО ПОЛЯ В ВЫГРУЗКЕ !--></span>
                                        <span class="price flr"><?=$price;?>
                                            <?=Currency::getCurrencyName();?>/<?= $oneProduct['_source']['ed_izmerenia'];?>
                                        </span>
                                    </div>
                                </div>

                            <?php }else{ ?>

                                <div class="price_vars">
                                    <?php
                                    if(!empty($oneProduct['_source']['prices']) && count($oneProduct['_source']['prices']) > 0){

                                        if(isset($oneProduct['_source']['prices']['price_not_available'])){

                                            ?>

                                            <div class="price_var_item clear">
                                                <span class="price flr"><?= $oneProduct['_source']['prices']['price_not_available']['value'];?></span>
                                            </div>

                                            <?php

                                        }else{

                                            if(isset($oneProduct['_source']['prices']['price_range']['value'])){
                                                //\Yii::$app->pr->print_r2($oneProduct['_source']['prices']['price_range']);

                                                $price = Currency::getPriceForCurrency(
                                                    $oneProduct['_source']['prices']['price_range']['currency'],
                                                    $oneProduct['_source']['prices']['price_range']['value'],
                                                    2
                                                );
                                                ?>
                                                <div class="price_var_item clear">
                                                    <span class="count fll"><?= $oneProduct['_source']['prices']['price_range']['range'];?></span>
                                                    <span class="price flr"><?=$price;?> <?=Currency::getCurrencyName();?>/<?= $oneProduct['_source']['ed_izmerenia'];?></span>
                                                </div>

                                                <?php

                                            }else{

                                                foreach($oneProduct['_source']['prices'] as $onePrice){
                                                    //\Yii::$app->pr->print_r2($onePrice);
                                                    //die();
                                                    if(count($onePrice) > 0){
                                                        foreach($onePrice as $singlePrices){
                                                            $price = Currency::getPriceForCurrency(
                                                                $singlePrices['currency'],
                                                                $singlePrices['value'],
                                                                2
                                                            );
                                                            //die();
                                                            ?>

                                                            <div class="price_var_item clear">
                                                                <span class="count fll"><?= $singlePrices['range'];?></span>
                                                                <span class="price flr"><?=$price;?> <?=Currency::getCurrencyName();?>/<?= $oneProduct['_source']['ed_izmerenia'];?></span>
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

            <div class="product_card_more collapsed">
                <div class="product_tab">
                    <ul class="product_specs_list">
                        <?php if(!empty($oneProduct['_source']['other_properties']['property']) && count($oneProduct['_source']['other_properties']['property']) > 0){ ?>
                            <li class="product_tab_item"><a href="#params_inc">Параметры</a></li>
                        <?}?>
                        <?if( isset($oneProduct['_source']['properties']['teh_doc_file']) ){?>
                            <li class="product_tab_item"><a href="#techdoc_inc">Техническая документация</a></li>
                        <?}?>

                    </ul>
                    <?php if(!empty($oneProduct['_source']['other_properties']['property']) && count($oneProduct['_source']['other_properties']['property']) > 0){ ?>
                        <div class="product_tab_content" id="params_inc">
                            <table class="params_tab">

                                    <?php foreach($oneProduct['_source']['other_properties']['property'] as $singleProp){ ?>
                                        <tr>
                                            <td class="param_name"><?= $singleProp['name']; ?></td>
                                            <td class="param_value"><?= $singleProp['value']; ?></td>
                                        </tr>
                                    <?php }?>

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
                        <div class="product_tab_content" id="techdoc_inc">

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

    <?php } ?>

<?php } ?>



