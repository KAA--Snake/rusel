<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\catalog\models\Section */

$this->title = 'Create Section';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
