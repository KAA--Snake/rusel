<?php
use yii\widgets\ActiveForm;
?>

<?php
if($uploaded) {
    echo 'Успешно загружено ! <br />';
}

?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?php echo $form->field($model, 'file')->fileInput(['multiple' => false, 'accept' => $allowedExtensions]); ?>

    <button>Submit</button>

<?php ActiveForm::end(); ?>