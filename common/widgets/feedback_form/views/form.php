<?php

/* @var $this yii\web\View */
/* @var $options array */
/* @var $oneProduct array */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//\Yii::$app->pr->print_r2($options);

?>


<div class="inner_wrap">

    <h1 class="header_h1">Форма обратной связи</h1>

    <form action="/feedback-form-add/" method="post" name="feed-back" enctype="multipart/form-data" id="feed-back-form" class="feed-back-form">
        <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()); ?>
        <input type="hidden" name="FeedBack[formUrl]" value="<?php echo $_SERVER['REQUEST_URI'];?>" />

        <?php
        if ($oneProduct) { ?>
            <input type="hidden" name="FeedBack[productName]" value="<?php echo $oneProduct['name'];?>" />
            <input type="hidden" name="FeedBack[artikul]" value="<?php echo $oneProduct['artikul'];?>" />
            <input type="hidden" name="FeedBack[manufacturer]" value="<?php echo $oneProduct['properties']['proizvoditel'];?>" />
        <?php }?>

        <div class="label">
            Файл:
            <input type="file" name="FeedBack[file]" value="" />
        </div>

        <div class="label">
            ФИО:
            <input type="text" name="FeedBack[fio]" value="" >
        </div>

        <div class="label">
            тел:
            <input type="text" name="FeedBack[phone]" value="">
        </div>

        <div class="label">
            майл:
            <input type="text" name="FeedBack[email]" value="">
        </div>

        <div class="label">
            компания:
            <input type="text" name="FeedBack[company]" value="">
        </div>
        <div class="label">
            ИНН:
            <input type="text" name="FeedBack[inn]" value="">
        </div>

        <div class="label">
            текст:
            <textarea name="FeedBack[text]"></textarea>
        </div>

        <?php
        if ($oneProduct) { ?>
            <div class="label">
                Количество:
                <input type="text" name="FeedBack[productCount]" value="1" />
            </div>
        <?php }?>

            <button><?php echo $buttonText;?></button>

    </form>

</div>

