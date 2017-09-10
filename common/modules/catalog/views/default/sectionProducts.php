<?php

use yii\helpers\Url;
use common\widgets\catalog\Paginator;
use common\modules\catalog\models\currency\Currency;

//echo Url::current(['perPage' => '50']);
//echo ;
//\Yii::$app->pr->print_r2(\Yii::$app->request->resolve());

//die();

?>
<div class="content_inner_wrap left0 col_1180">
<div class="goods_filter_block col_1180">
    <div class="goods_filter_wrap">

        <div class="filter_btn js-filter_dropdown inactive">Фильтр</div>
        <div class="divider"></div>
        <div class="filter_params_applied" data-empty="Фильтр не применен">Фильтр не применен
        </div>
        <div class="divider"></div>
        <div class="filter_reset_btn">Сброс</div>
    </div>
    <div class="filter_selector_wrap collapsed">
        <table class="filter_tab">
            <tr class="filter_selector_item">
                <td data-param="producer" class="name">Производитель:</td>
                <td class="tags">
                    <ul class="tag_list">
                        <li data-tag="ETI" class="tag_item">ETI</li>
                        <li data-tag="Eaton/Moeller" class="tag_item">Eaton/Moeller</li>
                        <li data-tag="Efapel" class="tag_item">Efapel</li>
                    </ul>
                </td>
            </tr>
            <tr class="filter_selector_item">
                <td data-param="nomin_tok" class="name">Ном. ток (А):</td>
                <td class="tags">
                    <ul class="tag_list">
                        <li data-tag="0.125" class="tag_item">0.125</li>
                        <li data-tag="0.16" class="tag_item">0.16</li>
                        <li data-tag="0.5" class="tag_item">0.5</li>
                        <li data-tag="0.6" class="tag_item">0.6</li>
                        <li data-tag="0.7" class="tag_item">0.7</li>
                        <li data-tag="0.8" class="tag_item">0.8</li>
                        <li data-tag="0.9" class="tag_item">0.9</li>
                        <li data-tag="1" class="tag_item">1</li>
                        <li data-tag="2" class="tag_item">2</li>
                        <li data-tag="3" class="tag_item">3</li>
                        <li data-tag="4" class="tag_item">4</li>
                        <li data-tag="5" class="tag_item">5</li>
                        <li data-tag="7" class="tag_item">7</li>
                        <li data-tag="9" class="tag_item">9</li>
                        <li data-tag="10" class="tag_item">10</li>
                        <li data-tag="12" class="tag_item">12</li>
                        <li data-tag="16" class="tag_item">16</li>
                        <li data-tag="20" class="tag_item">20</li>
                        <li data-tag="30" class="tag_item">30</li>
                        <li data-tag="50" class="tag_item">50</li>
                        <li data-tag="100" class="tag_item">100</li>
                        <li data-tag="1000" class="tag_item">1000</li>
                        <li data-tag="15000" class="tag_item">15000</li>
                    </ul>
                </td>
            </tr>
        </table>
        <div class="apply_filter_btn_wrap">
            <form action="" class="filter_form hidden" name="filter-form" id="filter-form">
                <input type="hidden" name="producer" value="">
                <input type="hidden" name="nomin_tok" value="">
            </form>
            <input type="submit" form="filter-form" class="apply_filter_btn" value="Применить фильтр">
        </div>
    </div>
</div>

<div class="sub_filter_wrap clear">
    <div class="filter_counter fll">
        Найдено: <span class="filter_num"><?=$totalProductsFound;?></span> позиций
    </div>
    <div class="catalog_render_count flr">
        На странице: <span class="count_num_selected js-selected_count_vars"><?=$perPage;?></span> строк
        <div class="count_vars hidden">
            <div class="top_corner"></div>
            <ul class="count_vars_list">
                <li class="count_vars_item"><a href="<?=Paginator::addToUrl('perPage', '25');?>">25</a></li>
                <li class="count_vars_item"><a href="<?=Paginator::addToUrl('perPage',  '50');?>">50</a></li>
                <li class="count_vars_item"><a href="<?=Paginator::addToUrl('perPage',  '100');?>">100</a></li>
                <li class="count_vars_item"><a href="<?=Paginator::addToUrl('perPage',  '200');?>">200</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="product_cards_block">

    <?php if(count($currentSectionProducts) > 0){?>
        <?php foreach($currentSectionProducts as $oneProduct){
            $url = Url::to('@catalogDir/'.str_replace('|', '/', $oneProduct['_source']['url']).'/');
            //\Yii::$app->pr->print_r2($oneProduct);
            ?>

            <div class="product_card js-tab_collapsed">
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
                                                    <?= $oneProduct['_source']['quantity']['stock']['description'];?>
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
                                                    <?= $oneProduct['_source']['quantity']['partner_stock']['description'];?>
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

                                    <div class="special_tape"><?= $oneProduct['_source']['marketing']['name']; ?></div>
                                    <div class="price_vars">
                                        <div class="price_var_item clear">
                                            <span class="count fll">1+<!-- - НЕТ ДАННЫХ ДЛЯ ЭТОГО ПОЛЯ В ВЫГРУЗКЕ !--></span>
                                            <span class="price flr"><?= $oneProduct['_source']['marketing']['price']; ?>
                                                <?=Currency::getCurrencyName($oneProduct['_source']['marketing']['currency']);?>/<?= $oneProduct['_source']['ed_izmerenia'];?></span>
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
                                                    ?>

                                                    <div class="price_var_item clear">
                                                        <span class="count fll"><?= $oneProduct['_source']['prices']['price_range']['range'];?></span>
                                                        <span class="price flr"><?= $oneProduct['_source']['prices']['price_range']['value'];?> <?=Currency::getCurrencyName($oneProduct['_source']['prices']['price_range']['currency']);?>/<?= $oneProduct['_source']['ed_izmerenia'];?></span>
                                                    </div>

                                                    <?php

                                                }else{

                                                    foreach($oneProduct['_source']['prices'] as $onePrice){

                                                        if(count($onePrice) > 0){
                                                            foreach($onePrice as $singlePrices){
                                                                ?>

                                                                <div class="price_var_item clear">
                                                                    <span class="count fll"><?= $singlePrices['range'];?></span>
                                                                    <span class="price flr"><?= $singlePrices['value'];?> <?=Currency::getCurrencyName($singlePrices['currency']);?>/<?= $oneProduct['_source']['ed_izmerenia'];?></span>
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
                            <li class="product_tab_item"><a href="#params">Параметры</a></li>
                            <li class="product_tab_item"><a href="#techdoc">Техническая документация</a></li>
            <?php /** товары внутри вкладки принадлежности*/ ?>
            <?php if(isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0){ ?>
                            <li class="product_tab_item"><a href="#appurtenant">Принадлежности</a></li>
            <?php }?>
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
                        <?php /** товары внутри вкладки принадлежности*/ ?>
                        <?php if(isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0){ ?>
                        <div class="product_tab_content" id="appurtenant">


                                <?= $this->render('productInclude', ['currentSectionProducts' => $oneProduct['_source']['accessories']]); ?>


                        </div>
                        <?php }?>
                    </div>
                    <div class="hide_tabs_wrap">
                        <div class="hide_tabs_btn">Свернуть</div>
                    </div>
                </div>

            </div>
        <?php }?>
    <?php }?>



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
    <?php */?>

</div>

<?
echo Paginator::widget([
    'pagination' => $paginator,
]);
?>

</div>