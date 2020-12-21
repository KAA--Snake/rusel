<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\actions;

use common\modules\catalog\models\search\searches\ProductsSearch;
use common\modules\catalog\modules\admin\models\stock_data\StockDataXmlWriter;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\web\Response;


class FeedBackFormAction extends Action
{

    public $view = '@frontend/views/feedback/FeedbackForm';

    public function init()
    {
       parent::init();
    }

    /**
     * Runs the action.
     */
    public function run()
    {
        return $this->controller->render($this->view);

    }

    /**
     * Sets the HTTP headers needed by image response.
     */
    protected function setHttpHeaders()
    {
        Yii::$app->getResponse()->getHeaders()
            ->set('Pragma', 'public')
            ->set('Expires', '0')
            ->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
            ->set('Content-Transfer-Encoding', 'binary')
            ->set('Content-type', 'application/xml');
    }
}
