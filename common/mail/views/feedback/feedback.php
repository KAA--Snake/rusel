<?php

/** @var $this \yii\web\View */
/** @var $feedback \common\modules\catalog\models\FeedBack */

?>

<p>
  Отправлена форма с сайта
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
    Текст: <b><?php echo $feedback->text;?></b>
</p>

<p>
    Приложенный файл: <?php echo $feedback->fileUrl;?>
</p>

<p>
    Данные по товару:
</p>

<br />

<p>
    артикул товара:
</p>

<p>
    название товара:
</p>

<p>
    производитель товара:
</p>

<p>
    картинка товара:
</p>

<p>
    количество товара:
</p>