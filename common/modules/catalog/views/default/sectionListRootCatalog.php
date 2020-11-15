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
 *  И в штрме поэтому можешь смотреть подсказки при ctrl+space на этих переменных.
 *  Главное не удаляй нотации для переменных, чтобы не пропадало автозаполнение штрма.
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


$sectionModel = new Section();

//$sectionModel->listTree($groupedSiblings);
$this->title = 'Каталог';;
?>
<div class="section_list_wrap clear">
    <h1><?= $currentSection->name; ?></h1>
    <div class="catalog_tree_container fll">

        <?php
        foreach ($groupedSiblings as $oneSibling) { ?>
            <div class="content_block">
                <div class="tree_container clear">
                    <!--<div class="tree_img fll">
                    <img src="<?/*= Url::to('@web/img/tree_img3.png'); */?>" alt="<?/*= $currentSection->name; */?>">
                </div>-->
                    <div class="catalog_tree_wrap fll">
                        <h2>
                            <a class="tree_header inactive" href="<?= Url::toRoute(['@catalogDir/' . $oneSibling->url]); ?>">
                                <span class="red_icon"></span>
                                <?= $oneSibling->name; ?>
                                <div class="tree_header_icon inactive"></div>
                            </a>
                        </h2>
                        <?php /*if (count($oneSibling->childs) > 0) { */?><!--
                        <div class="producers_block hidden">

                        </div>
                         --><?php /*} */?>

                        <?php if (isset($oneSibling->childs) && count($oneSibling->childs) > 0) { ?>
                            <div class="tree_list" style="display: none;">
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

    </div>
</div>





