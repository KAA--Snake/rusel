<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 12.04.2017
 * Time: 12:03
 */

use yii\helpers\Html;
use yii\helpers\Url;


echo 'Поброс: ' . $newVar . PHP_EOL;
?>
<hr>
<?
foreach($posts as $onePost){?>

    <?= Html::tag('a', Html::encode($onePost->NAME), [
        'class' => 'myhrefclass',
        'href' => Url::to(['post/show', 'id'=>$onePost->ID]),
    ])?>

<?
    //echo '<pre>';
    //print_r($onePost->sections);
    //echo '</pre>';
}

echo \yii\widgets\LinkPager::widget(['pagination' => $pages]);
