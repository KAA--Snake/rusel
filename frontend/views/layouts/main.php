<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" type="image/ico" href="/img/favicon.ico"/>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=1200px, initial-scale=0.0">
    <meta name="format-detection" content="telephone=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<!-- Excitel {call button} -->
<script type="text/javascript">
    //<![CDATA[
    (function(){var widget=document.createElement('script');widget.type='text/javascript';widget.async=true;widget.src='//excitel.net/widget-0d05ef9d93eb7cea8a104d6cefcbbee8.js';document.getElementsByTagName('head')[0].appendChild(widget);})();
    //]]>
</script>
<!-- Excitel {/call button} -->
<body>
<?php $this->beginBody() ?>

<div class="popup_container recall hidden">
    <div class="flex_wrap">
        <div class="popup recall-popup">
            <div class="close js-recall_popup_close"></div>
            <div class="phone">
                <span class="phone-ico"></span>
                <span class="phone-num">8 (495) 066-42-14</span>
            </div>
            <div class="divider"></div>
            <div class="button_wrap">
                <div class="popup-button call_from_site">Позвонить с сайта</div>
            </div>
            <div class="divider__wide"></div>
            <div class="popup-header">Обратный звонок</div>
            <div class="divider"></div>
            <form action="" class="popup-form">
                <input name="name" type="text" placeholder="Введите ваше ФИО" class="popup-input name_input">
                <input name="phone" type="text" placeholder="Введите Ваш телефон" class="popup-input phone_input">
                <textarea name="comment" id="" cols="30" rows="10" placeholder="Примечание к звонку" class="popup-input textarea comment" ></textarea>
                <div class="recaptcha"></div>
                <input type="submit" class="popup-button" value="Заказать">
            </form>
        </div>
    </div>


    <div class="overlay"></div>
</div>

<div class="wrap">

    <?php
/*    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    */?>

    <div class="container main">

        <? echo \Yii::$app->view->renderFile('@app/views/includes/layout_v1/header.php');?>

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <? echo \Yii::$app->view->renderFile('@app/views/includes/layout_v1/footer.php');?>
</footer>

<?php $this->endBody() ?>

<!-- Begin Verbox {literal} -->
<script type='text/javascript'>
    (function(d, w, m) {
        window.supportAPIMethod = m;
        var s = d.createElement('script');
        s.type ='text/javascript'; s.id = 'supportScript'; s.charset = 'utf-8';
        s.async = true;
        var id = 'dc7f65b34bd184272c5f34d362dac85c';
        s.src = 'https://admin.verbox.ru/support/support.js?h='+id;
        var sc = d.getElementsByTagName('script')[0];
        w[m] = w[m] || function() { (w[m].q = w[m].q || []).push(arguments); };
        if (sc) sc.parentNode.insertBefore(s, sc);
        else d.documentElement.firstChild.appendChild(s);
    })(document, window, 'Verbox');
</script>
<!-- {/literal} End Verbox -->
</body>
</html>
<?php $this->endPage() ?>
