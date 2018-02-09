<?
//\Yii::$app->pr->print_r2($filterManufacturers);
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
                    <td data-param="manufacturer" class="name">Производитель:</td>
                    <td class="tags">
                        <ul class="tag_list">
                            <?foreach($filterManufacturers as $oneFilter){?>
                                <li data-tag="<?=$oneFilter['key'];?>" class="tag_item"><?=$oneFilter['key'];?> <span>(<?=$oneFilter['doc_count'];?>)</span></li>
                            <?}?>
                        </ul>
                    </td>
                </tr>
            <?}?>

            <?foreach($filterData as $key => $oneFilter){?>
                <tr class="filter_selector_item">
                    <td data-param="<?=$key;?>" class="name"><?=$oneFilter['prop_name'];?>:</td>
                    <td class="tags">
                        <ul class="tag_list">
                            <?foreach($oneFilter['prop_values']['buckets'] as $oneBucket){?>
                                <li data-tag="<?=$oneBucket['key'];?>" class="tag_item"><?=$oneBucket['key'];?> <span>(<?=$oneBucket['doc_count'];?>)</span></li>
                            <?}?>
                        </ul>
                    </td>
                </tr>
            <?}?>
        </table>
        <div class="apply_filter_btn_wrap">

            <form action="" method="post" class="filter_form hidden" name="productFilterForm" id="filter-form">
                <?foreach($filterData as $key => $oneFilter){?>
                    <input type="hidden" name="<?=$key;?>" value="">
                <?}?>

                <input type="hidden" name="manufacturer" value="">

                <input type="hidden" name="catalog_filter" value="Y">

                <input type="hidden" name="perPage" value="<?=$perPage;?>">

                <input type="hidden" name="<?=\Yii::$app->request->csrfParam; ?>" value="<?=\Yii::$app->request->getCsrfToken(); ?>" />

            </form>

            <input type="submit" form="filter-form" class="apply_filter_btn" value="Применить фильтр">
        </div>
    </div>
</div>