<?php
/**
 *  Все данные по новости тут: $model
 *  Все данные по списку новостей тут: $models
 *
 */


//это выбранная новость
\Yii::$app->pr->print_r2($model->getAttributes());

//здесь список остальных новостей
foreach($models as $oneModel){
    \Yii::$app->pr->print_r2($oneModel->getAttributes());
}


