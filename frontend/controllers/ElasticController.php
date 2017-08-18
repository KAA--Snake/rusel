<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.04.2017
 * Time: 17:38
 */

namespace frontend\controllers;


use yii\data\Pagination;
use yii\web\Controller;
use common\models\elasticsearch\Customer;

class ElasticController extends Controller
{
    /**
     * Создаем индекс для модели customer
     */
    public function actionCreateIndex(){

        Customer::createIndex();

        //return $this->render('map-index', []);
    }


    //обычное заполнение
    public function actionAddTestCustomers(){
        for($i = 1; $i <= 350; $i++){
            $elasticModel = new Customer();
            $elasticModel->name = 'Smu'.$i;
            $elasticModel->surname = 'Solo'.$i;
            $elasticModel->primaryKey = $i;
            if ($elasticModel->insert()) {
                //echo "Added Successfully <br>";
            } else {
                echo "Error <br>";
            }
        }

        //return $this->render('map-index', []);
    }

    //suggest заполнение
    public function actionAddTestCustomers222(){
        for($i = 1; $i <= 350; $i++){
            $elasticModel = new Customer();
            $elasticModel->name = [
                'input' => 'Smu'.$i,
               // 'weight' => $i,
            ];



            $elasticModel->surname = 'Solo'.$i;
            $elasticModel->primaryKey = $i;
            if ($elasticModel->insert()) {
               // echo "Added Successfully <br>";
            } else {
                echo "Error <br>";
            }
        }
    }


    /**
     * Удаление индекса (при желании)
     */
    public function actionDeleteIndex(){
        Customer::deleteIndex();
    }



    public function actionFindByName(){

        $name = \Yii::$app->request->get('name');
        $customers = [];
        //почему то не работает
        //$query = Customer::find()->where(['name' => $name])->all();


        //точное совпадение
       /* $query = Customer::find()->query(
            ['match' => ['name' => $name]]
        )->all();*/

       /* $query = Customer::find()->query([
                'common' => [
                    'name' => [
                        'query' => $name,
                        //'cutoff_frequency' => 0.001,
                        //'low_freq_operator' => 'and'
                    ]
                ]
        ])->all();*/


      /*  $query = Customer::find()->query([
                'more_like_this' => [
                    'fields' => ['name'],
                    'like' => $name,
                    'min_term_freq' => 1,
                    'max_query_terms' => 12,
                ]
        ])->all();*/

        //suggest поиск но пока неясно
        /*$query = Customer::find()->addSuggester('mysuggest',[
                'text' => 'gf',
                //'max_query_terms' => 2,
                'term' => [
                    'field' => 'surname',
                ],
            ])->all();*/

        //нативный поиск без модели
       /* $query = Customer::find()->search(Customer::getDb(), [
            'size' => 3
        ]);*/


        //fuzzy поиск (рабочий)
        /*$query = Customer::find()->query([
            'fuzzy' => [
                'name' => [
                    "value" => "smu1",
                    //1 стоит по умолчанию в match! 2 - это уже оч много, использовать осторожно!
                    "fuzziness" => 2,
                    'max_expansions' => 100,
                    //prefix_length - сколько отступать с начала строки до начала размазывания
                    //'prefix_length' => 3
                ]
            ]
        ])->all();*/

        /*$query = Customer::find()->query([
            'bool' => [
                'should' => [
                    ['match' => ['name' => 'Smu1']],
                    ['match' => ['name' => 'Smu2']],
                ]

            ]
        ])->all();*/

          /*Customer::find()->suggest([
            'suggest1' =>[
                'text' => 'suggest text about smu',
                'term' => [
                    'field' => 'name'
                ]
            ]
        ])->all();*/
/*
        $query = Customer::find()->query(
            ['match' => ['name' => 'smu3']]
        )->limit(5)->all();
*/




       /* $query = Customer::find()->addSuggester('mysuggest',[
            "prefix" => $name,
            //'max_query_terms' => 2,
            'completion' => [
                'field' => 'name',
            ],
        ])->all();*/

        /*//синтакс верный но выводит всегда одно и тоже
        $query = Customer::find()->addSuggester('mysuggest',[
            //"prefix" => $name,
            "regex" => "smu58",
            //'max_query_terms' => 2,
            'completion' => [
                'field' => 'name',
            ],
        ])->all();*/

        //регулярки работают
       /* $query = Customer::find()->query([
                "regexp" => [
                    "name" => [
                        'value' => 'smu2*'
                    ]
                ]
        ])->limit(5)->all();*/

        //рабочий поиск по префиксу
        /*$query = Customer::find()->query([
            "prefix" => [ "name" =>  [
                "value" => "Smu2",
                //"boost" => 2.0
            ]]
        ])->limit(5)->all();*/

        //term лучше использовать для keyword полей, а match для полнотекстового поиска в text полях
       /* $query = Customer::find()->query(
            ['term' => ['name' => 'smu3']]
        )->limit(5)->all();*/

        /*$paginator = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 5,
            'pageSizeParam' => false,
            'forcePageParam' => false,
        ]);*/
/*
        $customers = $query->offset($paginator->offset)
            ->limit($paginator->limit)
            ->all();*/

        //return $this->render('findByName', compact('customers', 'query'));
    }
}