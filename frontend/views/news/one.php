<?php
/**
 *  Все данные по новости тут: $model
 *  Все данные по списку новостей тут: $models
 *
 */

use yii\helpers\Url;
use common\widgets\catalog\CatalogMenu;
use common\widgets\search\WSearch;

$this->title = 'RUSEL24 - ' . $model['name'];
?>
<div class="content_wrap mw1180">


    <div class="content_inner_wrap left0 col_1180 in_news_list">

        <h1>Новости</h1>

        <div class="in_news_item">
            <div class="in_news_item_head">
                <h2><?=$model['name']?></h2>
                <span class="in_news_item_date"><?=$model['date']?></span>
            </div>

            <div class="in_news_item_content">
                <div class="in_news_item_img">
                    <img src="<?=$model['small_img_src']?>" alt="">
                </div>
                <div class="in_news_item_text">
                    <p>
                        <?=$model['full_text']?>
                    </p>
                </div>
            </div>
        </div>

        <?php
        /*echo 'это выбранная новость';*/
        /*\Yii::$app->pr->print_r2($model->getAttributes());*/

        /*echo 'здесь список остальных новостей';*/
        foreach($models as $oneModel){

        ?>
            <div class="in_news_item">
                <div class="in_news_item_head">
                    <h2><?=$oneModel['name']?></h2>
                    <span class="in_news_item_date"><?=$oneModel['date']?></span>
                </div>

                <div class="in_news_item_content">
                    <div class="in_news_item_img">
                        <img src="<?=$oneModel['small_img_src']?>" alt="">
                    </div>
                    <div class="in_news_item_text">
                        <p>
                            <?=$oneModel['preview_text']?>
                        </p>
                        <a href="/sitenews/<?=$oneModel['url']?>/" class="in_news_item_more">Подробнее  →</a>
                    </div>
                </div>
            </div>
            <?/*\Yii::$app->pr->print_r2($oneModel->getAttributes());*/
        }
        ?>
    </div>


</div>



