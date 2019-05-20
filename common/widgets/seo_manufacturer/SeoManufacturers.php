<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\seo_manufacturer;

use common\modules\catalog\models\seo\SeoManufacturer;
use yii\base\Widget;

class SeoManufacturers extends Widget
{

    public $options;

    public function init()
    {
        parent::init();
        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {
        $manufacturerId = $this->options['manufacturerId'];
        if (empty($this->options['manufacturerId'])) {
            return '';
        }

        $seoText = SeoManufacturer::findOne(['manufacturer_id' => $this->options['manufacturerId']]);

        if (!$seoText) {
            return '';
        }

        return $this->render('seo-manufacturers', ['model' => $seoText]);
    }
}