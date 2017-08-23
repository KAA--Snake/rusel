<?php

/** $currentSectionProducts в данном контексте - это список связанных товаров*/


//\Yii::$app->pr->print_r2($currentSectionProducts);
//die();
use yii\helpers\Url;

?>

<?php if(count($currentSectionProducts) > 0){ ?>

    <?php foreach($currentSectionProducts as $oneProduct){
    $url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['_source']['url']).'/');
    ?>
        <div class="product_card product_card_inner js-tab_collapsed">
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
                <?php if(!empty($oneProduct['_source']['other_properties'])){?>
                    <div class="more js-expand-tabs">
                        <a href="">Подробнее ↓</a>
                    </div>
                <?php }?>
            </div>

            <div class="card_part img">
                <?php if(isset($oneProduct['_source']['properties']['main_picture']) && !is_array($oneProduct['_source']['properties']['main_picture'])){ ?>
                    <img src="<?= Url::to('@catImages/'.$oneProduct['_source']['properties']['main_picture']); ?>" alt="">
                <?php } ?>
            </div>

            <div class="card_part in_stock">
                <?php
                //флаг- есть ли хоть 1 товар в доступных ?
                $isAnyAvailable = false;?>

                <?php if(isset($oneProduct['_source']['quantity']['stock']['count']) && $oneProduct['_source']['quantity']['stock']['count'] > 0){
                    $isAnyAvailable = true;
                    ?>
                    <div class="in_stock_item available">
                        Доступно:
                        <span class="avilable_count">
                                    <?= $oneProduct['_source']['quantity']['stock']['count'];?> шт.

                            <?php if(!empty($oneProduct['_source']['quantity']['stock']['description'])){?>
                                <?= $oneProduct['_source']['quantity']['stock']['description'];?>
                            <?php }?>

                                </span>
                    </div>
                <?php } ?>

                <?php if(isset($oneProduct['_source']['quantity']['partner_stock']['count']) && $oneProduct['_source']['quantity']['partner_stock']['count'] > 0){
                    $isAnyAvailable = true;
                    ?>
                    <div class="in_stock_item available">
                        Доступно:
                        <span class="avilable_count">
                                    <?= $oneProduct['_source']['quantity']['partner_stock']['count'];?> шт.

                            <?php if(!empty($oneProduct['_source']['quantity']['partner_stock']['description']) && !is_array($oneProduct['_source']['quantity']['partner_stock']['description'])){?>
                                <?= $oneProduct['_source']['quantity']['partner_stock']['description'];?>
                            <?php }?>
                                </span>
                    </div>
                <?php } ?>

                <?php if(isset($oneProduct['_source']['quantity']['for_order']['description']) && !is_array(['_source']['quantity']['for_order']['description'])){
                    $overText = 'Сверх доступного:';
                    if(!$isAnyAvailable){
                        $overText = 'Под заказ:';
                    }
                    ?>
                    <div class="in_stock_item preorder">
                        <?= $overText;?>
                        <span class="preorder_count">

                                <?php if(!empty($oneProduct['_source']['quantity']['for_order']['description']) && !is_array($oneProduct['_source']['quantity']['for_order']['description'])){?>
                                    <?= $oneProduct['_source']['quantity']['for_order']['description'];?>
                                <?php }?>

                            </span>
                    </div>
                <?php } ?>


                <br>
                <div class="in_stock_item pack">
                    Упаковка:
                    <span class="pack_count">
                            <?= $oneProduct['_source']['product_logic']['norma_upakovki'];?> шт
                        </span>
                </div>
                <div class="in_stock_item minorder">
                    Мин.заказ:
                    <span class="minorder_count">
                            <?= $oneProduct['_source']['product_logic']['min_zakaz'];?> шт
                        </span>
                </div>
            </div>

            <div class="card_part prices">
                <?php if(!empty($oneProduct['_source']['marketing']['price']) && $oneProduct['_source']['marketing']['price'] > 0){ ?>
                    <?php
                    //\Yii::$app->pr->print_r2($oneProduct['_source']['marketing']['name']);
                    ?>

                    <div class="special_tape"><?= $oneProduct['_source']['marketing']['name']; ?></div>
                    <div class="price_vars">
                        <div class="price_var_item clear">
                            <span class="count fll">1+<!-- - НЕТ ДАННЫХ ДЛЯ ЭТОГО ПОЛЯ В ВЫГРУЗКЕ !--></span>
                            <span class="price flr"><?= $oneProduct['_source']['marketing']['price']; ?> Р/шт</span>
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
                                    ?>

                                    <div class="price_var_item clear">
                                        <span class="count fll"><?= $oneProduct['_source']['prices']['price_range']['range'];?></span>
                                        <span class="price flr"><?= $oneProduct['_source']['prices']['price_range']['value'];?> Р/шт</span>
                                    </div>

                                    <?php

                                }else{

                                    foreach($oneProduct['_source']['prices'] as $onePrice){
                                        //\Yii::$app->pr->print_r2($onePrice);
                                        //die();
                                        if(count($onePrice) > 0){
                                            foreach($onePrice as $singlePrices){

                                                //die();
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
                            <?php if(!empty($oneProduct['_source']['other_properties']['property']) && count($oneProduct['_source']['other_properties']['property']) > 0){ ?>
                                <?php foreach($oneProduct['_source']['other_properties']['property'] as $singleProp){ ?>
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
                        <?php //= $this->render('productInclude', ['currentSectionProducts' => $oneProduct['_source']['accessories']]); ?>
                        Принадлежностей тут не будет, т.к. рекурсия. Это уже слишком.

                    </div>
                </div>
                <div class="hide_tabs_wrap">
                    <div class="hide_tabs_btn">Свернуть</div>
                </div>
            </div>

        </div>

    <?php } ?>

<?php } ?>



