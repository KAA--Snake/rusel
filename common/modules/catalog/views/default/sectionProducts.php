<?php

use yii\helpers\Url;


\Yii::$app->pr->print_r2($currentSectionProducts);

?>


<div class="product_cards_block">

    <?php if(count($currentSectionProducts) > 0){?>
        <?php foreach($currentSectionProducts as $oneProduct){
            $url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['_source']['url']).'/');
            ?>

            <div class="product_card js-tab_collapsed">
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
                    <img src="<?= Url::to('@catImages/'.$oneProduct['_source']['properties']['main_picture']); ?>" alt="">
                </div>

                <div class="card_part in_stock">
                    <?php
                    //флаг- есть ли хоть 1 товар в доступных ?
                    $isAnyAvailable = false;?>

                    <?php if($oneProduct['_source']['quantity']['stock']['count'] > 0){
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

                    <?php if($oneProduct['_source']['quantity']['partner_stock']['count'] > 0){
                        $isAnyAvailable = true;
                        ?>
                        <div class="in_stock_item available">
                            Доступно:
                                <span class="avilable_count">
                                    <?= $oneProduct['_source']['quantity']['partner_stock']['count'];?> шт.

                                    <?php if(!empty($oneProduct['_source']['quantity']['partner_stock']['description'])){?>
                                        <?= $oneProduct['_source']['quantity']['partner_stock']['description'];?>
                                    <?php }?>
                                </span>
                        </div>
                    <?php } ?>

                    <?php if($oneProduct['_source']['quantity']['for_order']['description'] != ''){
                        $overText = 'Сверх доступного:';
                        if(!$isAnyAvailable){
                            $overText = 'Под заказ:';
                        }
                        ?>
                        <div class="in_stock_item preorder">
                            <?= $overText;?>
                            <span class="preorder_count">

                                <?php if(!empty($oneProduct['_source']['quantity']['for_order']['description'])){?>
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
                        <div class="special_tape">Специальная цена</div>
                        <div class="price_vars">
                            <div class="price_var_item clear">
                                <span class="count fll">1+</span>
                                <span class="price flr">10000000.00 &#8381;/шт</span>
                            </div>
                            <div class="price_var_item clear">
                                <span class="count fll">1+</span>
                                <span class="price flr">100000000.00 &#8381;/шт</span>
                            </div>
                            <div class="price_var_item clear">
                                <span class="count fll">1+</span>
                                <span class="price flr">100000000.00 Р/шт</span>
                            </div>
                        </div>


                    <?php }else{ ?>

                        <div class="price_vars">
                            <?php if(!empty($oneProduct['_source']['prices']) && count($oneProduct['_source']['prices']) > 0){ ?>
                                <?php foreach($oneProduct['_source']['prices'] as $onePrice){

                                    if(count($onePrice) > 0){
                                        foreach($onePrice as $singlePrices){ ?>

                                            <div class="price_var_item clear">
                                                <span class="count fll"><?= $singlePrices['range'];?></span>
                                                <span class="price flr"><?= $singlePrices['value'];?> Р/шт</span>
                                            </div>


                                    <?php }
                                    }
                                    //\Yii::$app->pr->print_r2($onePrice);
                                    ?>


                                <?php } ?>

                            <?php } ?>
                        </div>

                    <?php } ?>

                </div>
                <div class="card_part order">
                    <input type="text" class="order_input" placeholder="Введите количество">

                    <div class="ordered_input hidden">
                        <span class="ordered_icon"></span>
                        <span class="ordered_count">25 000 шт.</span>
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

                            <!-------------------------------------------------------------------------------------------------->
                            <!--товары внутри вкладки принадлежности-->
                            <!-------------------------------------------------------------------------------------------------->

                            <div class="product_card product_card_inner js-tab_collapsed">
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
                                    <div class="in_stock_item available">Доступно: <span class="avilable_count">123 шт. (1-2 дня)</span>
                                    </div>
                                    <div class="in_stock_item preorder">Сверх доступного: <span class="preorder_count">4-5 недель</span>
                                    </div>
                                    <br>
                                    <div class="in_stock_item pack">Упаковка: <span class="pack_count">50 шт</span></div>
                                    <div class="in_stock_item minorder">Мин.заказ: <span class="minorder_count">100 шт</span>
                                    </div>
                                </div>
                                <div class="card_part prices">
                                    <div class="special_tape">Специальная цена</div>
                                    <div class="price_vars">
                                        <div class="price_var_item clear">
                                            <span class="count fll">1+</span>
                                            <span class="price flr">100.00 &#8381;/шт</span>
                                        </div>
                                        <div class="price_var_item clear">
                                            <span class="count fll">1+</span>
                                            <span class="price flr">100.00 &#8381;/шт</span>
                                        </div>
                                        <div class="price_var_item clear">
                                            <span class="count fll">1+</span>
                                            <span class="price flr">100.00 Р/шт</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card_part order">
                                    <input type="text" class="order_input" placeholder="Введите количество">

                                    <div class="ordered_input hidden">
                                        <span class="ordered_icon"></span>
                                        <span class="ordered_count">25 000 шт.</span>
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
                            <div class="product_card product_card_inner js-tab_collapsed">
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
                                    <div class="in_stock_item available">Доступно: <span class="avilable_count">123 шт. (1-2 дня)</span>
                                    </div>
                                    <div class="in_stock_item preorder">Сверх доступного: <span class="preorder_count">4-5 недель</span>
                                    </div>
                                    <br>
                                    <div class="in_stock_item pack">Упаковка: <span class="pack_count">50 шт</span></div>
                                    <div class="in_stock_item minorder">Мин.заказ: <span class="minorder_count">100 шт</span>
                                    </div>
                                </div>
                                <div class="card_part prices">
                                    <div class="special_tape">Специальная цена</div>
                                    <div class="price_vars">
                                        <div class="price_var_item clear">
                                            <span class="count fll">1+</span>
                                            <span class="price flr">100.00 &#8381;/шт</span>
                                        </div>
                                        <div class="price_var_item clear">
                                            <span class="count fll">1+</span>
                                            <span class="price flr">100.00 &#8381;/шт</span>
                                        </div>
                                        <div class="price_var_item clear">
                                            <span class="count fll">1+</span>
                                            <span class="price flr">100.00 Р/шт</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card_part order">
                                    <input type="text" class="order_input" placeholder="Введите количество">

                                    <div class="ordered_input hidden">
                                        <span class="ordered_icon"></span>
                                        <span class="ordered_count">25 000 шт.</span>
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
                            <!-------------------------------------------------------------------------------------------------->
                            <!--КОНЕЦ товары внутри вкладки принадлежности-->
                            <!-------------------------------------------------------------------------------------------------->
                        </div>
                    </div>
                    <div class="hide_tabs_wrap">
                        <div class="hide_tabs_btn">Свернуть</div>
                    </div>
                </div>
            </div>
        <?php }?>
    <?php }?>



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
            <div class="in_stock_item available">Доступно: <span class="avilable_count">123 шт. (1-2 дня)</span></div>
            <div class="in_stock_item preorder">Сверх доступного: <span class="preorder_count">4-5 недель</span></div>
            <br>
            <div class="in_stock_item pack">Упаковка: <span class="pack_count">50 шт</span></div>
            <div class="in_stock_item minorder">Мин.заказ: <span class="minorder_count">100 шт</span></div>
        </div>
        <div class="card_part prices">
            <div class="special_tape">Специальная цена</div>
            <div class="price_vars">
                <div class="price_var_item clear">
                    <span class="count fll">1+</span>
                    <span class="price flr">100.00 Р/шт</span>
                </div>
                <div class="price_var_item clear">
                    <span class="count fll">1+</span>
                    <span class="price flr">100.00 Р/шт</span>
                </div>
                <div class="price_var_item clear">
                    <span class="count fll">1+</span>
                    <span class="price flr">100.00 Р/шт</span>
                </div>
            </div>
        </div>
        <div class="card_part order">
            <input type="text" class="order_input" placeholder="Введите количество">

            <div class="ordered_input hidden">
                <span class="ordered_icon"></span>
                <span class="ordered_count">25 000 шт.</span>
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

</div>
