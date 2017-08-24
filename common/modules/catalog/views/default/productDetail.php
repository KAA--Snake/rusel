<?php

use yii\helpers\Url;

//здесь выводится все по товару
//\Yii::$app->pr->print_r2($oneProduct);
//print_r($product['properties']);

$url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['url']).'/');
?>

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
                        $isAnyAvailable = false;?>

                        <?php if(isset($oneProduct['quantity']['stock']['count']) && $oneProduct['quantity']['stock']['count'] > 0){
                            $isAnyAvailable = true;
                            ?>
                            <div class="in_stock_item available">
                                Доступно:
                                <span class="avilable_count">
                        <?= $oneProduct['quantity']['stock']['count'];?> шт.

                                    <?php if(!empty($oneProduct['quantity']['stock']['description'])){?>
                                        <?= $oneProduct['quantity']['stock']['description'];?>
                                    <?php }?>

                    </span>
                            </div>
                        <?php } ?>

                        <?php if(isset($oneProduct['quantity']['partner_stock']['count']) && $oneProduct['quantity']['partner_stock']['count'] > 0){
                            $isAnyAvailable = true;
                            ?>
                            <div class="in_stock_item available">
                                Доступно:
                                <span class="avilable_count">
                        <?= $oneProduct['quantity']['partner_stock']['count'];?> шт.

                                    <?php if(!empty($oneProduct['quantity']['partner_stock']['description']) && !is_array($oneProduct['quantity']['partner_stock']['description'])){?>
                                        <?= $oneProduct['quantity']['partner_stock']['description'];?>
                                    <?php }?>
                    </span>
                            </div>
                        <?php } ?>

                        <?php if( isset($oneProduct['quantity']['for_order']['description']) ){

                            if(!is_array($oneProduct['quantity']['for_order']['description'])){


                                $overText = 'Дополнительно:';
                                if(!$isAnyAvailable){
                                    $overText = 'Под заказ:';
                                }
                                ?>

                                <?php
                                if(!$isAnyAvailable){ ?>
                                    <div class="in_stock_item available">Доступно: <span class="avilable_count">0 шт.</span></div>
                                <?php } ?>
                                <div class="in_stock_item preorder">
                                    <?= $overText;?>
                                    <span class="preorder_count">

                        <?php if(!empty($oneProduct['quantity']['for_order']['description']) && !is_array($oneProduct['quantity']['for_order']['description'])){?>
                            <?= $oneProduct['quantity']['for_order']['description'];?>
                        <?php }?>

                    </span>
                                </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="in_stock_item available">Доступно: <span class="avilable_count">0 шт.</span></div>
                        <?php } ?>


                        <br>
                        <div class="in_stock_item pack">
                            Упаковка:
                            <span class="pack_count">
                <?= $oneProduct['product_logic']['norma_upakovki'];?> шт
            </span>
                        </div>
                        <div class="in_stock_item minorder">
                            Мин.заказ:
                            <span class="minorder_count">
                <?= $oneProduct['product_logic']['min_zakaz'];?> шт
            </span>
                        </div>
                    </div>
                </td>
                <td class="left_bordered">
                    <div class="card_part prices">
                        <?php if(!empty($oneProduct['marketing']['price']) && $oneProduct['marketing']['price'] > 0){ ?>

                            <div class="special_tape"><?= $oneProduct['marketing']['name']; ?></div>
                            <div class="price_vars">
                                <div class="price_var_item clear">
                                    <span class="count fll">1+<!-- - НЕТ ДАННЫХ ДЛЯ ЭТОГО ПОЛЯ В ВЫГРУЗКЕ !--></span>
                                    <span class="price flr"><?= $oneProduct['marketing']['price']; ?> Р/шт</span>
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
                                                            <span class="price flr"><?= $singlePrices['value'];?> Р/шт</span>
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
                            <span class="ordered_count">25 000 шт.</span>
                            <span class="ordered_price">252 000 Р.</span>
                        </div>

                        <div class="ordered_btn add">Добавить в запрос</div>
                    </div>
                    <?php /**-------------------------------------------------------------------------*/?>
                </td>
            </tr>
        </table>
    </div>

    <div class="_detail_section product_params">
        <h2>Параметры</h2>
        <table class="params_tab">
            <?php if(!empty($oneProduct['other_properties']['property']) && count($oneProduct['other_properties']['property']) > 0){ ?>
                <?php foreach($oneProduct['other_properties']['property'] as $singleProp){ ?>
                    <tr>
                        <td class="param_name"><?= $singleProp['name']; ?></td>
                        <td class="param_value"><?= $singleProp['value']; ?></td>
                    </tr>
                <?php }?>
            <?php }?>
        </table>
    </div>

    <div class="_detail_section tech_docs">
        <h2>Техническая документация</h2>
        <ul class="docs_list">
            <li class="docs_item pdf">
                <a class="docs_file_link " href="">Инструкция.pdf</a>
            </li>
        </ul>
    </div>

    <?php /** товары внутри вкладки принадлежности*/ ?>
    <?php if(isset($oneProduct['accessories']) && count($oneProduct['accessories']) > 0){ ?>
    <div class="_detail_section _appurtenants">
        <h2>Принадлежности</h2>



            <?= $this->render('productInclude', ['currentSectionProducts' => $oneProduct['accessories']]); ?>



    </div>
    <?php }?>
</div>
