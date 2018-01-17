<? if ($uploaded) { ?>

    <div class="search_by_list">

        <h1>Поиск по списку</h1>

        <div class="file_name_block">
            <div>
                Список:
                <span class="uploaded_file_name"><?=$uploadedFileName;?></span>
            </div>
            <input class="by-artikuls_submit_btn" type="submit" form="by-artikuls" value="Запустить поиск"/>
        </div>

        <div class="fake_divider"></div>

        <div class="search_by_list_table">
            <form id="by-artikuls" name="by-artikuls" method="post" action="/search/by-artikuls/">
                <input type="hidden"
                       name="<?= \Yii::$app->request->csrfParam; ?>"
                       value="<?= \Yii::$app->request->getCsrfToken(); ?>"/>

                <? foreach ($artiklesList as $oneArticle) { ?>
                    <div class="list_cell">
                        <span class="square_icon"></span>
                        <input class="item_input js-search-list-item" name="articles[]" type="text" value="<?= $oneArticle; ?>">
                        <span class="delete_item js-delete_item"></span>
                        <? if(mb_strlen($oneArticle) < 4) {?>
                            <span class="article_err">Поиск по данному артиклу невозможен (min 4 символа)</span>
                        <?}?>
                    </div>
                <? } ?>
                <div class="list_cell add_item js-add_item-row">
                    <span class="add_item_btn js-add_item"></span>
                    <span class="add_item_description">Добавить строку</span>
                </div>
            </form>
        </div>
    </div>



<? } ?>
