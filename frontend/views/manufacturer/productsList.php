<?php
use yii\helpers\Url;
use common\modules\catalog\models\Section;
use common\widgets\catalog\Paginator;

echo 'Поиск по производителю ' . $manufacturer;

/** список товаров лежит в $productsList */

/** список раздлелов лежит в $groupedSections */

//\Yii::$app->pr->print_r2($paginator);

$sectionModel = new Section();

?>

<div class="catalog_tree_container fll">

    <?php
    if(count($groupedSections) > 0){
        foreach ($groupedSections as $oneSibling) { ?>
            <div class="content_block">
                <div class="tree_container clear">
                    <!--<div class="tree_img fll">
                            <img src="<?/*= Url::to('@web/img/tree_img3.png'); */?>" alt="<?/*= $currentSection->name; */?>">
                        </div>-->
                    <div class="catalog_tree_wrap fll">
                        <h2>
                            <a class="tree_header active" href="<?= Url::toRoute(['@catalogDir/' . $oneSibling['url']]); ?>">
                                <span class="red_icon"></span>
                                <?= $oneSibling['name']; ?>
                                <div class="tree_header_icon <?php if (count($oneSibling['childs']) > 0) { ?>active<? }else{ ?>inactive<? } ?>"></div>
                            </a>
                        </h2>
                        <?php if (count($oneSibling['childs']) > 0) {
                            //if($oneSibling->not_show) continue;
                            ?>
                            <div class="tree_list">

                                <?php
                                $sectionModel->recursiveLevel = 1;
                                $sectionModel->listTree2($oneSibling['childs']);
                                ?>

                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        <?}?>
    <?}?>
</div>
<div style="clear:both;">
<div>
    Список (без сортировки):
</div>
<div>
    <?foreach($productsList as $oneProduct){?>

        <div>ID: <?=$oneProduct['_source']['id'];?></div>
        <div>Наименование: <?=$oneProduct['_source']['name'];?></div>
        <div>Аксессуары: <?if(isset($oneProduct['_source']['accessories'])) {?> <i>ПРИСУТСТВУЮТ</i> <?}else{?> отсутствуют <?}?></div>

        <hr>
    <?}?>
</div>
<?
echo Paginator::widget([
    'pagination' => $paginator,
]);
?>