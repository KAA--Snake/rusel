<?php
echo '<br /><br />Корневой раздел каталога. Список разделов: <br /><br />';
use yii\helpers\Url;

/** $catalogDirName НАДО ИСПОЛЬЗОВАТЬ ОБЯЗАТЕЛЬНО В ЛЮБОЙ ВЬЮХЕ ! */
$catalogDirName = $this->context->module->params['catalogDir'];

//$module = MyModuleClass::getInstance();

//$module = \Yii::$app->getModule('forum');

// получение модуля, к которому принадлежит запрошенный в настоящее время контроллер
//$module = \Yii::$app->controller->module;


/** @var \common\modules\catalog\models\Section $rootSections */

if(count($rootSections) > 0){
    foreach($rootSections as $category){

        $url = Url::to(['catalog/electric_products']);
        $url = Url::to(['catalog/admin/section/index']);
        //$url = Url::toRoute(['@catalogDir'/* 'pathForParse'=>$category->url*/]);
        //$url = Url::toRoute(['catalog/default/', 'pathForParse'=>$category->url]);
        echo '<br /><br /> Данные по разделу ' . '<a href="/'.$url.'">' . $category->name . '</a> : ';
        echo '<br /><br /> Данные по разделу ' . '<a href="/'.$catalogDirName.'/'.$category->url.'">' . $category->name . '</a> : ';

        /** @var \common\modules\catalog\models\Section $category */
        $section = $category->getAttributes();

        \Yii::$app->pr->print_r2($section);

    }
}


