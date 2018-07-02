<?
//\Yii::$app->pr->print_r2($filterData);

?>
<div class="goods_filter_block col_1180">

    <filter_applied id="filter_applied" data='<?=$appliedFilterJson;?>'></filter_applied>

    <div class="goods_filter_wrap">

        <div class="filter_btn js-filter_dropdown inactive">Фильтр</div>
        <div class="divider"></div>
        <div class="filter_params_applied" data-empty="&nbsp;&nbsp;&nbsp;Фильтр не применен">&nbsp;&nbsp;&nbsp;Фильтр не применен
        </div>
        <div class="divider"></div>
        <div class="filter_reset_btn">Сброс</div>
    </div>
    <div class="filter_selector_wrap collapsed">
        <table class="filter_tab">

            <?if(isset($filterManufacturers) && is_array($filterManufacturers)){?>
                <tr class="filter_selector_item">
                    <td class="tags">
                        <ul class="tag_list">
                            <li data-param="manufacturer" class="name js-filter-param-name">Производитель:</li>
                            <?foreach($filterManufacturers as $oneFilter){?>
                                <li data-tag="<?=$oneFilter['key'];?>" class="tag_item js-filter-param-item"><?=$oneFilter['key'];?> <span class="filter_param_count">(<?=$oneFilter['doc_count'];?>)</span></li>
                            <?}?>
                        </ul>
                    </td>
                </tr>
            <?}?>

            <?foreach($filterData as $key => $oneFilter){?>
                <tr class="filter_selector_item">
                    <td class="tags">
                        <ul class="tag_list">
                            <li data-param="<?=$key;?>" class="name js-filter-param-name"><?=$oneFilter['prop_name'];?>:</li>
                            <?foreach($oneFilter['prop_values']['buckets'] as $i => $oneBucket){?>
                                <li data-tag="<?=$oneBucket['key'];?>" class="tag_item js-filter-param-item <?php if($i >= 10){?> hidden <?}?>"><?=$oneBucket['key'];?> <span class="filter_param_count">(<?=$oneBucket['doc_count'];?>)</span></li>
                            <?}?>
                            <?php if(count($oneFilter['prop_values']['buckets']) > 10) {?>
                                <li class="filter_more_btn js-filter-param-item-more">ЕЩЕ ↓</li>
                            <?}?>
                        </ul>
                    </td>
                </tr>
            <?}?>
        </table>
        <div class="apply_filter_btn_wrap">

            <form action="" method="post" class="filter_form hidden" name="productFilterForm" id="filter-form">

                <input type="hidden" class="js-filter-param" name="manufacturer" value="">

                <?foreach($filterData as $key => $oneFilter){?>
                    <input type="hidden" class="js-filter-param" name="<?=$key;?>" value="">
                <?}?>

                <input type="hidden" name="catalog_filter" value="Y">

                <input type="hidden" name="perPage" value="<?=$perPage;?>">

                <input type="hidden" name="<?=\Yii::$app->request->csrfParam; ?>" value="<?=\Yii::$app->request->getCsrfToken(); ?>" />

            </form>

            <input type="submit" form="filter-form" class="apply_filter_btn" value="Применить фильтр">
        </div>
    </div>
</div>