<?php
/**
 * Контроллер для импорта и elastic поиска по товарам битрикса
 */
namespace frontend\controllers;


use common\models\B_iblock_element;
use common\models\elasticsearch\Element;
use yii\web\Controller;

class SearchController extends Controller
{

    private $elementModel;


    public function actionImport(){

        //получим список товаров

        $this->elementModel = B_iblock_element::find()
            ->select( [
                'b_iblock_element.ID',
                'b_iblock_element.NAME',
                'b_catalog_product.QUANTITY',
            ] )
            ->andWhere( ['b_iblock_element.IBLOCK_ID' => 66] )
            ->joinWith( 'bCatalogProduct' )
            ->isActive()
            ->limit(5)
            ->orderBy( ['b_catalog_product.QUANTITY' => SORT_DESC] )
            ->all();

        //$elementModel = new B_iblock_element();
        //$elementModel->find()->Where(['b_iblock_element.IBLOCK_ID' => 66])->limit(5)->all();

        $this->__fillElements();
        die();

        return $this->render('search', []);
    }


    /**
     * Заполняем поисковик
     */
    private function __fillElements(){

        if(count($this->elementModel) > 0){
            foreach($this->elementModel as $oneElement){

                //echo $oneElement->getID() . '<br>';



                $rr = $oneElement->toArray();
                \Yii::$app->pr->print_r2($rr);

                /*$elasticModel = new Element();
                $elasticModel->name = 'Smu'.$i;
                $elasticModel->surname = 'Solo'.$i;
                $elasticModel->primaryKey = $i;
                if ($elasticModel->insert()) {
                    //echo "Added Successfully <br>";
                } else {
                    echo "Error <br>";
                }*/

            }
        }



    }
}