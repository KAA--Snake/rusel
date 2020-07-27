<?php
set_time_limit(0);

use yii\widgets\ActiveForm;
?>
<?php
foreach (\Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>
<?php
echo 'Результат импорта товаров: ';
\Yii::$app->pr->printR2WOChecks($importResults);
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
<br />
<br />
<br />

<hr>
<div>Ручной старт обработки выгрузки</div>
<form action="/admin/import-manual/manual" method="post" name="manual">
    Имя файла: <input type="text" name="file_name" value="">

    <input type="submit" value="Ручной старт">
</form>
