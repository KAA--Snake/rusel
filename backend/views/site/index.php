<?php

/* @var $this yii\web\View */

$this->title = 'admin main page';
?>


<div class="inner_wrap mw1180">
    <h1 class="header_h1">Админка</h1>
    <div class="dashboard">
        <div class="dashboard_section">
            <h3 class="dashboard_section-header">Главная страница</h3>
            <div class="dashboard_section-body">
                <a class="dashboard_section-link" href="/admin/slider">Слайдер</a>
                <a class="dashboard_section-link" href="/admin/offers">Специальные предложения</a>
                <a class="dashboard_section-link" href="/admin/info">Полезная информация</a>
                <a class="dashboard_section-link" href="/admin/news">Новости</a>
                <a class="dashboard_section-link" href="/admin/static/seo_text">СЕО текст в карточке товара</a>
            </div>
        </div>

        <div class="dashboard_section">
            <h3 class="dashboard_section-header">Верхние статические страницы</h3>
            <div class="dashboard_section-body">
                <a class="dashboard_section-link" href="/admin/static/about">О проекте</a>
                <a class="dashboard_section-link" href="/admin/static/delivery">Оплата и доставка</a>
                <a class="dashboard_section-link" href="/admin/static/documents">Договор оферты</a>
                <a class="dashboard_section-link" href="/admin/static/cooperation">Сотрудничество</a>
                <a class="dashboard_section-link" href="/admin/static/vacancies">Вакансии</a>
                <a class="dashboard_section-link" href="/admin/static/contacts">Контакты</a>
                <a class="dashboard_section-link" href="/admin/static/zamery_parametrov_elektroseti">Замеры параметров электросети</a>
            </div>
        </div>
    </div>
</div>

