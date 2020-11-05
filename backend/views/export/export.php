<?php
set_time_limit(0);

use yii\widgets\ActiveForm;
?>
<?php
foreach (\Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}

//\Yii::$app->pr->printR2WOChecks($model->getAttributes());
//die();
?>
<div>Процесс экспорта: <b><?php echo $exportResults;?></b></div>
<div>Сформированный хмл: <b></b></div>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<br />
<?php echo $form->field($model, 'section_id') ?>
<br />

<button>Старт</button>

<?php ActiveForm::end(); ?>

