<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.18
 * Time: 9:44
 */

namespace common\modules\catalog\models;

use common\models\elasticsearch\Product;
use yii\base\Model;

class OffersSearch extends Offers
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    /**
     * Получает спецпредл по его УРЛ, и получает список товаров по артикулу либо по их ИД-ам
     *
     *
     * @param $url
     * @return array|bool
     */
    public function getProductsForOffer($url){

        if(empty($url)) return false;

        $products = [];

        $oneOffer = static::find()->andWhere([
            'url' => $url
        ])->one();

        $result = [];

        if($oneOffer){

            $result['offer'] = $oneOffer;

            //\Yii::$app->pr->print_r2($oneOffer->getAttributes());

            if(!empty($oneOffer->product_ids)){
                $ids = explode(';', $oneOffer->product_ids);

                $productMod = new Product();
                $products = $productMod->getProductsByIds($ids);

                //\Yii::$app->pr->print_r2($products);
                if(!empty($products)){
                    $result['products'] = $products;
                }

            }

        }

        $totalFound = count($result['products']);
        //пробрасывается в контроллер из Pagination_beh.php
        $pagination = \Yii::$app->controller->pagination;
        $pagination['totalCount'] = $products['total'];

        return
            [
                'products' => $result,
                'totalProductsFound' => $products['total'],
                //'filterData' => $allFilterDataProps,
                //'appliedFilterJson' => $appliedFilter,
                'paginator' => $pagination,
                //'emptyFilterResult' => $this->isEmptyResult,
                //'filterManufacturers' => $allManufacturers,

            ];

    }


}