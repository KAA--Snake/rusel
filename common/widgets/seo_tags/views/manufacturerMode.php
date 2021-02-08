<?php
/**
 * Created by Sergio Solomonov
 * User: user
 * Date: 08.02.21
 * Time: 12:09
 */
use yii\helpers\Url;
use yii\helpers\Html;

/** @var \common\modules\catalog\models\Manufacturer $manufacturer */
$manufacturer = $model['seo']['manufacturer'];

//\Yii::$app->pr->print_r($model);
//\Yii::$app->pr->print_r2($manufacturer->getAttributes());
$image = "http://rusel24.ru/upload/artikles/{$manufacturer->m_id}.jpg";
?>


<meta property="og:title" content="<?= Html::encode($model['title']); ?>">
<meta property="og:description" content="<?= Html::encode($model['description']); ?>">
<meta property="og:site_name" content="rusel24.ru">
<meta property="og:type" content="website">
<meta property="og:image" content="<?= Html::encode($image); ?>">

