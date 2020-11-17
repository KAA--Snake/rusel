<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\seo_section;

use common\modules\catalog\models\seo\SeoSection;
use yii\base\Widget;

class SeoSections extends Widget
{

    public $options;

    public function init()
    {
        parent::init();
        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {
        $manufacturerId = $this->options['sectionId'];
        if (empty($this->options['sectionId'])) {
            return '';
        }

        $seoText = SeoSection::findOne(['section_id' => $this->options['sectionId']]);

        if (!$seoText) {
            return '';
        }

        return $this->render('seo-sections', ['model' => $seoText]);
    }
}