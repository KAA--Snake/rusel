<?php

    use yii\helpers\Url;

    //здесь выводится все по товару

    //\Yii::$app->pr->print_r2($oneProduct);
    //die();
    //print_r($product['properties']);


    ?>
<div class="product_cards_block _detail">

    <?php

    $url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['url']).'/');
?>

    <div class="product_card js-tab_collapsed">
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
        <?php if(!empty($oneProduct['other_properties'])){?>
            <div class="more js-expand-tabs">
                <a href="">Подробнее ↓</a>
            </div>
        <?php }?>
    </div>




    <div class="card_part img">
        <?php if(isset($oneProduct['properties']['main_picture']) && !is_array($oneProduct['properties']['main_picture'])){ ?>
            <img src="<?= Url::to('@catImages/'.$oneProduct['properties']['main_picture']); ?>" alt="">
        <?php } ?>
    </div>

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


                $overText = 'Сверх доступного:';
                if(!$isAnyAvailable){
                    $overText = 'Под заказ:';
                }
                ?>
                <div class="in_stock_item preorder">
                    <?= $overText;?>
                    <span class="preorder_count">

                        <?php if(!empty($oneProduct['quantity']['for_order']['description']) && !is_array($oneProduct['quantity']['for_order']['description'])){?>
                            <?= $oneProduct['quantity']['for_order']['description'];?>
                        <?php }?>

                    </span>
                </div>
            <?php } ?>
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

    <div class="product_card_more collapsed">
        <div class="product_tab">
            <ul class="product_specs_list">
                <li class="product_tab_item"><a href="#params">Параметры</a></li>
                <li class="product_tab_item"><a href="#techdoc">Техническая документация</a></li>
                <li class="product_tab_item"><a href="#appurtenant">Принадлежности</a></li>
            </ul>
            <div class="product_tab_content" id="params">
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
            <div class="product_tab_content" id="techdoc">
                <p>
                    какая то Техническая документация
                </p>

            </div>
            <div class="product_tab_content" id="appurtenant">

                <?php /** товары внутри вкладки принадлежности*/ ?>
                <?php if(isset($oneProduct['accessories']) && count($oneProduct['accessories']) > 0){ ?>
                    <?= $this->render('productInclude', ['currentSectionProducts' => $oneProduct['accessories']]); ?>
                <?php }?>

            </div>
        </div>
        <div class="hide_tabs_wrap">
            <div class="hide_tabs_btn">Свернуть</div>
        </div>
    </div>

</div>

</div>



</div>
