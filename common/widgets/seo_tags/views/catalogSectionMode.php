<?php
/**
 * Created by Sergio Solomonov
 * User: user
 * Date: 08.02.21
 * Time: 12:09
 */
use yii\helpers\Url;
use yii\helpers\Html;

//\Yii::$app->pr->print_r2($model);

?>


<meta property="og:title" content="<?= Html::encode($model['title']); ?>">
<meta property="og:description" content="<?= Html::encode($model['description']); ?>">
<meta property="og:site_name" content="rusel24.ru">
<meta property="og:type" content="website">
<meta property="og:image" content="<?= Html::encode($defaultImage); ?>">

