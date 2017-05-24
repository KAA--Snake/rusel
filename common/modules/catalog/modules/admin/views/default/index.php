<?php
use yii\grid\GridView;
?>


<?php


echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        'id',
        'depth_level',
        'parent_id',
        'name',
        'code',
        /*'id',
        'parent_id',
        'name:ntext',
        'url:ntext',
        'category_image:ntext',
        // 'created_at',
        // 'updated_at',*/

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>