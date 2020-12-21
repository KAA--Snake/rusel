<?php

/* @var $this yii\web\View */
/* @var $options array */
/* @var $oneProduct array */
/* @var $errors array */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//use yii\bootstrap\ActiveForm;

//\Yii::$app->pr->print_r2($options);




?>


<div class="inner_wrap">

    <h1 class="header_h1">Форма обратной связи</h1>

    <?php
    if (!empty($errors)) {
        echo "<div class='errors'>";
            foreach ($errors as $oneError) {
                echo "<p>$oneError</p>";
            }
        echo "</div>";
    }
    ?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form-admin',
        //'action' => '/feedback-form-add/',
        'method' => 'post',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnSubmit' => false,
        'options' => ['class' => 'someClass','enctype' => 'multipart/form-data'],
    ]) ?>

    <input type="hidden" name="FeedBack[formUrl]" value="<?php echo $_SERVER['REQUEST_URI'];?>" />

    <?php
    if ($oneProduct) { ?>
        <input type="hidden" name="FeedBack[productName]" value="<?php echo $oneProduct['name'];?>" />
        <input type="hidden" name="FeedBack[artikul]" value="<?php echo $oneProduct['artikul'];?>" />
        <input type="hidden" name="FeedBack[manufacturer]" value="<?php echo $oneProduct['properties']['proizvoditel'];?>" />
    <?php }?>

    <div class="label">
        <?php
        echo $form->field($model, 'file')
            ->fileInput()
            //->hint('ФИО')
            ->label('Файл:');
        ?>
    </div>

    <div class="label">
        <?php
        echo $form->field($model, 'fio')
            ->textInput()
            //->hint('ФИО')
            ->label('ФИО:');
        ?>
    </div>

    <div class="label">
        <?php
        echo $form->field($model, 'phone')
            ->textInput()
            ->label('тел:');
        ?>
    </div>

    <div class="label">
        <?php
        echo $form->field($model, 'email')
            ->textInput()
            ->label('майл:');
        ?>
    </div>

    <div class="label">
        <?php
        echo $form->field($model, 'company')
            ->textInput()
            ->label('компания:');
        ?>
    </div>
    <div class="label">
        <?php
        echo $form->field($model, 'inn')
            ->textInput()
            ->label('ИНН:');
        ?>
    </div>

    <div class="label">
        <?php
        echo $form->field($model, 'text')
            ->textarea(['rows' => 5, 'cols' => 50])
            ->label('текст');
        ?>
    </div>

    <?php
    if ($oneProduct) { ?>
        <div class="label">
            <?php
            echo $form->field($model, 'productCount')
                ->textInput()
                ->label('Количество:');
            ?>
        </div>
    <?php }?>

    <?php
    //captcha
    try {
        echo $form->field($model, 'reCaptcha', ['enableAjaxValidation' => false])->widget(
            \himiklab\yii2\recaptcha\ReCaptcha::className(), [
                'name' => 'reCaptcha',
                'siteKey' => '6LeJeg8aAAAAAO7psesiWIQeECli_9tMUlcyJvc2',
                //'widgetOptions' => ['class' => 'recaptcha-login']
            ]
        )->label('reCaptcha');
    } catch (Exception $e) {
        \Yii::$app->pr->print_r2($e->getMessage());
    } ?>

    <?php echo Html::submitButton($buttonText, ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end(); ?>

</div>

