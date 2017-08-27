<?php
use yii\helpers\Url;

/** @var \common\modules\catalog\models\Section $rootSections */

echo '<br /><br />Корневой раздел каталога. <br /><br />';

if(count($rootSections) > 0){
    ?>
<div class="tree_exmpl_wrap">
    <ul class="tree_exmpl">
        <li class="higher_lvl_tree_item">
            <ul>
    <?php
    foreach($rootSections as $category){

        $url = Url::toRoute(['@catalogDir/'.$category->url]);
        //$url = Url::toRoute(['@catalogDir']);

        //$category - это объект модели, можно доставать св-ва, типа $category->url, $category->name и тп.

        //echo '<br /><br /> Раздел ' . '<a href="'.$url.'">' . $category->name . '</a> : ';

        /** @var \common\modules\catalog\models\Section $category */
        $section = $category->getAttributes(); //все атрибуты модели в виде массива

        //это отладка:
        //\Yii::$app->pr->print_r2($section);
        ?>

        <li class="tree_item"><a href="<?=$url?>"><?= $category->name ?></a></li>

<?php
    }
    ?>
            </ul>
        </li>

        <li class="higher_lvl_tree_item">
            <ul>
                <?php
                foreach($rootSections as $category){

                    $url = Url::toRoute(['@catalogDir/'.$category->url]);
                    //$url = Url::toRoute(['@catalogDir']);

                    //$category - это объект модели, можно доставать св-ва, типа $category->url, $category->name и тп.

                    //echo '<br /><br /> Раздел ' . '<a href="'.$url.'">' . $category->name . '</a> : ';

                    /** @var \common\modules\catalog\models\Section $category */
                    $section = $category->getAttributes(); //все атрибуты модели в виде массива

                    //это отладка:
                    //\Yii::$app->pr->print_r2($section);
                    ?>

                    <li class="tree_item"><a href="<?=$url?>"><?= $category->name ?></a></li>

                    <?php
                }
                ?>
            </ul>
        </li>

    </ul>
</div>
        <?php
}
?>

