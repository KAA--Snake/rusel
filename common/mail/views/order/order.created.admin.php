<?php

/** @var $this \yii\web\View */
/** @var $link string */
/** @var $paramExample string */

$products = (array) json_decode($order->getAttributes()['products']);

?>

Запрос № <?=$order->id;?>
<br>
Дата: <?=$order->date;?>
<br>
Время: <?=$order->time;?>
<br>
Источник: <?=$order->source;?>
<br>
ФИО: <?=$order->fio;?>
<br>
Телефон: <?=$order->tel;?>
<br>
EMAIL: <?=$order->email;?>
<br>
Организация: <?=$order->org;?>
<br>
Краткое наименование контрагента: <?=$order->client_shortname;?>
<br>
Полное наименование организации: <?=$order->client_fullname;?>
<br>
Адрес: <?=$order->client_address;?>
<br>
ИНН: <?=$order->client_inn;?>
<br>
КПП: <?=$order->client_kpp;?>
<br>
Вариант ответа на запрос: <?=$order->answer_var;?>
<br>
Требуемые условия поставки: <?=$order->delivery_var;?>
<br>
Город доставки: <?=$order->delivery_city;?>
<br>
Точный адрес для доставки «до двери»: <?=$order->delivery_address;?>
<br>
Текст примечания: <?=$order->order_comment;?>
<br>
<br>
<br>
<br>

Запрошенные наименования:
<br>
<br>
<? foreach($products as $k=>$oneProduct){?>

    <hr>
    <br>
    Артикул: <?=$oneProduct->productData->artikul;?>
    <br>
    Описание: <?=$oneProduct->productData->name;?>
    <br>
    Производитель: <?=$oneProduct->productData->properties->proizvoditel;?>
    <br>
    Кол-во: <?=$oneProduct->count;?>
    <br>
    Цена: <?=$oneProduct->price;?>
    <br>
    Валюта: <?=$oneProduct->currency;?>
    <br>
    <?

    $summ = (float)$oneProduct->price * (float)$oneProduct->count;
    $summ = number_format ($summ, 2, ".", "");
    ?>

    Сумма: <?=$summ;?>
    <br>
<?}?>



