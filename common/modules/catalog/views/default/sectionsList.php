<?php

use yii\helpers\Url;

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

?>
<h1><?= $currentSection->name; ?></h1>

<!--static markup--------------------------------------------------------------------->
<!--static markup--------------------------------------------------------------------->
<!--static markup--------------------------------------------------------------------->
<div class="catalog_tree_container fll">



    <div class="tree_container clear">
        <div class="tree_img fll">
            <img src="<?= Url::to('@web/img/tree_img3.png'); ?>" alt="<?= $currentSection->name; ?>">
        </div>
        <div class="catalog_tree_wrap fll">
            <h2>Конденсаторы</h2>
            <div class="tree_list">
                <ul class="catalog_tree lv1">
                    <li class="ct_item lv1 ct_first ct_dir child_collapsed">

                        Танталовые конденсаторы
                        <ul class="catalog_tree lv2 sublvl collapsed">
                            <li class="ct_item lv2 sublvl ct_dir child_collapsed">
                                Высоковольтные
                                <ul class="catalog_tree lv3 sublvl collapsed">
                                    <li class="ct_item lv3 sublvl"><a href="#">Высоковольтные подраздел 1</a></li>
                                    <li class="ct_item ct_last lv3 sublvl"><a href="#">Высоковольтные подраздел 2</a></li>
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

    <div class="tree_container clear">
        <div class="tree_img fll">
            <img src="<?= Url::to('@web/img/tree_img3.png'); ?>" alt="<?= $currentSection->name; ?>">
        </div>
        <div class="catalog_tree_wrap fll">
            <h2>Конденсаторы</h2>
            <div class="tree_list">
                <ul class="catalog_tree lv1">
                    <li class="ct_item lv1 ct_first ct_dir child_collapsed">

                        Танталовые конденсаторы
                        <ul class="catalog_tree lv2 sublvl collapsed">
                            <li class="ct_item lv2 sublvl ct_dir child_collapsed">
                                Высоковольтные
                                <ul class="catalog_tree lv3 sublvl collapsed">
                                    <li class="ct_item lv3 sublvl"><a href="#">Высоковольтные подраздел 1</a></li>
                                    <li class="ct_item ct_last lv3 sublvl"><a href="#">Высоковольтные подраздел 2</a></li>
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

<!--/static markup--------------------------------------------------------------------->
<!--/static markup--------------------------------------------------------------------->
<!--/static markup--------------------------------------------------------------------->

<div class="catalog_tree_container hidden">

    <?php foreach ($groupedSiblings as $oneSibling) { ?>
        <div class="tree_container">
            <div class="tree_img">
                <img src="<?= Url::to('@web/img/tree_img3.png'); ?>" alt="<?= $currentSection->name; ?>">
            </div>
            <div class="catalog_tree_wrap">
                <h2><?= $oneSibling->name; ?></h2>
                <?php if (isset($oneSibling->childs)) { ?>
                    <div class="tree_list">
                        <ul class="catalog_tree_lv1">
                            <?php foreach ($oneSibling->childs as $oneChild) { ?>

                                <li class="ct_item lv1 ct_first <?php if (isset($oneChild->childs)) { ?>ct_dir<?php }; ?> child_collapsed">

                                    <?php if (!isset($oneChild->childs)){ ?>
                                    <a href="<?= Url::toRoute(['@catalogDir/' . $oneChild->url]); ?>">
                                        <?php } ?>

                                        <?= $oneChild->name; ?>

                                        <?php if (!isset($oneChild->childs)){ ?>
                                    </a>
                                <?php } ?>

                                    <?php if (isset($oneChild->childs)) { ?>
                                        <ul class="catalog_tree lv2 collapsed">
                                            <?php foreach ($oneChild->childs as $oneSubChild) {
                                                /** @var \common\modules\catalog\models\Section $oneSubChild */
                                                ?>

                                                <li class="ct_item_lv2 ct_dir child_collapsed">
                                                    <?php if (!isset($oneSubChild->childs)){ ?>
                                                    <a href="<?= Url::toRoute(['@catalogDir/' . $oneSubChild->url]); ?>">
                                                        <?php } ?>

                                                        <?= $oneSubChild->name; ?>

                                                        <?php if (!isset($oneSubChild->childs)){ ?>
                                                    </a>
                                                <?php } ?>

                                                    <?php if(isset($oneSubChild->childs)){ ?>
                                                        <ul class="catalog_tree lv3 collapsed">
                                                            <?php foreach ($oneSubChild->childs as $oneSubSubChild) {
                                                                /** @var \common\modules\catalog\models\Section $oneSubChild */
                                                                ?>

                                                                <li class="ct_item_lv3 child_collapsed">
                                                                    <?php if(!isset($oneSubSubChild->childs)){?>
                                                                    <a href="<?=Url::toRoute(['@catalogDir/'.$oneSubSubChild->url]);?>">
                                                                        <?php } ?>

                                                                        <?=$oneSubSubChild->name;?>

                                                                        <?php if(!isset($oneSubSubChild->childs)){?>
                                                                    </a>
                                                                <?php } ?>
                                                                </li>

                                                            <?php } ?>
                                                        </ul>
                                                    <?php } ?>

                                                </li>

                                            <?php } ?>
                                        </ul>
                                    <?php } ?>

                                </li>

                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<div class="hidden" style="border: 1px solid red; padding: 10px;">


    <?php
    echo '<br />';
    echo '<br />';
    echo 'Выбран раздел: sectionsList.php <b>' . $currentSection->name . '</b>';
    echo '<br />';
    echo 'Перейти назад в <a href="' . Url::toRoute(['@catalogDir']) . '">каталог</a>';
    echo '<br />';
    echo '<br />';

    /** получить массив значений выбранного раздела - $currentSection->getAttributes() : */
    //\Yii::$app->pr->print_r2($currentSection->getAttributes());

    echo 'Подразделы: 2';
    echo '<br />';
    echo '<br />';


    /** вывод списка сгруппированных подразделов для выбранного раздела */
    foreach ($groupedSiblings as $oneSibling) {

        /** @var \common\modules\catalog\models\Section $oneSibling */

        //\Yii::$app->pr->print_r2($oneSibling->getAttributes());
        $url = Url::toRoute(['@catalogDir/' . $oneSibling->url]);

        echo '<br /><br />--- ' . '<a href="' . $url . '">' . $oneSibling->name . '</a> <br />';

        if (isset($oneSibling->childs)) {

            /** Подразделы в этой категории (для примера вывел только один подуровень, но существует и больше ) */
            foreach ($oneSibling->childs as $oneChild) {
                /** @var \common\modules\catalog\models\Section $oneChild */

                $childUrl = Url::toRoute(['@catalogDir/' . $oneChild->url]);
                echo '-------- ' . '<a href="' . $childUrl . '">' . $oneChild->name . '</a> <br />';


                /** вот так, если потребуется, можешь проверить и вывести подразделы для этого подраздела: */
                if (isset($oneChild->childs)) {

                    foreach ($oneChild->childs as $oneSubChild) {
                        /** @var \common\modules\catalog\models\Section $oneSubChild */
                        $subChildUrl = Url::toRoute(['@catalogDir/' . $oneSubChild->url]);
                        echo '---------------- ' . '<a href="' . $subChildUrl . '">' . $oneSubChild->name . '</a> <br />';
                    }

                }


            }
        }

    }


    /** вот тут ниже вывод несгруппированных подразделов (если понадобится) */
    foreach ($unGroupedSiblings as $oneSibling) {
        /** @var \common\modules\catalog\models\Section $oneSibling */
        //\Yii::$app->pr->print_r2($oneSibling->getAttributes());
    }

    ?>

    <!--<div class="catalog_tree_wrap">
        <ul class="catalog_tree_lv1">
            <li class="ct_item lv1 ct_first ct_dir child_collapsed">
                Танталовые конденсаторы
                <ul class="catalog_tree lv2 collapsed">
                    <li class="ct_item_lv2 ct_dir child_collapsed">
                        --Высоковольтные1111
                        <ul class="catalog_tree lv3 collapsed">
                            <li class="ct_item_lv2">---Высоковольтные2</li>
                            <li class="ct_item_lv2"><a href="">---Высоковольтные3</a></li>
                        </ul>
                    </li>
                    <li class="ct_item_lv2">--Высоковольтные2</li>
                    <li class="ct_item_lv2">--Высоковольтные3</li>
                </ul>
            </li>
            <li class="ct_item_lv1 ct_first dir">
                Танталовые конденсаторы
                <ul class="catalog_tree_lv2">
                    <li class="ct_item_lv2">
                        Высоковольтные
                    </li>
                    <li class="ct_item_lv2">Высоковольтные2</li>
                    <li class="ct_item_lv2">Высоковольтные3</li>
                </ul>
            </li>
            <li class="ct_item_lv1 ct_last dir">
                Танталовые конденсаторы
                <ul class="catalog_tree_lv2">
                    <li class="ct_item_lv2">
                        Высоковольтные
                    </li>
                    <li class="ct_item_lv2">Высоковольтные2</li>
                    <li class="ct_item_lv2">Высоковольтные3</li>
                </ul>
            </li>
        </ul>
    </div>-->

    <?php
    ?>
</div>