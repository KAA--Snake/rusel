<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 06.05.2017
 * Time: 11:24
 */

namespace frontend\controllers;



use common\models\B_iblock_element;
use common\modules\catalog\models\mongo\Product;
use yii\mongodb\Query;
use yii\web\Controller;

class MongoController extends Controller
{

    public $elementModel;


   public function actionImport(){
       $this->elementModel = B_iblock_element::find()
           ->select( [
               'b_iblock_element.ID as ID',
               'b_iblock_element.NAME as NAME',
               'b_catalog_product.QUANTITY as QUANTITY',
           ] )
           ->andWhere( ['b_iblock_element.IBLOCK_ID' => 66] )
           ->joinWith( 'bCatalogProduct' )
           ->isActive()
           ->limit(100)
           ->orderBy( ['b_catalog_product.QUANTITY' => SORT_DESC] )
           ->all();

       $this->__fillElements();

       //создадим индексы по имени-колву по возрастанию
       $this->__makeIndexes();

       return 'imported';
   }


    /**
     * Заполняем поисковик
     */
    private function __fillElements(){

        $modelElement = new Element();
        $modelElement->deleteAll();
        \Yii::$app->db_mongo->getCollection('element')->drop();

        unset($modelElement);

        if(count($this->elementModel) > 0){
            foreach($this->elementModel as $oneElement){

                //echo $oneElement->getID() . '<br>';

               /* echo $oneElement->ID . '<br>';
                echo $oneElement->NAME . '<br>';
                echo $oneElement->bCatalogProduct->QUANTITY . '<br>';
                echo '<hr>';*/

                $modelElement = new Element();

                /*
                $modelElement->id = $oneElement->ID;
                $modelElement->name = $oneElement->NAME;
                $modelElement->quantity = $oneElement->bCatalogProduct->QUANTITY;*/

                //massive assign
                $modelElement->setAttributes([
                    'id' => $oneElement->ID,
                    'name' => $oneElement->NAME,
                    'quantity' => $oneElement->bCatalogProduct->QUANTITY,
                ]);

                $modelElement->insert();

            }
        }
    }


    private function __makeIndexes(){
        Element::getCollection()->createIndex([
            'name' => 'text'
        ]);


       /* Element::getCollection()->createIndexes([
            [
                'key' => [
                    'name' => 1,
                    'quantity' => 1,
                ],
                'name' => 'name_quantity_idx'
            ],
            [
                'key' => [
                    'name' => 1,
                ],
                'name' => 'name_idx'
            ]
        ]);*/
    }


    public function actionSearch($name){

        //$name = \Yii::$app->request->get('name');

        //if(empty($name)) return 'empty request';

        //$query = new Query();

        //$query->select()->from('element')->where([]);

        $search = Product::find()
            ->select([
                '_id',
                'id',
                'section_id',
                'status',
                'sort',
                'name',
                'code',
                'artikul',
                'product_logic',
                'properties',
                'other_properties',
                'prices',
                'quantity',
                'marketing',
            ])
            ->from('product')
            /*->where([
                '$text' => [
                    '$search' => $name
                ]
            ])*/
            ->orderBy(
                ['name' => SORT_ASC, 'sort' => SORT_DESC]
            )
            ->all();

        //\Yii::$app->pr->print_r2($rr);

        echo 'Поиск по "<b>'.$name.'</b>" <br /><br />';

        foreach ($search as $oneRes) {


            $rr = $oneRes->getAttributes();
            $rr = $oneRes->toArray();


            //echo '<br>'. $oneRes->name . ', количество: ' . $oneRes->id;

            \Yii::$app->pr->print_r2($rr);
        }

        return '<br /><br /> Найдено всего: ' . count($search);
    }
}