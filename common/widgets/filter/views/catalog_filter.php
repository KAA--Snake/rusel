<?
//\Yii::$app->pr->print_r2($filterData);
?>
<div class="goods_filter_block col_1180">
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
            <?foreach($filterData as $oneFilter){?>
                <tr class="filter_selector_item">
                    <td data-param="<?=$oneFilter['md_key'];?>" class="name"><?=$oneFilter['key'];?>:</td>
                    <td class="tags">
                        <ul class="tag_list">
                            <?foreach($oneFilter['sub_sub_aggr']['buckets'] as $oneBucket){?>
                                <li data-tag="<?=$oneBucket['key'];?>" class="tag_item"><?=$oneBucket['key'];?></li>
                            <?}?>
                        </ul>
                    </td>
                </tr>
            <?}?>
        </table>
        <div class="apply_filter_btn_wrap">

            <form action="" method="post" class="filter_form hidden" name="productFilterForm" id="filter-form">
                <?foreach($filterData as $oneFilter){?>
                    <input type="hidden" name="<?=$oneFilter['md_key'];?>" value="">
                <?}?>

                <input type="hidden" name="perPage" value="<?=$perPage;?>">

                <input type="hidden" name="<?=\Yii::$app->request->csrfParam; ?>" value="<?=\Yii::$app->request->getCsrfToken(); ?>" />

            </form>

            <input type="submit" form="filter-form" class="apply_filter_btn" value="Применить фильтр">
        </div>
    </div>
</div>