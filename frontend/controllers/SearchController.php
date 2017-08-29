<?php
/**
 * Контроллер для импорта и elastic поиска по товарам битрикса
 */
namespace frontend\controllers;

//set_time_limit(0);

use common\models\B_iblock_element;
use common\models\elasticsearch\Element;
use yii\web\Controller;

class SearchController extends Controller
{

    private $elementModel;


    public function actionByName(){
        $name = \Yii::$app->request->get('name');

        //$name = 'Батарейка';

        echo 'Поиск по "' . $name.'"';

        $matches = Element::find()

            /*->query([
                'match' => [
                    'name' => $name,
                ]
            ])*/

            ->query([
                'bool' => [
                    'should' => [
                        "regexp" => [
                            "name" => $name.'.*'
                        ]
                    ],
                    'must' => [
                        ['match' => ['name' => $name]],
                    ]
                ]
            ])

            /*->query([
                'fuzzy' => [
                    'name' => [
                        "value" => $name,
                        //1 стоит по умолчанию в match! 2 - это уже оч много, использовать осторожно!
                        "fuzziness" => 2,
                        'max_expansions' => 50,
                        //prefix_length - сколько отступать с начала строки до начала размазывания
                        //'prefix_length' => 3
                    ]
                ]
            ])*/

            //->query(["regexp" => [ "name" => $name.".+" ]])
            ->orderBy(
                ['_score' => SORT_DESC, 'quantity' => SORT_DESC]
            )
            ->highlight([
                "pre_tags" => ['<b color="red">'],  //error one
                "post_tags" => ['</b>'],
                "fields" => [
                    'name' => new \stdClass()
                ]
            ])
            ->limit(100)
            ->all();


        echo '<br> Найдено совпадений : ' . count($matches) . '<br><br>';

        foreach($matches as $oneMatch){


            $attributes = $oneMatch->getAttributes();
            //\Yii::$app->pr->print_r2($oneMatch);
            $highlight = $oneMatch->getHighlight();

            foreach($highlight['name'] as $oneHighlight){

                echo '<br> ' . $oneHighlight . ' , ' . $attributes['quantity'] . 'шт. <br>';
            }




            //\Yii::$app->pr->print_r2($attr);
            //\Yii::$app->pr->print_r2($highlight);
        }




        return '<br> Поиск завершен.';
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
            ->limit(10000)
            ->orderBy( ['b_catalog_product.QUANTITY' => SORT_DESC] )
            ->all();

        $this->__fillElements();

        return 'imported';

        //return $this->render('search', []);
    }




    public function actionImportSuggest(){

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
            ->limit(100)
            ->orderBy( ['b_catalog_product.QUANTITY' => SORT_DESC] )
            ->all();

        $this->__fillElementsSuggest();

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
                /*
                echo $oneElement->ID . '<br>';
                echo $oneElement->NAME . '<br>';
                echo $oneElement->bCatalogProduct->QUANTITY . '<br>';
                echo '<hr>';
                */

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



    private function __fillElementsSuggest(){

        if(count($this->elementModel) > 0){
            foreach($this->elementModel as $oneElement){

                //echo $oneElement->getID() . '<br>';
                /*
                echo $oneElement->ID . '<br>';
                echo $oneElement->NAME . '<br>';
                echo $oneElement->bCatalogProduct->QUANTITY . '<br>';
                echo '<hr>';
                */

                if(!empty($oneElement->ID) && !empty($oneElement->NAME) && !empty($oneElement->bCatalogProduct->QUANTITY)){

                    $elasticModel = new Element();
                    $elasticModel->primaryKey = $oneElement->ID;

                    $elasticModel->id = $oneElement->ID;
                    $elasticModel->quantity = $oneElement->bCatalogProduct->QUANTITY;
                    $elasticModel->name = [
                        'input' => $oneElement->NAME
                    ];
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
     * Создаем индекс для модели Element
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


    /**
     * Поиск по списку из файла (загружаешь файл и тп)
     */
    public function actionByList(){


        return $this->render('listSearch');
    }

}