<?
//\Yii::$app->pr->print_r2($filterData);
//\Yii::$app->pr->print_r2($filterSections);
//\Yii::$app->pr->die();
?>
<div class="goods_filter_block col_1180">

    <filter_applied id="filter_applied" data='<?=$appliedFilterJson;?>'></filter_applied>



    <div class="goods_filter_wrap">

        <div class="filter_btn js-filter_dropdown inactive">Фильтр</div>

        <div class="filter_params_applied" data-empty="&nbsp;&nbsp;&nbsp;Фильтр не применен">&nbsp;&nbsp;&nbsp;Фильтр не применен

        </div>

        <div class="filter_reset_btn m_search"><div>Сброс</div></div>
    </div>



    <div class="filter_selector_wrap collapsed">
        <div class="apply_filter_btn_wrap">

            <form action="" method="post" class="filter_form hidden" name="productFilterForm" id="filter-form">

                <input type="hidden" class="js-filter-param" name="manufacturer" value="">
                <input type="hidden" class="js-filter-param" name="section_id" value="">

                <?foreach($filterData as $key => $oneFilter){?>
                    <input type="hidden" class="js-filter-param" name="<?=$key;?>" value="">
                <?}?>

                <input type="hidden" name="catalog_filter" value="Y">

                <input type="hidden" id="on_stores" name="on_stores" value="">
                <input type="hidden" id="marketing" name="marketing" value="">

                <input type="hidden" name="perPage" value="<?=$perPage;?>">

                <input type="hidden" name="<?=\Yii::$app->request->csrfParam; ?>" value="<?=\Yii::$app->request->getCsrfToken(); ?>" />

            </form>

            <input type="submit" form="filter-form" class="apply_filter_btn" value="Применить фильтр">
        </div>
    </div>
</div>


<div class="goods_filter_block_2 col_1180">

    <filter_applied id="filter_applied" data='<?=$appliedFilterJson;?>'></filter_applied>



    <div class="goods_filter_wrap">

        <div class="filter_btn js-filter_dropdown active">Фильтр</div>

        <div class="filter_params_applied">
            <div class="filter__inner_empty js-empty-filter js-filter_dropdown active" style="display: none;">Выбрать параметры для фильтра <span class="arrow"></span></div>
            <div class="filter__inner_params">
                <div class="filter_selector_wrap expanded">
                    <?if(isset($filterManufacturers['aggregations']) && is_array($filterManufacturers['aggregations'])){?>
                        <div class="filter-group">
                            <div class="filter-group__name js-filter-param-name " data-param="manufacturer">Производитель (<?php echo $filterManufacturers['overallCount'];?>):</div>
                            <div class="filter-group__applied_params js-applied_filter_group"><span class="applied_filter_params_list js-applied_filter_params_list"></span><span data-param="manufacturer" class="cross js-cancel-filter-group"></span></div>
                            <div class="filter-group__collapse-btn js-show-filter_group">список <span class="arrow"></span></div>
                            <div class="filter-group__params-box collapsed">
                                <ul class="filter-group__params-list ">
                                    <?foreach($filterManufacturers['aggregations'] as $oneFilter){?>
                                        <li data-tag="<?=$oneFilter['key'];?>" class="filter-group__params-item js-filter-param-item"><?=$oneFilter['key'];?> <span class="filter-group__params-count">(<?=$oneFilter['doc_count'];?>)</span></li>
                                    <?}?>
                                </ul>
                                <div class="filter-group__buttons_block">
                                    <button class="filter-group__reset js-reset-filter-group">Закрыть</button>
                                    <input type="submit" form="filter-form" class="filter-group__apply js-submit-filter" data-param="manufacturer" value="Применить">
                                </div>
                            </div>
                        </div>
                    <?}?>

                    <?if(isset($filterSections['aggregations']) && is_array($filterSections['aggregations'])){?>
                        <div class="filter-group">
                            <div class="filter-group__name js-filter-param-name " data-param="section_id">Раздел (<?php echo $filterSections['overallCount'];?>):</div>
                            <div class="filter-group__applied_params js-applied_filter_group"><span class="applied_filter_params_list js-applied_filter_params_list"></span><span data-param="section_id" data-aggregations="<?=$appliedFilterSectionJson;?>" class="cross js-cancel-filter-group"></span></div>
                            <div class="filter-group__collapse-btn js-show-filter_group">список <span class="arrow"></span></div>
                            <div class="filter-group__params-box collapsed">
                                <ul class="filter-group__params-list ">
                                    <?foreach($filterSections['aggregations'] as $oneFilter){?>
                                        <li data-tag="<?=$oneFilter['key'];?>" class="filter-group__params-item js-filter-param-item"><?=$oneFilter['name'];?> <span class="filter-group__params-count">(<?=$oneFilter['doc_count'];?>)</span></li>
                                    <?}?>
                                </ul>
                                <div class="filter-group__buttons_block">
                                    <button class="filter-group__reset js-reset-filter-group">Закрыть</button>
                                    <input type="submit" form="filter-form" class="filter-group__apply js-submit-filter" data-param="section_id" value="Применить">
                                </div>
                            </div>
                        </div>
                    <?}?>

                    <?foreach($filterData as $key => $oneFilter){?>
                        <div class="filter-group">
                            <div class="filter-group__name js-filter-param-name " data-param="<?=$key;?>"><?=$oneFilter['prop_name'];?>:</div>
                            <div class="filter-group__applied_params js-applied_filter_group"><span class="applied_filter_params_list js-applied_filter_params_list"></span><span data-param="<?=$key;?>" class="cross js-cancel-filter-group"></span></div>
                            <div class="filter-group__collapse-btn js-show-filter_group">список <span class="arrow"></span></div>
                            <div class="filter-group__params-box collapsed">
                                <ul class="filter-group__params-list ">
                                    <?foreach($oneFilter['prop_values']['buckets'] as $i => $oneBucket){?>
                                        <li data-tag="<?=$oneBucket['key'];?>" class="filter-group__params-item js-filter-param-item"><?=$oneBucket['key'];?> <span class="filter-group__params-count">(<?=$oneBucket['doc_count'];?>)</span></li>
                                    <?}?>
                                </ul>
                                <div class="filter-group__buttons_block">
                                    <button class="filter-group__reset js-reset-filter-group">Закрыть</button>
                                    <input type="submit" form="filter-form" class="filter-group__apply js-submit-filter" data-param="<?=$key;?>" value="Применить">
                                </div>
                            </div>
                        </div>
                    <?}?>

                </div>
            </div>
        </div>

        <div class="filter_reset_btn"><div>Сброс</div></div>
    </div>
</div>
