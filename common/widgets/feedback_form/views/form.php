<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//\Yii::$app->pr->print_r2($slide->getAttributes());


?>


<div class="inner_wrap">

    <h1 class="header_h1">Форма обратной связи</h1>

    <form action="/feedback-form-add/" method="post" name="feed-back" enctype="multipart/form-data" id="feed-back-form" class="feed-back-form">
        <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()); ?>

        <div class="label">
            Файл:
            <input type="file" name="FeedBack[file]" />
        </div>

        <div class="label">
            ФИО:
            <input type="text" name="FeedBack[fio]" >
        </div>

        <div class="label">
            тел:
            <input type="text" name="FeedBack[phone]" value="<?=$slide->id;?>">
        </div>

        <div class="label">
            майл:
            <input type="text" name="FeedBack[email]" value="<?=$slide->id;?>">
        </div>

        <div class="label">
            компания:
            <input type="text" name="FeedBack[company]" value="<?=$slide->id;?>">
        </div>

        <div class="label">
            текст:
            <textarea name="FeedBack[text]"></textarea>
        </div>


            <button>Отправить</button>


    </form>

</div>

