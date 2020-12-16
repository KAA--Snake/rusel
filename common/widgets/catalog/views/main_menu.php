<?php
namespace common\widgets\catalog\views;

use common\modules\catalog\models\Section;
use yii\helpers\Url;

if(!isset($rootSections) || empty($rootSections)){
    $rootSections = [];
}

/**
 * Дерево детей находится тут, вложенность меню = 2 (верхний уровень + один)
 * пример вызова тут и еще ниже с закормменченной отладкой. Как закончишь - оставь закомменченное тут, чтоб не забылось
 *
 * foreach($rootSections as $k=>$oneSection) {
 *
 *      foreach ($oneSection->childs as $sectionChild) {
 *          echo $sectionChild->name;
 *          echo $sectionChild->url;
 *      }
 * }
 *
 */

foreach($rootSections as $k=>$oneSection) {

    /** @var Section $sectionChild */
    foreach ($oneSection->childs as $sectionChild) {
        //раскомментируй ниже, чтобы посмотреть структуру $sectionChild. Впрочем она такая-же как у верхних разделов.
        //\Yii::$app->pr->print_r2($sectionChild->getAttributes());
       }
  }

//конструкция ниже - делает die(), но он работает только только для куки = dev, как print_r2()
//чтоб не шаблон не мешался, лучше ее запустить когда будешь смотреть отладку выше.
//\Yii::$app->pr->die();
?>


<div class="goods_catalog js-dropdown-catalog">
    <div class="gc_header">Каталог</div>
    <ul class="gc_list gc_list-lvl0" >
        <?php if(count($rootSections) > 0){?>
            <?php foreach($rootSections as $k=>$oneSection){?>
                <li class="gc_item">
                    <a href="<?= Url::toRoute(['@catalogDir/' . $oneSection->url]); ?>"><span><?=$oneSection->name;?></span></a>
                </li>
            <?php }?>
        <?php }?>

    </ul>
</div>