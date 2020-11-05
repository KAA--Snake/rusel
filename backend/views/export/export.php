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
<br />
<br />
<div>Процесс экспорта: <b><?php echo $exportResults;?></b></div>
<br />
<div>Сформированный хмл: <b>/upload/export/exportCatalog.xml</b></div>

<br />
<br />
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<br />
<?php echo $form->field($model, 'section_id') ?>

<br />
<?php echo $form->field($model, 'manufacturer_id') ?>
<br />
<br />

<button>Старт</button>

<?php ActiveForm::end(); ?>

