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
    public $maket = 'main_menu';

    public function init()
    {
        parent::init();


        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {
        $sectionModel = new Section();
        /** @var Section $rootSections */
        $rootSections = $sectionModel->getAllSectionsByMaxDepthLevel(2);

        if($this->maket != 'main_menu' && !empty($this->maket)){
            return $this->render($this->maket, ['rootSections' => $rootSections]);
        }

        return $this->render('main_menu', ['rootSections' => $rootSections]);
    }
}