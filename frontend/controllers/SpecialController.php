<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.18
 * Time: 9:33
 */

namespace frontend\controllers;


use common\modules\catalog\models\OffersSearch;
use yii\web\Controller;
use yii\web\HttpException;

class SpecialController extends Controller
{
    public $layout = 'special';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'manufacturers' => [
                'class' => 'common\modules\catalog\behaviours\Manufacturers_beh',
                /*'in_attribute' => 'name',
                'out_attribute' => 'slug',
                'translit' => true*/
            ],
            'pagination' => [
                'class' => 'common\modules\catalog\behaviours\Pagination_beh',
                'maxSizeCnt' => \Yii::$app->getModule('catalog')->params['max_products_cnt']

            ],
        ];
    }


    public function actionIndex($url=false){

        $offersSearch = new OffersSearch();

        $data = $offersSearch->getProductsForOffer($url);

        //\Yii::$app->pr->print_r2($data);
        //throw new HttpException(404);
        $this->view->params['seo']['special'] = $data['products']['offer'];

        return $this->render('special', ['data' => $data]);
    }


    public function actionAll(){
        //return 'not applied yet';
        throw new HttpException(404);
    }
}