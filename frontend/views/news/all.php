<?php
/**
 *  Все данные по списку новостей тут: $models
 *
 */

//здесь список остальных новостей
foreach($models as $oneModel){
    \Yii::$app->pr->print_r2($oneModel->getAttributes());
}


