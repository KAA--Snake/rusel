<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <?php if($exception->statusCode == '404') { $this->title = "Страница не существует !"; ?>
        <p>Упс, а такой страницы пока еще нет...</p>
        <div>
            <a href="/">Перейти на главную</a>
            <?php // рендерим картинку ? = $this->render('/layouts/something') ?>
        </div>
    <?php } else { ?>
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?php echo nl2br(Html::encode($message)); ?>
        </div>
        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>
    <?php } ?>
</div>