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
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">

    <? echo \Yii::$app->view->renderFile('@app/views/includes/layout_v1/footer.php');?>
    <?/* этот блок перенесен в frontend/views/includes/layout_v1/footer.php и его можно отсюда теперь удалить ?>
    <div class="mw1180 clear">
        <div class="footer-left fll">© <?= date('Y') ?> ООО"РУСЭЛ24" Все права защищены.</div>

        <div class="footer-right flr">
            <div class="contact_block">
                <div class="contact_item phone">
                    <div class="icon">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 35 35" enable-background="new 0 0 35 35" xml:space="preserve">
<path d="M7.2,23.2c3.4,4.1,7.6,7.3,12.3,9.6c1.8,0.8,4.2,1.9,6.9,2c0.2,0,0.3,0,0.5,0c1.8,0,3.2-0.6,4.4-1.9c0,0,0,0,0,0
	c0.4-0.5,0.9-1,1.4-1.4c0.3-0.3,0.7-0.7,1-1c1.5-1.6,1.5-3.6,0-5.2L29.3,21c-0.7-0.8-1.6-1.2-2.5-1.2c-0.9,0-1.8,0.4-2.6,1.2
	l-2.6,2.6c-0.2-0.1-0.5-0.3-0.7-0.4c-0.3-0.1-0.6-0.3-0.8-0.4c-2.3-1.5-4.5-3.4-6.5-5.9c-1-1.3-1.7-2.4-2.2-3.5
	c0.7-0.6,1.3-1.2,1.9-1.9c0.2-0.2,0.4-0.4,0.7-0.7c0.8-0.8,1.2-1.7,1.2-2.6S14.8,6.4,14,5.6l-2.1-2.1c-0.3-0.3-0.5-0.5-0.7-0.7
	c-0.5-0.5-1-1-1.5-1.4C8.9,0.5,8,0.2,7.1,0.2c-0.9,0-1.8,0.4-2.6,1.1L1.9,4c-1,1-1.5,2.2-1.6,3.5c-0.1,1.7,0.2,3.5,1,5.7
	C2.5,16.7,4.4,19.8,7.2,23.2z M2,7.7c0.1-1,0.5-1.8,1.1-2.4l2.7-2.7c0.4-0.4,0.9-0.6,1.3-0.6c0.4,0,0.9,0.2,1.3,0.6
	C8.9,3,9.4,3.5,9.8,4c0.2,0.3,0.5,0.5,0.7,0.8l2.1,2.1c0.4,0.4,0.7,0.9,0.7,1.3c0,0.4-0.2,0.9-0.7,1.3c-0.2,0.2-0.4,0.5-0.7,0.7
	c-0.7,0.7-1.3,1.3-2,1.9c0,0,0,0,0,0c-0.6,0.6-0.5,1.2-0.4,1.6c0,0,0,0,0,0.1c0.6,1.3,1.3,2.6,2.5,4.1c2.2,2.7,4.4,4.7,6.9,6.3
	c0.3,0.2,0.6,0.4,1,0.5c0.3,0.1,0.6,0.3,0.8,0.4c0,0,0.1,0,0.1,0c0.2,0.1,0.5,0.2,0.7,0.2c0.6,0,1-0.4,1.1-0.5l2.7-2.7
	c0.4-0.4,0.9-0.6,1.3-0.6c0.5,0,1,0.3,1.3,0.6l4.3,4.3c0.9,0.9,0.9,1.8,0,2.7c-0.3,0.3-0.6,0.6-1,1c-0.5,0.5-1,1-1.5,1.6
	c-0.8,0.9-1.8,1.3-3.1,1.3c-0.1,0-0.3,0-0.4,0c-2.4-0.2-4.6-1.1-6.2-1.9c-4.5-2.2-8.4-5.2-11.7-9.1c-2.7-3.2-4.5-6.2-5.7-9.4
	C2.1,10.7,1.9,9.1,2,7.7z"/>
</svg>
                    </div>
                    <div class="contact">
                        <div class="top">8 (495) 066-42-14</div>
                        <div class="bottom js-recall_popup_trigger">Обратный звонок</div>
                    </div>
                </div>
                <div class="contact_item mail">
                    <div class="icon">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 35 35" enable-background="new 0 0 35 35" xml:space="preserve">
                            <path fill="#336699" d="M0,6.6v21.8h35V6.6H0z M32.1,8.1L17.5,19.9L2.9,8.1H32.1z M1.5,26.9v-18l16,12.9l16-12.9v18L1.5,26.9 L1.5,26.9z"/>
                        </svg>
                    </div>
                    <div class="contact">
                        <div class="top">zapros@rusel24.ru</div>
                        <div class="bottom">Отправить письмо</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?*/?>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
