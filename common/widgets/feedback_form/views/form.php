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
    if ($isSent) {
        echo "<div class='success'>";
            echo "<p>Форма успешно отправлена !</p>";
        echo "</div>";
    }
    ?>

    <?php
    if (!empty($errors)) {
        echo "<div class='errors'>";
            foreach ($errors as $errorTypes) {
                foreach ($errorTypes as $oneError) {
                    echo "<p>$oneError</p>";
                }
            }
        echo "</div>";
    }
    ?>

    <?php $form = ActiveForm::begin([
        'id' => 'feedback-form',
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
        ?>
    </div>

    <div class="label">
        <!-- Обрати внимание что здесь поставлен ->label(false) чтобы не получить дефолтный лейбл перед полем-->
        ФИО:
        <?php
        echo $form->field($model, 'fio', [
            'inputOptions' => [
                'id' => 'my-fio-input-id',
            ],
            ])
            ->textInput()
            ->label(false) //отключен дефолтный лейбл перед инпутом
        ?>
    </div>

    <div class="label">
        <?php
        echo $form->field($model, 'phone')
            ->textInput()
        ?>
    </div>

    <div class="label">
        <?php
        echo $form->field($model, 'email')
            ->input('email')
        ?>
    </div>

    <div class="label">
        <?php
        echo $form->field($model, 'company')
            ->textInput()
        ?>
    </div>
    <div class="label">
        <?php
        echo $form->field($model, 'inn')
            ->textInput()
        ?>
    </div>

    <div class="label">
        <?php
        echo $form->field($model, 'text')
            ->textarea(['rows' => 5, 'cols' => 50])
        ?>
    </div>

    <?php
    if ($oneProduct) { ?>
        <div class="label">
            <?php
            echo $form->field($model, 'productCount')
                ->textInput()
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
                'widgetOptions' => ['class' => 'recaptcha-widget']
            ]
        )->label(false);
    } catch (Exception $e) {
        \Yii::$app->pr->print_r2($e->getMessage());
    } ?>

    <?php echo Html::submitButton($buttonText, ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end(); ?>

</div>

