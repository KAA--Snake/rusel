<?php

use yii\helpers\Url;
use common\modules\catalog\models\Section;
?>


<div class="product_cards_block _order">
    <h1>Форма запроса</h1>

    <div class="_order_section _selected_products">
        <h2>Выбранные наименования</h2>

        <div class="product_card product_card_inner js-tab_collapsed">
            <div class="card_part name">
                <div class="model">
                    <a href="">DF-0394 HJ75</a>
                </div>
                <div class="firm_name">
                    <a href="">Bionic</a>
                </div>
                <div class="firm_descr">
                    Оборудование для плат
                </div>
                <div class="more js-expand-tabs">
                    <a href="">Подробнее ↓</a>
                </div>
            </div>

            <div class="card_part img">
                <img src="<?= Url::to('@web/img/card_img.png'); ?>" alt="">
            </div>

            <div class="card_part in_stock">
                <div class="in_stock_item available">Доступно: <span class="avilable_count">123 шт. (1-2 дня)</span>
                </div>
                <div class="in_stock_item preorder">Сверх доступного: <span class="preorder_count">4-5 недель</span>
                </div>
                <br>
                <div class="in_stock_item pack">Упаковка: <span class="pack_count">50 шт</span></div>
                <div class="in_stock_item minorder">Мин.заказ: <span class="minorder_count">100 шт</span>
                </div>
            </div>
            <div class="card_part prices">
                <div class="special_tape">Специальная цена</div>
                <div class="price_vars">
                    <div class="price_var_item clear">
                        <span class="count fll">1+</span>
                        <span class="price flr">100.00 &#8381;/шт</span>
                    </div>
                    <div class="price_var_item clear">
                        <span class="count fll">1+</span>
                        <span class="price flr">100.00 &#8381;/шт</span>
                    </div>
                    <div class="price_var_item clear">
                        <span class="count fll">1+</span>
                        <span class="price flr">100.00 Р/шт</span>
                    </div>
                </div>
            </div>
            <div class="card_part order">
                <input type="text" class="order_input" placeholder="Введите количество">

                <div class="ordered_input hidden">
                    <span class="ordered_icon"></span>
                    <span class="ordered_count">25 000 шт.</span>
                    <span class="ordered_price">252 000 Р.</span>
                </div>

                <div class="ordered_btn add">Добавить в запрос</div>
            </div>
            <div class="product_card_more collapsed">
                <div class="product_tab">
                    <ul class="product_specs_list">
                        <li class="product_tab_item"><a href="#params">Параметры</a></li>
                        <li class="product_tab_item"><a href="#techdoc">Техническая документация</a></li>
                        <li class="product_tab_item"><a href="#appurtenant">Принадлежности</a></li>
                    </ul>
                    <div class="product_tab_content" id="params">
                        <table class="params_tab">
                            <tr>
                                <td class="param_name">Серия</td>
                                <td class="param_value">-</td>
                            </tr>
                            <tr>
                                <td class="param_name">Номинальная емкость, мкФ</td>
                                <td class="param_value">100</td>
                            </tr>
                            <tr>
                                <td class="param_name">Рабочее напряжение, В</td>
                                <td class="param_value">50</td>
                            </tr>
                            <tr>
                                <td class="param_name">Допуск номинальной емкости,%</td>
                                <td class="param_value">20</td>
                            </tr>
                            <tr>
                                <td class="param_name">Рабочая температура,С</td>
                                <td class="param_value">-40...105</td>
                            </tr>
                            <tr>
                                <td class="param_name">Тангенс угла потерь,%</td>
                                <td class="param_value">-</td>
                            </tr>
                            <tr>
                                <td class="param_name">Ток утечки макс.,мкА</td>
                                <td class="param_value">-</td>
                            </tr>
                            <tr>
                                <td class="param_name">Выводы/корпус</td>
                                <td class="param_value">string</td>
                            </tr>
                            <tr>
                                <td class="param_name">Диаметр корпуса 0,мм</td>
                                <td class="param_value">10</td>
                            </tr>
                            <tr>
                                <td class="param_name">Длина корпуса 1_,мм</td>
                                <td class="param_value">12.5</td>
                            </tr>
                            <tr>
                                <td class="param_name">Особенности</td>
                                <td class="param_value">-</td>
                            </tr>
                            <tr>
                                <td class="param_name">Производитель/td>
                                <td class="param_value">Panasonic</td>
                            </tr>
                        </table>
                    </div>
                    <div class="product_tab_content" id="techdoc">
                        <p>
                            какая то Техническая документация
                        </p>

                    </div>
                    <div class="product_tab_content" id="appurtenant">
                        <p>
                            какие то Принадлежности
                        </p>
                    </div>
                </div>
                <div class="hide_tabs_wrap">
                    <div class="hide_tabs_btn">Свернуть</div>
                </div>
            </div>
        </div>

        <div class="product_card product_card_inner js-tab_collapsed">
            <div class="card_part name">
                <div class="model">
                    <a href="">DF-0394 HJ75</a>
                </div>
                <div class="firm_name">
                    <a href="">Bionic</a>
                </div>
                <div class="firm_descr">
                    Оборудование для плат
                </div>
                <div class="more js-expand-tabs">
                    <a href="">Подробнее ↓</a>
                </div>
            </div>

            <div class="card_part img">
                <img src="<?= Url::to('@web/img/card_img.png'); ?>" alt="">
            </div>

            <div class="card_part in_stock">
                <div class="in_stock_item available">Доступно: <span class="avilable_count">123 шт. (1-2 дня)</span>
                </div>
                <div class="in_stock_item preorder">Сверх доступного: <span class="preorder_count">4-5 недель</span>
                </div>
                <br>
                <div class="in_stock_item pack">Упаковка: <span class="pack_count">50 шт</span></div>
                <div class="in_stock_item minorder">Мин.заказ: <span class="minorder_count">100 шт</span>
                </div>
            </div>
            <div class="card_part prices">
                <div class="special_tape">Специальная цена</div>
                <div class="price_vars">
                    <div class="price_var_item clear">
                        <span class="count fll">1+</span>
                        <span class="price flr">100.00 &#8381;/шт</span>
                    </div>
                    <div class="price_var_item clear">
                        <span class="count fll">1+</span>
                        <span class="price flr">100.00 &#8381;/шт</span>
                    </div>
                    <div class="price_var_item clear">
                        <span class="count fll">1+</span>
                        <span class="price flr">100.00 Р/шт</span>
                    </div>
                </div>
            </div>
            <div class="card_part order">
                <input type="text" class="order_input" placeholder="Введите количество">

                <div class="ordered_input hidden">
                    <span class="ordered_icon"></span>
                    <span class="ordered_count">25 000 шт.</span>
                    <span class="ordered_price">252 000 Р.</span>
                </div>

                <div class="ordered_btn add">Добавить в запрос</div>
            </div>
            <div class="product_card_more collapsed">
                <div class="product_tab">
                    <ul class="product_specs_list">
                        <li class="product_tab_item"><a href="#params">Параметры</a></li>
                        <li class="product_tab_item"><a href="#techdoc">Техническая документация</a></li>
                        <li class="product_tab_item"><a href="#appurtenant">Принадлежности</a></li>
                    </ul>
                    <div class="product_tab_content" id="params">
                        <table class="params_tab">
                            <tr>
                                <td class="param_name">Серия</td>
                                <td class="param_value">-</td>
                            </tr>
                            <tr>
                                <td class="param_name">Номинальная емкость, мкФ</td>
                                <td class="param_value">100</td>
                            </tr>
                            <tr>
                                <td class="param_name">Рабочее напряжение, В</td>
                                <td class="param_value">50</td>
                            </tr>
                            <tr>
                                <td class="param_name">Допуск номинальной емкости,%</td>
                                <td class="param_value">20</td>
                            </tr>
                            <tr>
                                <td class="param_name">Рабочая температура,С</td>
                                <td class="param_value">-40...105</td>
                            </tr>
                            <tr>
                                <td class="param_name">Тангенс угла потерь,%</td>
                                <td class="param_value">-</td>
                            </tr>
                            <tr>
                                <td class="param_name">Ток утечки макс.,мкА</td>
                                <td class="param_value">-</td>
                            </tr>
                            <tr>
                                <td class="param_name">Выводы/корпус</td>
                                <td class="param_value">string</td>
                            </tr>
                            <tr>
                                <td class="param_name">Диаметр корпуса 0,мм</td>
                                <td class="param_value">10</td>
                            </tr>
                            <tr>
                                <td class="param_name">Длина корпуса 1_,мм</td>
                                <td class="param_value">12.5</td>
                            </tr>
                            <tr>
                                <td class="param_name">Особенности</td>
                                <td class="param_value">-</td>
                            </tr>
                            <tr>
                                <td class="param_name">Производитель/td>
                                <td class="param_value">Panasonic</td>
                            </tr>
                        </table>
                    </div>
                    <div class="product_tab_content" id="techdoc">
                        <p>
                            какая то Техническая документация
                        </p>

                    </div>
                    <div class="product_tab_content" id="appurtenant">
                        <p>
                            какие то Принадлежности
                        </p>
                    </div>
                </div>
                <div class="hide_tabs_wrap">
                    <div class="hide_tabs_btn">Свернуть</div>
                </div>
            </div>
        </div>
    </div>

    <div class="_order_section _summary">
        Итого по выбранным наименованиям: <span class="sum_amount bold">000,00 руб</span>
    </div>

    <form action="" name="order_request_form" id="order_request_form" class="order_request_form">
        <div class="_order_section _order_answer_vars">
            <h2>Варианты ответа на запрос</h2>

            <input type="radio" id="var1" name="answer_var" class="radio_btn" value="">
            <label for="var1">Коммерческое предложение</label>

            <input type="radio" id="var2" name="answer_var" class="radio_btn" value="">
            <label for="var2">Счет на оплату (потребуются данные организации)</label>
        </div>

        <div class="_order_section _contact_info">
            <h2>Контактная информация</h2>

            <label for="fio">ФИО:</label>
            <input type="text" id="fio" name="fio" class="_order_inp">

            <label for="tel">Телефон:</label>
            <input type="text" id="tel" name="tel" class="_order_inp">

            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" class="_order_inp">

            <label for="org">Организация или ИП:</label>
            <input type="text" id="org" name="org" class="_order_inp">
            <div class="org_tooltip"><span class="org_tooltip_arrow"></span>Введите название, ИНН или адрес</div>
        </div>

        <div class="_order_section _delivery_terms">
            <h2>Требуемые условия поставки</h2>

            <input type="radio" id="delivery_var1" name="delivery_var" class="radio_btn" value="">
            <label for="var1">Самовывоз с пункта выдачи заказов (бесплатная услуга)
                <span class="address">Адрес:
                    <a href=""><span class="addres_icon"></span> ул. Пушкина 24, дом 254, офис 25</a>
                </span>
            </label>

            <input type="radio" id="delivery_var2" name="delivery_var" class="radio_btn" value="">
            <label for="var2">Доставка транспортной компанией до терминала в ближайшем городе покупателя (платная услуга, дополнительно оплачивается покупателем заказа)
                <a href="">Тарифы</a>
            </label>

            <input type="radio" id="delivery_var3" name="delivery_var" class="radio_btn" value="">
            <label for="var2">Доставка транспортной компанией до «двери» покупателя (платная услуга, дополнительно оплачивается получателем заказа)
                <a href="">Тарифы</a>
            </label>

            <div class="address_subheader">
                Адрес грузополучателя:
            </div>

            <label for="delivery_city">Выбрать город</label>
            <select name="delivery_city" id="delivery_city">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <label for="delivery_contact_person">Контактное лицо:</label>
            <input type="text" id="delivery_contact_person" name="delivery_contact_person" class="_order_inp">

            <label for="delivery_tel">Телефон для связи:</label>
            <input type="text" id="delivery_tel" name="delivery_tel" class="_order_inp">

            <label for="delivery_address">Телефон для связи:</label>
            <input type="text" id="delivery_address" name="delivery_address" class="_order_inp">

        </div>

        <div class="_order_section _comment">
            <h2>Примечание к запросу</h2>
            <label for="order_comment">Текст примечания:</label>
            <textarea name="order_comment" id="order_comment" cols="30" rows="10"></textarea>
        </div>

    </form>
</div>