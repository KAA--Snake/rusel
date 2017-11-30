<?php

/** @var $this \yii\web\View */
/** @var $link string */
/** @var $paramExample string */

?>
<p>Текст письма по заказу для админа</p>

<p>Данные по заказу: </p>

<p>ФИО: <?=$order->fio;?></p>
<p>Телефон: <?=$order->tel;?></p>
<p>EMAIL: <?=$order->email;?></p>
<p>Организация: <?=$order->org;?></p>
<p>Адрес: <?=$order->client_address;?></p>
<p>ВАРИАНТЫ ОТВЕТА НА ЗАПРОС: <?=$order->answer_var;?></p>

<p>ТРЕБУЕМЫЕ УСЛОВИЯ ПОСТАВКИ: <?=$order->delivery_var;?></p>

<p>Город доставки: <?=$order->delivery_city;?></p>
<p>Индекс города: <?=$order->delivery_city_index;?></p>

<p>Контактное лицо: <?=$order->delivery_contact_person;?></p>
<p>Телефон для связи: <?=$order->delivery_tel;?></p>
<p>Точный адрес для доставки «до двери»: <?=$order->delivery_address;?></p>
<p>Время доставки: <?=$order->delivery_time;?></p>
<p>Текст примечания: <?=$order->order_comment;?></p>

<p>ИД клиента: <?=$order->client_id;?></p>
<p>IP клиента: <?=$order->client_ip;?></p>
<p>Геолокация: <?=$order->client_geolocation;?></p>

<p>Краткое наименование организации: <?=$order->client_shortname;?></p>
<p>Полное наименование организации: <?=$order->client_fullname;?></p>

<p>ИНН: <?=$order->client_inn;?></p>
<p>КПП: <?=$order->client_kpp;?></p>

<p>Дата заказа: <?=$order->date;?></p>
<p>Время заказа: <?=$order->time;?></p>

<p>Источник: <?=$order->source;?></p>
