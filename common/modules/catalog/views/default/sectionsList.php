<?php

use yii\helpers\Url;
use common\modules\catalog\models\Section;

/**
 *  Это view для вывода раздела / списка подразделов каталога
 */

/**
 *  Все объекты описаны нотациями.
 * (пример нотации - @var \common\modules\catalog\models\Section $oneSibling )
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
/** @var \common\modules\catalog\models\Section $currentSection - текущий выбранный раздел */
/** @var Array $groupedSiblings - сгруппированные подразделы текущего раздела */
/** @var Array $unGroupedSiblings - НЕсгруппированные подразделы текущего раздела */
/** @var Array $currentSectionProducts - Товары в текущем разделе (если есть) */

foreach ($groupedSiblings as $oneSibling){
    if(isset($oneSibling->childs) && count($oneSibling->childs) > 0){
        //\Yii::$app->pr->print_r2($oneSibling->childs);
        //\Yii::$app->pr->print_r2($oneSibling->getAttributes());
    }

}

$sectionModel = new Section();

//$sectionModel->listTree($groupedSiblings);

?>
<h1><?= $currentSection->name; ?></h1>

<!--static markup--------------------------------------------------------------------->
<!--static markup--------------------------------------------------------------------->
<!--static markup--------------------------------------------------------------------->
<div class="catalog_tree_container fll">
    <?php
    $depth = 0;
    $previousKey = null;
    foreach ($unGroupedSiblings as $key=>$value) {
        /** @var \common\modules\catalog\models\Section $oneSibling */
        /*if( !$previousKey ) $previousKey = 0;
        $depth = $value->depth_level;
        echo $value->name.' :: '. $depth.' ';

        echo '---'.$unGroupedSiblings[$previousKey]->name.' :: '. $depth.'<br>';*/

        /*if($value->depth_level > $depth){
            $depth = $value->depth_level;
            echo $value->name.' :: '. $depth.'<br>';
            echo '---'.$unGroupedSiblings[$previousKey]->name.' :: '. $depth.'<br>';
        }elseif ($value->depth_level < $depth){
            $depth = $value->depth_level;
            echo $value->name.' :: '. $depth.'<br>';
            echo '---'.$unGroupedSiblings[$previousKey]->name.' :: '. $depth.'<br>';
        }*/

        $previousKey = $key;
        //\Yii::$app->pr->print_r2($value->getAttributes());

    }
    ?>



    <?php

    foreach ($groupedSiblings as $oneSibling) { ?>
        <div class="content_block">
            <div class="tree_container clear">
                <!--<div class="tree_img fll">
                    <img src="<?/*= Url::to('@web/img/tree_img3.png'); */?>" alt="<?/*= $currentSection->name; */?>">
                </div>-->
                <div class="catalog_tree_wrap fll">
                    <h2>
                        <a href="<?= Url::toRoute(['@catalogDir/' . $oneSibling->url]); ?>"><?= $oneSibling->name; ?></a>
                    </h2>
                    <?php if (count($oneSibling->childs) > 0) { ?>
                        <div class="tree_list">

                            <?php
                            $sectionModel->recursiveLevel = 1;
                            $sectionModel->listTree($oneSibling->childs);
                            ?>

                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    <?php } ?>



    <div class="content_block">
        <div class="tree_container clear">
            <div class="tree_img fll">
                <img src="<?= Url::to('@web/img/tree_img3.png'); ?>" alt="<?= $currentSection->name; ?>">
            </div>
            <div class="catalog_tree_wrap fll">
                <h2>Конденсаторы !СТАТИКА!</h2>
                <div class="tree_list">
                    <ul class="catalog_tree lv1">
                        <li class="ct_item lv1 ct_first ct_dir child_collapsed">

                            Танталовые конденсаторы
                            <ul class="catalog_tree lv2 sublvl collapsed">
                                <li class="ct_item lv2 sublvl ct_dir child_collapsed">
                                    Высоковольтные
                                    <ul class="catalog_tree lv3 sublvl collapsed">
                                        <li class="ct_item lv3 sublvl"><a href="#">Высоковольтные подраздел 1</a></li>
                                        <li class="ct_item ct_last lv3 sublvl"><a href="#">Высоковольтные подраздел
                                                2</a></li>
                                    </ul>
                                </li>
                                <li class="ct_item lv2 sublvl"><a href="#">Низкотемпературные</a></li>
                                <li class="ct_item ct_last lv2 sublvl"><a href="#">Выводные</a></li>
                            </ul>
                        </li>
                        <li class="ct_item lv1 ct_dir child_collapsed">
                            Керамические конденсаторы
                            <ul class="catalog_tree lv2 sublvl collapsed">
                                <li class="ct_item lv2 sublvl"><a href="#">Низкотемпературные</a></li>
                                <li class="ct_item lv2 sublvl"><a href="#">Низкотемпературные 2</a></li>
                                <li class="ct_item ct_last lv2 sublvl"><a href="#">Низкотемпературные 3</a></li>
                            </ul>
                        </li>
                        <li class="ct_item lv1 ct_last ct_dir child_collapsed">
                            Металлопленочные конденсаторы
                            <ul class="catalog_tree lv2 sublvl collapsed">
                                <li class="ct_item lv2 sublvl"><a href="#">Выводные</a></li>
                                <li class="ct_item lv2 sublvl"><a href="#">Выводные 2</a></li>
                                <li class="ct_item ct_last lv2 sublvl"><a href="#">Выводные 3</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>


<!--/static markup--------------------------------------------------------------------->
<!--/static markup--------------------------------------------------------------------->
<!--/static markup--------------------------------------------------------------------->




