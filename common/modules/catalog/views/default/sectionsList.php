<?php
use yii\helpers\Url;

/**
 *  Это view для вывода раздела / списка подразделов каталога
 */

/**
 *  Все объекты описаны нотациями.
 * (пример нотации - @var \common\modules\catalog\models\Section $oneSibling)
 *
 *  И в шторме поэтому можешь смотреть подсказки при ctrl+space на этих переменных.
 *  Главное не удаляй нотации для переменных, чтобы не пропадало автозаполнение шторма.
 *
 */


/**
 * У каждого подраздела есть свойство - childs
 * В нем находятся подразделы
 * Оно рекурсивное, т.е. $oneSibling->childs->childs->childs .... и так пока не закончатся все под-под-под разделы.
 *
 * В цикле по подразделам ниже (foreach $groupedSiblings) я взял только ПЕРВЫЙ уровень подразделов ,
 * т.е. сделал цикл по $oneSibling->childs (см ниже в примере)
 *
 * НО ты можешь делать подциклы по ним и дальше
 * (только проверяй на существование if(isset($oneChild->childs)),
 * в зависимости от того сколько подуровней
 * захочешь выводить по дизайн макету и ТЗ
 */

//вот список доступных переменных:
/** @var \common\modules\catalog\models\Section     $currentSection - текущий выбранный раздел */
/** @var Array                                      $groupedSiblings - сгруппированные подразделы текущего раздела*/
/** @var Array                                      $unGroupedSiblings - НЕсгруппированные подразделы текущего раздела*/
/** @var Array                                      $currentSectionProducts - Товары в текущем разделе (если есть)*/



echo '<br />';
echo '<br />';
echo 'Выбран раздел: <b>' . $currentSection->name.'</b>';
echo '<br />';
echo 'Перейти назад в <a href="'.Url::toRoute(['@catalogDir']).'">каталог</a>';
echo '<br />';
echo '<br />';

/** получить массив значений выбранного раздела - $currentSection->getAttributes() : */
//\Yii::$app->pr->print_r2($currentSection->getAttributes());

echo 'Подразделы:';
echo '<br />';
echo '<br />';


/** вывод списка сгруппированных подразделов для выбранного раздела */
foreach($groupedSiblings as $oneSibling){

    /** @var \common\modules\catalog\models\Section $oneSibling */

    //\Yii::$app->pr->print_r2($oneSibling->getAttributes());
    $url = Url::toRoute(['@catalogDir/'.$oneSibling->url]);

    echo '<br /><br />--- ' . '<a href="'.$url.'">' . $oneSibling->name . '</a> <br />';

    if(isset($oneSibling->childs)){

        /** Подразделы в этой категории (для примера вывел только один подуровень, но существует и больше ) */
        foreach ($oneSibling->childs as $oneChild) {
            /** @var \common\modules\catalog\models\Section $oneChild */

            $childUrl = Url::toRoute(['@catalogDir/'.$oneChild->url]);
            echo '-------- ' . '<a href="'.$childUrl.'">' . $oneChild->name . '</a> <br />';


            /** вот так, если потребуется, можешь проверить и вывести подразделы для этого подраздела: */
            if(isset($oneChild->childs)){

                foreach ($oneChild->childs as $oneSubChild) {
                    /** @var \common\modules\catalog\models\Section $oneSubChild */
                    $subChildUrl = Url::toRoute(['@catalogDir/'.$oneSubChild->url]);
                    echo '---------------- ' . '<a href="'.$subChildUrl.'">' . $oneSubChild->name . '</a> <br />';
                }

            }


        }
    }

}




/** вот тут ниже вывод несгруппированных подразделов (если понадобится) */
foreach($unGroupedSiblings as $oneSibling){
    /** @var \common\modules\catalog\models\Section $oneSibling */
    //\Yii::$app->pr->print_r2($oneSibling->getAttributes());
}
