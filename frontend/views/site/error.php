<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\catalog\CatalogMenu;
use common\widgets\search\WSearch;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="content_wrap mw1180">

    <?php if($exception->statusCode == '404') { $this->title = "Страница не существует !"; ?>


            <div class="col_220 fll">

                <div class="supply_program">
                    <? echo $this->render('@app/views/includes/manufacturers_fullwidth.php', [
                        'manufacturers' => $this->params['manufacturers'],
                    ]);?>
                </div>

            </div>


            <div class="content_top col_940">

                <?=CatalogMenu::widget(['maket' => 'menu_full_width']);?>


                <?=WSearch::widget();?>

            </div>


        <div class="content_inner_wrap left0 col_1180 page_404">
            <div class="img_404">
                <img src="/img/404.png" alt="">
            </div>
            <div class="txt_404">
                <h1>Страница не найдена!</h1>
                <p>Извините, но страница, которую вы ищете, не найдена.</p>
                <a href="/" class="blue_btn">Вернуться на главную</a>
            </div>
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