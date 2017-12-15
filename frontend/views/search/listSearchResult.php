<div>Результат обработки:</div>
<br />
<br />
<br />
<br />
<div>
    Были загружены следующие артикулы:
    <form name="by-artikuls" method="post" action="/search/by-artikuls/">
        <input type="hidden" name="<?=\Yii::$app->request->csrfParam; ?>" value="<?=\Yii::$app->request->getCsrfToken(); ?>" />
        <? foreach($artiklesList as $oneArticle){?>
            <p>
                <input name="articles[]" type="text" value="<?=$oneArticle;?>">

            </p>
        <? }?>
        <br />
        <br />
        <input type="submit" value="Подтвердить">
    </form>
<div>

<?
\Yii::$app->pr->print_r2($productsList);
?>