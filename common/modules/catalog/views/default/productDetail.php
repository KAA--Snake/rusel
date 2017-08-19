<?php

    use yii\helpers\Url;

    //здесь выводится все по товару
    \Yii::$app->pr->print_r2($product['properties']['preview_text']);
    print_r($product['properties']);

    $product_proizvoditel = $product['properties']['proizvoditel'];
    ?>

    <div class="product_cards_block _detail">

        <div class="product_card js-tab_collapsed">
            <div class="card_part name">
                <div class="model">
                    <a href="">DF-0394 HJ75</a>
                </div>
                <div class="firm_name">
                    <a href=""><?=$product_proizvoditel;?></a>
                </div>
                <div class="firm_descr">
                    Оборудование для плат
                </div>
            </div>

            <div class="card_part img">
                <img src="<?= Url::to('@web/img/card_img.png'); ?>" alt="">
            </div>

            <div class="card_part in_stock">
                <div class="in_stock_item available">Доступно: <span class="avilable_count">123 шт. (1-2 дня)</span></div>
                <div class="in_stock_item preorder">Сверх доступного: <span class="preorder_count">4-5 недель</span></div>
                <br>
                <div class="in_stock_item pack">Упаковка: <span class="pack_count">50 шт</span></div>
                <div class="in_stock_item minorder">Мин.заказ: <span class="minorder_count">100 шт</span></div>
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
                    <span class="ordered_price">сумма: 252 000 Р.</span>
                </div>

                <div class="ordered_btn add">Добавить в запрос</div>
            </div>

        </div>

        <div class="_detail_section product_params">
            <h2>Параметры</h2>
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

        <div class="_detail_section tech_docs">
            <h2>Техническая документация</h2>
            <ul class="docs_list">
                <li class="docs_item pdf">
                    <a class="docs_file_link " href="">Инструкция.pdf</a>
                </li>
            </ul>
        </div>

        <div class="_detail_section _appurtenants">
            <h2>Принадлежности</h2>

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
        </div>
