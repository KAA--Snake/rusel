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


class StockInfoAction extends Action
{

    public $view = '@frontend/views/stocks/result';

    /**
     * Initializes the action.
     * @throws InvalidConfigException if the font file does not exist.
     */
    public function init()
    {
       parent::init();
    }

    /**
     * Runs the action.
     */
    public function run()
    {
        $searchQuery = '';
        if(isset(Yii::$app->getRequest()->post()['search']) && !empty(Yii::$app->getRequest()->post()['search'])){
            $searchQuery = Yii::$app->getRequest()->post()['search'];
        }

        if(isset(Yii::$app->getRequest()->get()['search']) && !empty(Yii::$app->getRequest()->get()['search'])){
            $searchQuery = Yii::$app->getRequest()->get()['search'];
        }

        //ставим размер через пагинатор (чтобы не ломать существующую модель поиска)
        \Yii::$app->controller->pagination['max_elements_cnt'] = 5;
        \Yii::$app->controller->pagination['maxSizeCnt'] = 5;

        $this->setHttpHeaders();
        Yii::$app->response->format = Response::FORMAT_XML;

        ob_start();

        $stockDataXmlWriter = new StockDataXmlWriter();
        $stockDataXmlWriter->writeXmlBySearchQuery($searchQuery);

        echo ob_get_clean();
        die();

    }

    /**
     * Sets the HTTP headers needed by image response.
     */
    protected function setHttpHeaders()
    {
        Yii::$app->getResponse()->getHeaders()
            ->set('Pragma', 'public')
            ->set('Expires', '0')
            ->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->set('Content-Transfer-Encoding', 'binary')
            ->set('Content-type', 'application/xml');
    }
}
