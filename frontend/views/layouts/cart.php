<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\widgets\catalog\CatalogMenu;
use common\widgets\search\WSearch;


$catalogParentLink = '';
if(count($this->params['breadcrumbs']) > 0){
    foreach($this->params['breadcrumbs'] as $bCrumb){
        if(isset($bCrumb['finalItem'])){
            if($bCrumb['finalItem'] == true){
                $catalogParentLink = '<link rel="parent" href="http://rusel24.ru'.$bCrumb['url'].'">';
            }
        }
    }
}

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <link rel="canonical" href="<?= Yii::$app->request->absoluteUrl;?>">
    <?=$catalogParentLink;?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="yandex-verification" content="eec399b374c34790" />
    <meta name="viewport" content="width=1200px, initial-scale=0.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter49726129 = new Ya.Metrika2({
                    id:49726129,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/49726129" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

<!-- Global site tag (gtag.js) - Google Analytics -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126173792-1"></script>

<script>

    window.dataLayer = window.dataLayer || [];

    function gtag(){dataLayer.push(arguments);}

    gtag('js', new Date());

    gtag('config', 'UA-126173792-1');

</script>


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
                <textarea name="comment" id="" cols="30" rows="10" placeholder="Примечание к звонку"
                          class="popup-input textarea comment"></textarea>
                <div class="recaptcha"></div>
                <input type="submit" class="popup-button" value="Заказать">
            </form>
        </div>
    </div>


    <div class="overlay"></div>
</div>

<div class="wrap">
    <div class="container main">

        <? echo \Yii::$app->view->renderFile('@app/views/includes/layout_v1/header.php');?>

        <div class="content_wrap mw1180">

            <div class="col_220 fll">

                <div class="supply_program">
                    <? echo $this->render('@app/views/includes/manufacturers_fullwidth.php', [
                        'manufacturers' => $this->params['manufacturers'],
                    ]);?>
                </div>

            </div>


            <div class="content_top col_940">
	            <?=CatalogMenu::widget();?>

                <?=WSearch::widget();?>

            </div>

            <div class="breadcrumbs_menu col_1180">
                <?/*?>
                <ul class="breadcrumbs_list">
                    <li class="breadcrumbs_item breadcrumbs_head">Каталог:</li>
                    <li class="breadcrumbs_item">
                        <a href="">Измерительные приборы</a>
                        <span class="arrow_next">→</span>
                    </li>
                    <li class="breadcrumbs_item">
                        <a href="">Комутационная апаратура</a>
                        <span class="arrow_next">→</span>
                    </li>
                    <li class="breadcrumbs_item">
                        <a href="">Пружинные проходные клеммы</a>
                        <span class="arrow_next">→</span>
                    </li>
                    <li class="breadcrumbs_item current">
                        DF-0394 HJ75
                    </li>
                </ul>
                <?*/?>
                <?= Breadcrumbs::widget([
                    'options'       =>  [
                        //'id'        =>  'breadCrumbs',
                        'class'        =>  'breadcrumbs_list',
                    ],
                    'homeLink' => ['label' => 'Каталог:'],
                    'itemTemplate' => "<li class='breadcrumbs_item breadcrumbs_head'>{link}</li>", // template for all links
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);?>
            </div>


            <div class="content_inner_wrap left0 col_1180">


                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

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
            */ ?>


    </div>
</div>

<footer class="footer">
    <? echo \Yii::$app->view->renderFile('@app/views/includes/layout_v1/footer.php');?>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>