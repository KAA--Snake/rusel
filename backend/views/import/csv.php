<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'csvFile')->fileInput(['multiple' => false, 'accept' => 'csv']); ?>

    <button>Submit</button>

<?php ActiveForm::end(); ?>