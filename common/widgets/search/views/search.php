<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.18
 * Time: 12:09
 */
use yii\helpers\Url;

?>

<div class="search_block">
    <form name="search" id="top_search_form" action="/search/manual/" method="get">
        <input type="text" name="msearch" placeholder="Введите данные для поиска" class="search_field">
        <?/*?>
        <input type="hidden" name="<?=\Yii::$app->request->csrfParam; ?>" value="<?=\Yii::$app->request->getCsrfToken(); ?>" />
        <?*/?>
        <button class="submit_search">Найти</button>
        <a href="/search/" class="list_seach">Поиск по списку</a>
    </form>
</div>



