<div class="search_by_list">
    <h1>Поиск по списку</h1>

    <div class="file_name_block">
        <div>
            Список:
            <span class="uploaded_file_name">Имя файла должно прилетать с сервера</span>
        </div>
    </div>

    <div class="fake_divider"></div>

    <div class="articles_list">
        <div class="articles_item collapsed">

            <div class="articles_item_head">

                <span class="article_name">
                    <span class="square_icon"></span>
                    2666.0304
                </span>
                <span class="article_count">Найдено: <span class="article_count_num">1</span></span>
                <span class="article_expand-btn">
                    Подробнее
                    <span class="arrow"></span>
                </span>
            </div>

            <div class="articles_item_body"></div>

            <div class="articles_item_foot">
                <span class="show_btn show_10"></span>
                <span class="show_btn show_all"></span>
                <span class="article_collapse-btn">
                    Свернуть
                    <span class="arrow_up"></span>
                </span>
            </div>
        </div>
        <div class="fake_divider"></div>
    </div>

    Были загружены следующие артикулы:
    <form name="by-artikuls" method="post" action="/search/by-artikuls/">
        <input type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
               value="<?= \Yii::$app->request->getCsrfToken(); ?>"/>
        <? foreach ($artiklesList as $oneArticle) { ?>
            <p>
                <input name="articles[]" type="text" value="<?= $oneArticle; ?>">

            </p>
        <? } ?>
        <br/>
        <br/>
        <input type="submit" value="Подтвердить">
    </form>
    <div>

        <?
        \Yii::$app->pr->print_r2($productsList);
        ?>
    </div>
</div>

</div>
