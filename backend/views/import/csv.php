<?php
use yii\widgets\ActiveForm;
?>
<?php
foreach (\Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>
<?php
if($uploaded) {
    echo '<br /> Успешно завершено! <br /><br />';
}
if($isProductsClear) {
    echo '<br /> Все товары успешно удалены! <br /><br />';
}


?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<br />
<br />
<?php echo $form->field($model, 'isNeedDropCollection')->checkbox(); /** чек- удалить товары перед выгрузкой */?>
<br />
<br />
<?php echo $form->field($model, 'file')->fileInput(['multiple' => false, 'accept' => $allowedExtensions]); ?>
<br />

    <button>Старт</button>

<?php ActiveForm::end(); ?>
