<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\seo_tags;


use yii\base\Widget;

class SeoTags extends Widget
{

    public $options;

    public static $mainPageMode = 'mainPageMode';
    public static $productDetailMode = 'productDetailMode';
    public static $catalogSectionMode = 'catalogSectionMode';
    public static $manufacturerMode = 'manufacturerMode';

    private $defaultImage = "http://rusel24.ru/upload/images/Logo_Rusel24_sq2.png";
    private $model = [];
    private $viewForMode = 'mainPageMode';

    public function init()
    {
        parent::init();

        //$this->model['title'] = $this->options['title'];
        //$this->model['description'] = $this->options['description'];

        $this->model = $this->options;

        $this->getViewForSelectedMode();
        //yiiwebJqueryAsset::register($this->getView());
    }

    private function getViewForSelectedMode()
    {
        switch ($this->options['mode']) {
            case static::$mainPageMode:
                $this->viewForMode = "mainPageMode";
                break;

            case static::$productDetailMode:


                $this->viewForMode = "productDetailMode";

                break;

            case static::$catalogSectionMode:
                $this->viewForMode = "catalogSectionMode";
                break;

            case static::$manufacturerMode:
                $this->viewForMode = "manufacturerMode";
                break;
        }
    }

    public function run()
    {
       // \Yii::$app->pr->print_r2($this->model);


        return $this->render($this->viewForMode, [
            'model' => $this->model,
            'defaultImage' => $this->defaultImage
        ]);

    }
}