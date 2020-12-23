<?php

/** @var $this \yii\web\View */
/** @var $feedback \common\modules\catalog\models\FeedBack */

?>

<p>
  Отправлена форма с сайта
</p>

<p>
    URL с которого отправлена: <b> <?php echo $feedback->formUrl;?> </b>
</p>


<p>
    Дата и время отправки: <b> <?php echo $date;?> </b>
</p>

<p>
    ФИО: <b> <?php echo $feedback->fio;?> </b>
</p>

<p>
    Телефон: <b><?php echo $feedback->phone;?></b>
</p>

<p>
    Емайл: <b><?php echo $feedback->email;?></b>
</p>

<p>
    Компания: <b><?php echo $feedback->company;?></b>
</p>

<p>
    ИНН: <b><?php echo $feedback->inn;?></b>
</p>

<p>
    Текст: <b><?php echo $feedback->text;?></b>
</p>

<?php
if ($isFileAttached) {
?>
<p>
    Приложенный файл: <?php echo $feedback->fileUrl;?>
</p>
<? } ?>

<p>
    Данные по товару:
</p>

<br />

<p>
    название товара: <b><?php echo $feedback->productName;?></b>
</p>

<p>
    артикул товара: <b><?php echo $feedback->artikul;?></b>
</p>

<p>
    производитель товара: <b><?php echo $feedback->manufacturer;?></b>
</p>

<p>
    количество товара: <b><?php echo $feedback->productCount;?></b>
</p>