<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\offers_substitution;

use common\modules\catalog\models\seo\SeoSection;
use common\modules\catalog\models\Offers;
use yii\base\Widget;

class OffersSubstitution extends Widget
{

    public $options;

    public function init()
    {
        parent::init();
        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {

        if (empty($this->options['product'])) {
            return '';
        }

        $product = $this->options['product'];

        return $this->render('offers_substitutions', ['oneProduct' => $product]);
    }
}