<?php
/**
 * Контроллер для импорта и elastic поиска по товарам битрикса
 */
namespace frontend\controllers;

set_time_limit(0);

use common\models\B_iblock_element;
use common\models\elasticsearch\Element;
use yii\web\Controller;

class SearchController extends Controller
{

    private $elementModel;


    public function actionByName(){
        $name = \Yii::$app->request->get('name');
        echo 'Поиск по ' . $name;

        $matches = Element::find()
            ->query([
                'match' => [
                    'name' => $name,
                ],
            ])->orderBy(['quantity' => ['order' => 'desc']])
            //'sort' => ['quantity' => ['order' => 'desc']]
            ->limit(20)
            ->all();

        foreach($matches as $oneMatch){
            $attr = $oneMatch->getAttributes();
            \Yii::$app->pr->print_r2($attr);
        }




        return 'searched';
    }







    public function actionImport(){

        //получим список товаров

        $this->elementModel = B_iblock_element::find()
            ->select( [
                'b_iblock_element.ID as ID',
                'b_iblock_element.NAME as NAME',
                'b_catalog_product.QUANTITY as QUANTITY',
            ] )
            ->andWhere( ['b_iblock_element.IBLOCK_ID' => 66] )
            ->joinWith( 'bCatalogProduct' )
            ->isActive()
            ->limit(50)
            ->orderBy( ['b_catalog_product.QUANTITY' => SORT_DESC] )
            ->all();

        $this->__fillElements();

        return 'imported';

        //return $this->render('search', []);
    }


    /**
     * Заполняем поисковик
     */
    private function __fillElements(){

        if(count($this->elementModel) > 0){
            foreach($this->elementModel as $oneElement){

                //echo $oneElement->getID() . '<br>';
                echo $oneElement->ID . '<br>';
                echo $oneElement->NAME . '<br>';
                echo $oneElement->bCatalogProduct->QUANTITY . '<br>';
                echo '<hr>';

                if(!empty($oneElement->ID) && !empty($oneElement->NAME) && !empty($oneElement->bCatalogProduct->QUANTITY)){

                    $elasticModel = new Element();
                    $elasticModel->primaryKey = $oneElement->ID;

                    $elasticModel->id = $oneElement->ID;
                    $elasticModel->quantity = $oneElement->bCatalogProduct->QUANTITY;
                    $elasticModel->name = $oneElement->NAME;


                    if ($elasticModel->insert()) {
                        //echo "Added Successfully <br>";
                    } else {
                        echo "Error <br>";
                        echo $oneElement->ID . '<br>';
                        echo $oneElement->NAME . '<br>';
                        echo $oneElement->bCatalogProduct->QUANTITY . '<br>';
                        echo '<hr>';

                    }

                    //unset($elasticModel);
                }

                //$rr = $oneElement->toArray();
                //\Yii::$app->pr->print_r2($rr);

            }
        }
    }





    /**
     * Создаем индекс для модели customer
     */
    public function actionCreateIndex(){
        Element::createIndex();
        return 'index created';
    }
    /**
     * Удаление индекса
     */
    public function actionDeleteIndex(){
        Element::deleteIndex();
        return 'index deleted';
    }
}