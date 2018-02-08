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
     * Получает на вход ИД раздела каталога, а также дополнительные параметры
     * и выбирает все свойства товаров из выбранного раздела, используя условия по выборке по параметрам
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
     * @param $searchParams
     * @return array
     */
    public function getFilterDataForSectionId($searchParams)
    {
        //пробрасывается в контроллер из Pagination_beh.php
        //$pagination = \Yii::$app->controller->pagination;
        $sectionId = $searchParams['section_id'];

        $filterData = [];

        if($sectionId <= 0){
            return [];
        }

        /**  дефолтные данные по фильтрам TODO применить их в фильтре !*/
        $filterData['quantity']['stock']['count'] = '> 0';
        $filterData['properties']['proizvoditel'] = '';

        $queryStroke = '';

        foreach($searchParams as $key=>$param){
            if($queryStroke == ''){
                $queryStroke .= $key.':'.$param;
            }else{
                $queryStroke .= ' AND '.$key.':'.$param;
            }

        }


        /**  дефолтные данные по фильтрам */


        //ЭТО РАБОТАЕТ!!!
        $params = [
            'body' => [
                //"size" => 0,
                //"_source"=> false,
                "query"=> [
                    'bool' => [
                        'must' => [
                            'section_id' => $sectionId
                        ],
                        /*"nested" => [
                            "path" => "other_properties.property",
                            "query"=> [
                                "bool"=> [
                                    "must"=> [
                                        [
                                            "match"=> [
                                                "other_properties.property.value"=> "10А"
                                            ]
                                        ],
                                        //[
                                        //    "match"=> [
                                        //    "other_properties.property.id"=> 104
                                        //  ]
                                        //]
                                    ]
                                ]
                            ]
                        ]*/
                    ]



                    /*"query_string"=> [
                        "query"=> "section_id:$sectionId"
                        //"query"=> $queryStroke
                        //"query"=> 'other_properties.property.property.value:"10А"'
                        //"query"=> 'properties.proizvoditel:Phoenix'
                    ],*/


                ],

                /*"filters" => [
                    "filters" => [
                        "errors" =>   [ "match" => [ "body" => "error"   ]],
                        "warnings" => [ "match" => [ "body" => "warning" ]]
                    ]
                  ],*/


                /*"aggs" => [
                    "properties_agg" => [
                        "nested" => [
                            "path" => "other_properties.property",
                        ],
                        "aggs" => [
                            "sub_agg" => [
                                "terms"=> [
                                    "field"=> "other_properties.property.id",
                                    "size"=> 500,
                                ],
                                'aggs' => [
                                    'prop_values' => [
                                        "terms"=> [
                                            "field"=> "other_properties.property.value",
                                            "size"=> 500,
                                            "order"=> ["_term" => "asc"]
                                        ],

                                    ],
                                    'prop_name' => [
                                        "terms"=> [
                                            "field"=> "other_properties.property.name",
                                            "size"=> 1,
                                            //"order"=> ["_term" => "asc"]
                                        ],

                                    ],

                                ]
                            ]
                        ]
                    ]
                ]*/
            ]
        ];


        $params =[
            'body' =>[
                "query"=> [
                    "bool"=> [

                        /** обязательный блок (для ИД раздела ) */
                        "must"=> [
                            [
                                "term"=> [
                                    "section_id"=> $sectionId
                                ]
                            ],


                            /** блок (для отдельного свойства ) */
                            [
                                "nested"=> [

                                    "path"=> "other_properties.property",
                                    "query"=> [
                                        'bool' => [
                                            'must' => [
                                                [
                                                    "term"=> [
                                                        "other_properties.property.id"=> 104,
                                                    ],
                                                ],
                                                [
                                                    "terms"=> [
                                                        "other_properties.property.value"=> ["10А"],
                                                        //"other_properties.property.id"=> [134],
                                                    ]
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],


                            /** блок (для отдельного свойства ) */
                            [
                                "nested"=> [

                                    "path"=> "other_properties.property",
                                    "query"=> [
                                        'bool' => [
                                            'must' => [
                                                [
                                                    "term"=> [
                                                        "other_properties.property.id"=> 123,
                                                    ],
                                                ],
                                                [
                                                    "terms"=> [
                                                        "other_properties.property.value"=> ['500'],
                                                        //"other_properties.property.id"=> [134],
                                                    ]
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],



                            //это работает
                           /* [
                                "nested"=> [
                                    "path"=> "other_properties.property",
                                    "query"=> [
                                        "terms"=> [
                                            "other_properties.property.value"=> ["10А", "1А"],
                                            //"other_properties.property.id"=> [134],
                                        ]
                                    ]
                                ]
                            ],*/
                            /*[
                                "nested"=> [
                                    "path"=> "other_properties.property",
                                    "query"=> [
                                        "match"=> [
                                            "other_properties.property.value"=> [
                                                "query"=> "10А",
                                                "operator"=> "and"
                                            ],

                                        ]
                                    ]
                                ]
                            ],*/




                        ]


                    ]
                ],

                /** start of aggs */

                "aggs" => [
                    "properties_agg" => [
                        "nested" => [
                            "path" => "other_properties.property",
                        ],
                        "aggs" => [
                            "sub_agg" => [
                                "terms"=> [
                                    "field"=> "other_properties.property.id",
                                    "size"=> 500,
                                ],
                                'aggs' => [
                                    'prop_values' => [
                                        "terms"=> [
                                            "field"=> "other_properties.property.value",
                                            "size"=> 500,
                                            "order"=> ["_term" => "asc"]
                                        ],

                                    ],
                                    'prop_name' => [
                                        "terms"=> [
                                            "field"=> "other_properties.property.name",
                                            "size"=> 1,
                                            //"order"=> ["_term" => "asc"]
                                        ],

                                    ],

                                ]
                            ]
                        ]
                    ]
                ]
                /** end of aggs */

            ]
        ];

        $params = $this->productData + $params;

        \Yii::$app->pr->print_r2($params);


        $response = Elastic::getElasticClient()->search($params);

        \Yii::$app->pr->print_r2($response);
        //unset($response['hits']);
die();

        return $response;
    }



}