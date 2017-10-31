<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\catalog\models\Manufacturer */

$this->title = 'Update Section: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Manufacturer', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->m_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="section-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
