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

    <div class="gc_header">
        <div class="cat_icon">
            <svg
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="20px" height="12px">
                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                      d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                      d="M-0.000,5.000 L20.000,5.000 L20.000,7.000 L-0.000,7.000 L-0.000,5.000 Z"/>
                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                      d="M-0.000,10.000 L20.000,10.000 L20.000,12.000 L-0.000,12.000 L-0.000,10.000 Z"/>
            </svg>
        </div>
        Каталог
    </div>
    <div class="gc_menu_wrap">
        <ul class="gc_list gc_list-lvl0" >
            <?php if(count($rootSections) > 0){?>
                <?php foreach($rootSections as $k=>$oneSection){?>
                    <li class="gc_item">
                        <a href="<?= Url::toRoute(['@catalogDir/' . $oneSection->url]); ?>"><span><?=$oneSection->name;?></span> <div class="catalog-icon"></div></a>
                        <ul class="gc_list gc_list-lvl1" >
                            <?php foreach ($oneSection->childs as $sectionChild) {?>
                                <li class="gc_item lvl1-item">
                                    <a href="<?= Url::toRoute(['@catalogDir/' . $sectionChild->url]); ?>"><span><?=$sectionChild->name;?></span></a>
                                </li>
                            <?php }?>
                        </ul>
                    </li>
                <?php }?>
            <?php }?>

        </ul>
    </div>

</div>