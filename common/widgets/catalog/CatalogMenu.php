<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\catalog;


use common\modules\catalog\models\Section;
use yii\base\Widget;

class CatalogMenu extends Widget
{
    public function init()
    {
        parent::init();


        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {
        $sectionModel = new Section();
        $rootSections = $sectionModel->getRootSections();
        return $this->render('main_menu', ['rootSections' => $rootSections]);
    }
}