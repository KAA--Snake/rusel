<?php
use yii\helpers\Url;
use common\modules\catalog\models\Section;
use common\widgets\catalog\Paginator;
use common\modules\catalog\models\currency\Currency;

//echo 'Поиск по производителю ' . $manufacturer;

/** список товаров лежит в $productsList */

/** список раздлелов лежит в $groupedSections */

//\Yii::$app->pr->print_r2($groupedSections);

$sectionModel = new Section();
$totalProductsFound = $paginator['totalCount'];
$perPage = $paginator['maxSizeCnt'];
?>
<div class="manufacturer_tree_wrap clear">
    <div class="manufacturer_tree_header">
        Программа поставок: <h1 class="manufacturer_name"><?= $manufacturer;?></h1>
    </div>
    <div class="catalog_tree_container fll">
        <?php
        if(count($groupedSections) > 0){
            foreach ($groupedSections as $oneSibling) { ?>

                <div class="content_block">
                    <div class="tree_container clear">
                        <!--<div class="tree_img fll">
                            <img src="<?/*= Url::to('@web/img/tree_img3.png'); */?>" alt="<?/*= $currentSection->name; */?>">
                        </div>-->
                        <div class="catalog_tree_wrap fll">

                            <div class="manufacturer_cat_name">
                                <!--<a href="<?/*= Url::toRoute(['@catalogDir/' . $oneSibling['url']]); */?>"><?/*= $oneSibling['name']; */?></a>-->
                                <?= $oneSibling['name']; ?>
                            </div>


                            <?php if (count($oneSibling['childs']) > 0) {
                                foreach ($oneSibling['childs'] as $oneSubSibling) {

                                    ?>
                                    <h2>
                                        <a class="tree_header active"
                                           href="<?= Url::toRoute(['@catalogDir/' . $oneSubSibling['url']]); ?>">
                                            <span class="red_icon"></span>
                                            <?= $oneSubSibling['name']; ?>
                                            <div class="tree_header_icon <?php if (count($oneSubSibling['childs']) > 0) { ?>active<? } else { ?>inactive<? } ?>"></div>
                                        </a>
                                    </h2>


                                    <?php if (count($oneSubSibling['childs']) > 0) {
                                        //if($oneSibling->not_show) continue;
                                        ?>
                                        <div class="tree_list" style="display: none;">

                                            <?php
                                            $sectionModel->recursiveLevel = 1;
                                            $sectionModel->listTree2($oneSubSibling['childs']);
                                            ?>

                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            <?}?>
        <?}?>
    </div>
</div>



<!--<div class="filter_unavailable">
    Для использования фильтра требуется выбрать группу
</div>-->
<div class="content_wrap">
    <div class="sub_filter_wrap clear">
	    <?=\common\widgets\filter_small\WFilterSmall::widget(['totalProductsFound' => $totalProductsFound]);?>
        <div class="catalog_render_count flr">
            На странице: <span class="count_num_selected js-selected_count_vars"><?=$perPage;?></span> строк
            <div class="count_vars" style="display: none;">
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


            <?php foreach($productsList as $oneProduct){
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
                                        <?php /** @TODO здесь будет ссылка на фильтр по производителю !!*/?>
                                        <a href=""><?=$oneProduct['_source']['properties']['proizvoditel'];?></a>
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


                                                </td>
                                            </tr>

                                        <?php } ?>

                                        <?php if(!$isAnyAvailable && !$isAnyAvailablePartner) {?>
                                            <tr>
                                                <td class="instock_def">Доступно:</td>
                                                <td class="instock_count">под заказ</td>
                                            </tr>
                                        <?php }?>

                                        <?php if( isset($oneProduct['_source']['quantity']['for_order']['description']) ){

                                            if(!is_array($oneProduct['_source']['quantity']['for_order']['description'])){
                                                $overText = 'Срок отгрузки:';
                                                if(!$isAnyAvailable && !$isAnyAvailablePartner) {
                                                    $overText = 'Срок поставки:';
                                                }?>
                                                <tr>
                                                    <td class="instock_def"><?= $overText;?></td>
                                                    <td class="instock_count">
                                                        <?php if (!empty($oneStorage['quantity']['stock']['description'])) { ?>
                                                            <span class="count_tooltip_trigger"><?= $oneStorage['quantity']['stock']['description']; ?>
                                                                <span class="count_tooltip">Срок отгрузки со склада РУСЭЛ.24 после оплаты счета <span
                                                                            class="corner"></span></span></span>

                                                        <?php } else { ?>
                                                            <?php if (!empty($oneStorage['quantity']['for_order']['description']) && !is_array($oneStorage['quantity']['for_order']['description'])) { ?>
                                                                <?= $oneStorage['quantity']['for_order']['description']; ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                            <?php } ?>
                                        <?php } ?>

                                        <tr>
                                            <td class="instock_def">Упаковка: </td>
                                            <td class="instock_count"><?= $oneProduct['_source']['product_logic']['norma_upakovki'];?> <?= $oneProduct['_source']['ed_izmerenia'];?></td>
                                        </tr>

                                        <tr>
                                            <td class="instock_def">Минимум: </td>
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
                                                <span class="count fll"></span>
                                                <span class="price flr"><?=$price;?>
                                                    <?=Currency::getCurrencyName();?>/<?= $oneProduct['_source']['ed_izmerenia'];?></span>
                                            </div>
                                        </div>

                                    <?php }else{ ?>

                                        <div class="price_vars">
                                            <?php
                                            if(!empty($oneProduct['_source']['prices']) && count($oneProduct['_source']['prices']) > 0){

                                                if(isset($oneProduct['_source']['prices']['price_not_available'])){
                                                    ?>

                                                    <div class="price_var_item js-price_not_available clear">
                                                        <span class="price flr"><?= $oneProduct['_source']['prices']['price_not_available']['value'];?></span>
                                                    </div>

                                                    <?php

                                                }else{

                                                    if(isset($oneProduct['_source']['prices']['price_range']['value'])){
                                                        ?>

                                                        <div class="price_var_item js-price_available clear">
                                                            <span class="count fll">от <?= $oneProduct['_source']['prices']['price_range']['range'];?></span>
                                                            <?
                                                            $price = Currency::getPriceForCurrency(
                                                                $oneProduct['_source']['prices']['price_range']['currency'],
                                                                $oneProduct['_source']['prices']['price_range']['value'],
                                                                2
                                                            );
                                                            ?>
                                                            <span class="price flr"><?=$price;?> <?=Currency::getCurrencyName();?>/<?= $oneProduct['_source']['ed_izmerenia'];?></span>
                                                        </div>

                                                        <?php

                                                    }else{

                                                        foreach($oneProduct['_source']['prices'] as $onePrice){

                                                            if(count($onePrice) > 0){
                                                                foreach($onePrice as $singlePrices){

                                                                    $price = Currency::getPriceForCurrency(
                                                                        $singlePrices['currency'],
                                                                        $singlePrices['value'],
                                                                        2
                                                                    );
                                                                    ?>

                                                                    <div class="price_var_item js-price_available clear">
                                                                        <span class="count fll">от <?= $singlePrices['range'];?></span>
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

                                <div class="card_part order js-order_data"
                                     data-product-prices="<?=urlencode(json_encode($oneProduct['_source']['prices']));?>"
                                     data-product-norma_upakovki="<?=urlencode(json_encode($oneProduct['_source']['product_logic']['norma_upakovki']));?>"
                                     data-product-min_zakaz="<?=urlencode(json_encode($oneProduct['_source']['product_logic']['min_zakaz']));?>"
                                     data-product-partner-count="<?=urlencode(json_encode($oneProduct['_source']['quantity']['partner_stock']['count']));?>"
                                     data-product-count="<?=urlencode(json_encode($oneProduct['_source']['quantity']['stock']['count']));?>"
                                     data-product-marketing-price="<?=urlencode(json_encode($oneProduct['_source']['marketing']['price']));?>"
                                     data-product-marketing-price-currency="<?=urlencode(json_encode($oneProduct['_source']['marketing']['currency']));?>"
                                     data-product_id="<?=$oneProduct['_id'];?>"
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
                                <?php /** товары внутри вкладки принадлежности*/ ?>
                                <?php if(isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0){ ?>
                                    <li class="product_tab_item"><a href="#appurtenant">Принадлежности</a></li>
                                <?php }?>

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
                                <div class="product_tab_content" id="techdoc">

                                    <?if(count($docs) > 0){?>
                                        <ul class="docs_list">
                                            <?foreach($docs as $oneDoc){
                                                if(empty($oneDoc)) continue;
                                                ?>
                                                <li class="docs_item pdf">
                                                    <a class="docs_file_link " rel="nofollow" target="_blank" href="<?=Url::to('@catDocs/'.$oneDoc);?>"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
                                                </li>
                                            <?}?>
                                        </ul>
                                    <?}?>
                                    <div class="hide_tabs_wrap">
                                        <div class="hide_tabs_btn">Свернуть</div>
                                    </div>
                                </div>
                            <?}?>
                            <?php /** товары внутри вкладки принадлежности*/ ?>
                            <?php if(isset($oneProduct['_source']['accessories']) && count($oneProduct['_source']['accessories']) > 0){ ?>
                                <div class="product_tab_content" id="appurtenant">


                                    <?= $this->render('productInclude', ['currentSectionProducts' => $oneProduct['_source']['accessories']]); ?>


                                    <div class="hide_tabs_wrap">
                                        <div class="hide_tabs_btn">Свернуть</div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                        <!--<div class="hide_tabs_wrap">
                            <div class="hide_tabs_btn">Свернуть</div>
                        </div>-->
                    </div>

                </div>
            <?php }?>

    </div>
<?
echo Paginator::widget([
    'pagination' => $paginator,
]);
?>
