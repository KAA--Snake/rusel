<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.12.17
 * Time: 14:20
 */

namespace common\modules\catalog\models\search\searches;


use common\models\elasticsearch\Product;
use common\modules\catalog\models\elastic\Elastic;
use Yii;

class ProductsSearch extends BaseSearch implements iProductSearch
{

    private     $productData;
    public      $productModel;
    public      $searchConfig;


    private $productAggregation = [];


    public function __construct()
    {
        $this->productModel = new Product();
        $this->productData = Product::productData;

        $catalogModule = Yii::$app->getModule('catalog');
        $this->searchConfig = $catalogModule->params['search'];
    }


    public function searchByArtikuls(array $artikuls)
    {
        //пробрасывается в контроллер из Pagination_beh.php
        $pagination = \Yii::$app->controller->pagination;


        if(count($artikuls) <= 0){
            return [];
        }

        $productsFound = [];
        foreach($artikuls as $oneArtikul){

            //заполим пустотой неподходящие, чтобы показать их в поиске
            if(empty($oneArtikul)){
                $productsFound[] = ['error' => 'пустой артикул !'];
                continue;
            }

            if(!$this->_isLengthIsGood($oneArtikul)) {
                $productsFound[] = ['error' => 'Длина артикула не подходит под условие поиска! (слишком маленькая?)'];
                continue;
            }

            $params = [
                'body' => [
                    //'from' => $from,
                    'size' => $this->searchConfig['max_by_files_result'],
                    'sort' => [
                        'artikul' => 'asc'
                    ],
                    'query' => [
                        'prefix' => [
                            'artikul' => [
                                'value' => $oneArtikul,
                                //'boost' => 2.0
                            ]
                        ]
                    ]
                ]
            ];


            $params = $this->productData + $params;

            //\Yii::$app->pr->print_r2(json_encode($params));

            $response = Elastic::getElasticClient()->search($params)['hits']['hits'];

            //\Yii::$app->pr->print_r2($response);
            if(!empty($response)){
                //добавляем аксессуары к продуктам
                Product::setAccessoriedProds($response);
                $this->foundGoodResultsCount++;
            }else{
                $response = ['error' => 'Товаров не найдено'];
            }



            //\Yii::$app->pr->print_r2($response);

            $productsFound[] = $response;

            unset($response);

        }

        return $productsFound;

    }


    /**
     * Получает на вход ИД раздела каталога,
     * и выбирает все свойства товаров из выбранного раздела.
     *  [
     *      'property_name1' => [
     *              'code' => 'property_code1',
     *              'values' => [
     *                  'value1',
     *                  'value2',
     *                  'value3',
     *              ],
     *       ],
     *
     *      'property_name2' => [
     *              'code' => 'property_code2',
     *              'values' => [
     *                  'value1',
     *                  'value2',
     *                  'value3',
     *              ],
     *       ],
     *
     *  ]
     * @param $sectionId
     * @return array
     */
    public function getFilterDataForSectionId($sectionId)
    {
        //пробрасывается в контроллер из Pagination_beh.php
        //$pagination = \Yii::$app->controller->pagination;

        $filterData = [];

        if($sectionId <= 0){
            return $filterData = [];
        }

        /**  дефолтные данные по фильтрам */
        $filterData['quantity']['stock']['count'] = '> 0';
        $filterData['properties']['proizvoditel'] = '';


        $productsFound = [];



        //ЭТО РАБОТАЕТ!!!
        $params = [
            'body' => [
                "size" => 0,
                "_source"=> false,
                "query" => [
                    "term"=> [ "section_id"=> $sectionId ]
                ],
                "aggs" => [
                    "properties_agg" => [

                        "nested" => [
                            "path" => "other_properties.property"
                        ],
                        "aggs" => [
                            "sub_agg" => [
                                "terms"=> [
                                    "field"=> "other_properties.property.name",
                                    "size"=> 50000,


                                ],
                                'aggs' => [
                                    'sub_sub_aggr' => [
                                        "terms"=> [
                                            "field"=> "other_properties.property.value",
                                            "size"=> 50000,
                                            "order"=> ["_term" => "asc"]
                                        ],

                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];


        //$params = $this->productData + $params;

        //\Yii::$app->pr->print_r2($params);

        $response = Elastic::getElasticClient()->search($params);
        //unset($response['hits']);


        return $response;
    }






}