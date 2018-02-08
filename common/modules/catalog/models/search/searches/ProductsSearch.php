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
        $pagination = \Yii::$app->controller->pagination;
        //\Yii::$app->pr->print_r2($pagination);

        $sectionId = $searchParams['section_id'];
        unset($searchParams['section_id']);

        $filterData = [];

        if($sectionId <= 0){
            return [];
        }

        /**  дефолтные данные по фильтрам TODO применить их в фильтре !*/
        $filterData['quantity']['stock']['count'] = '> 0';
        $filterData['properties']['proizvoditel'] = '';


        $must = [];


        //заполним для всех ID раздела (в принципе можно и без него)
        $must[] = [
            "term"=> [
                "section_id"=> $sectionId
            ]
        ];



        $nestedFilters = [];
        foreach($searchParams as $propId=>$propValue){

            if(mb_stripos($propValue, '|') !== false){
                $propValue = explode('|', $propValue);
            }

            //$propValue может быть массивом значений '10|20|50'!
            if(!is_array($propValue)){
                $propValue = [$propValue];
            }



            $oneFilter = [
                "nested"=> [

                    "path"=> "other_properties.property",
                    "query"=> [
                        'bool' => [
                            'must' => [
                                [
                                    "term"=> [
                                        "other_properties.property.id"=> $propId,
                                    ],
                                ],
                                [
                                    "terms"=> [
                                        "other_properties.property.value"=> $propValue,
                                        //"other_properties.property.id"=> [134],
                                    ]
                                ],
                            ],
                        ],
                    ],
                ]
            ];

            $must[] = $oneFilter;

        }



        /**  дефолтные данные по фильтрам */

        $params =[
            'body' =>[
                'from' => $pagination['from'],
                'size' => $pagination['maxSizeCnt'],
                'sort' => [
                    'artikul' => ['order' => 'asc']
                ],
                "query"=> [
                    "bool"=> [

                        /** обязательный блок (для ИД раздела ) */
                        'must' => $must
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

        //\Yii::$app->pr->print_r2($params);
        //die();


        $response = Elastic::getElasticClient()->search($params);

        //\Yii::$app->pr->print_r2($response);
        //unset($response['hits']);


        return $response;
    }


    /**
     * Отдает товары и фильтр по заданным параметрам
     *
     * TODO отрефакторить, т.к. чтото слишком огромный
     *
     *
     * @param $params
     * @return array|bool
     */
    public function getFilteredProducts($params){

        //пробрасывается в контроллер из Pagination_beh.php
        $pagination = \Yii::$app->controller->pagination;

        if(!is_numeric($params['section_id']) || empty($params['section_id'])){
            return false;
        }


        $resultData = [];

        /** заполняем параметры для поика из ПОСТа(если он был) */
        $this->__setParamsFromPost($params);


        /** @var Cache $cache */
        $cache = \Yii::$app->cache;

        $totalFound = 0;

        $cacheKey = 'getFilterForSection'.$params['sectionId'];

        //if (!$filterData = $cache->get($cacheKey) || true){

        $filterDataForSection = $this->getFilterDataForSectionId($params);

        if( isset($filterDataForSection['hits']['total']) ){
            $totalFound = $filterDataForSection['hits']['total'];

            $pagination['totalCount'] = $filterDataForSection['hits']['total'];
        }


        foreach($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'] as &$oneFilter){

            $oneFilter['prop_name'] = $oneFilter['prop_name']['buckets'][0]['key'];
            $key = $oneFilter['key'];
            $filterData[$key] = $oneFilter;

            sort($oneFilter['prop_values']['buckets']);

        }


        //почистим ненужные агрегации из памяти
        unset($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets']);

        //Устанавливаем зависимость кеша от кол-ва записей в таблице
        //$dependency = new \yii\caching\DbDependency(['sql' => 'SELECT COUNT(*) FROM {{%tag_post}}']);
        //$cache->set($cacheKey, $filterData, $this->cacheTime);
        //}


        //\Yii::$app->pr->print_r2($filterData);

        /** сборка для уже выбранных параметров фильтра */
        //\Yii::$app->pr->print_r2($_POST);
        $appliedFilter = [];
        foreach ($_POST as $k=>$postData){
            if(empty($postData)) continue;

            if(isset($filterData[$k])){
                $appliedFilter[$k] = $postData;
            }

        }

        unset($_POST);

        //\Yii::$app->pr->print_r2($filterData);

        $appliedFilter = json_encode($appliedFilter, JSON_UNESCAPED_SLASHES);

        return
            [
                'products' => $filterDataForSection['hits']['hits'],
                'totalProductsFound' => $totalFound,
                'filterData' => $filterData,
                'appliedFilterJson' => $appliedFilter,
                'paginator' => $pagination

            ];
    }




    /**
     * Заполняет массив параметров для фильтра из POST-а (параметры по ссылке!)
     *
     * @param $params
     * @return bool
     */
    private function __setParamsFromPost(&$params){

        if(!is_numeric($params['section_id']) || empty($params['section_id'])){
            return false;
        }

        /** $searchParams формируем для того чтоб фильтровать по заполненному фильтру */
        $searchParams = [
            'section_id' => $params['section_id']
        ];

        /** При применении фильтра не кешируем @TODO может будем кешировать? */
        if( \Yii::$app->request->isPost){ //если был применен фильтр
            if( !empty( \Yii::$app->request->post('catalog_filter') ) ){

                //\Yii::$app->pr->print_r2(\Yii::$app->request->post() );
                //die();

                $fakes = [
                    '_csrf-frontend',
                    'perPage',
                    'catalog_filter',
                ];
                foreach(\Yii::$app->request->post() as $k => $postData){
                    if(in_array($k, $fakes)) continue;

                    if(!is_integer($k)) continue;

                    if(empty($postData)) continue;

                    $searchParams[$k] = $postData;

                }


            }
        }

        $params = $searchParams;

        return true;

    }


    //только для сохранения массива на будущее. не юзается
    private function justSave(){
        $params =[
            'body' =>[
                "query"=> [
                    "bool"=> [

                        /** обязательный блок (для ИД раздела ) */

                        "must"=> [

                            /** блок (для отдельного свойства ) */
                            /*[
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
    }
}