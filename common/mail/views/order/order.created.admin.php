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
Индекс города: <?=$order->delivery_city_index;?>
<br>
Контактное лицо: <?=$order->delivery_contact_person;?>
<br>
Телефон для связи: <?=$order->delivery_tel;?>
<br>
Точный адрес для доставки «до двери»: <?=$order->delivery_address;?>
<br>
Время доставки: <?=$order->delivery_time;?>
<br>
Текст примечания: <?=$order->order_comment;?>
<br>
ИД клиента: <?=$order->client_id;?>
<br>
IP клиента: <?=$order->client_ip;?>
<br>
Геолокация: <?=$order->client_geolocation;?>
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
    Артикул: <?=$oneProduct->artikul;?>
    <br>
    Описание: <?=$oneProduct->_source->name;?>
    <br>
    Производитель: <?=$oneProduct->_source->properties->proizvoditel;?>
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



