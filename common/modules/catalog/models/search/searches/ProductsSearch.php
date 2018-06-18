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

    private $savedFilter;
    private $isEmptyResult = false; //свитч для пустого результата поиска

    /** Массив для названий главных свойств (не лежащих в nested) */
    private $mainProps = [
        'manufacturer'
    ];


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
        //\Yii::$app->pr->print_r2($searchParams);

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


            /** Если пришли фильтры по другим параметрам, кроме свойств */
            if(in_array($propId, $this->mainProps)){

                $must[] = [
                    "terms"=> [
                        "properties.proizvoditel"=> $propValue
                    ]
                ];

                unset($searchParams[$propId]);
                continue;
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
                    ],
                    'manufacturers_agg' =>[
                        "terms"=> [
                            "field"=> "properties.proizvoditel",
                            "size"=> 5000,
                            "order"=> ["_term" => "asc"]
                        ],
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
        //die();
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
    public function getFilteredProducts($params, $getAll = false){

        //$filter = \Yii::$app->session->get('saved_filter');
        //\Yii::$app->pr->print_r2((array)json_decode($filter));

        //var_dump($filter);

        //пробрасывается в контроллер из Pagination_beh.php
        $pagination = \Yii::$app->controller->pagination;

        if(!is_numeric($params['section_id']) || empty($params['section_id'])){
            return false;
        }


        $resultData = [];

	    $filterDataForSection = $this->getFilterDataForSectionId($params);

	    $allFilterDataProps = $this->_getProps($filterDataForSection);
	    $allManufacturers = $this->_getManufacturers($filterDataForSection);

        /** заполняем параметры для поика из ПОСТа(если он был) */
        if(!$getAll){
            $this->__setParamsFromPost($params);
        }

	    /** @var Cache $cache */
        $cache = \Yii::$app->cache;

        $totalFound = 0;

        $cacheKey = 'getFilterForSection'.$params['sectionId'];

        //if (!$filterDataForSection = $cache->get($cacheKey) || true){

        /** делаем запрос на выборку */
        $filterDataForSection = $this->getFilterDataForSectionId($params);


        /** собираем отфильтрованные товары */
        if( isset($filterDataForSection['hits']['total']) ){
            $totalFound = $filterDataForSection['hits']['total'];

            $pagination['totalCount'] = $filterDataForSection['hits']['total'];
        }


        /**  собираем свойства товаров */
	    $filterData = $this->_getProps($filterDataForSection);


        /**  собираем производителей */
	    $filteredManufacturers = $this->_getManufacturers($filterDataForSection);




        //почистим ненужные агрегации из памяти
        unset($filterDataForSection['aggregations']);

        //Устанавливаем зависимость кеша от кол-ва записей в таблице
        //$dependency = new \yii\caching\DbDependency(['sql' => 'SELECT COUNT(*) FROM {{%tag_post}}']);
        //$cache->set($cacheKey, $filterData, $this->cacheTime);
        //}




        /*\Yii::$app->pr->print_r2($_POST);
        \Yii::$app->pr->print_r2($manufacturers);
        \Yii::$app->pr->print_r2($filterData);*/

        /** сборка для уже выбранных параметров фильтра */
        $appliedFilter = [];
        if(count(\Yii::$app->request->post()) > 0){
            foreach (\Yii::$app->request->post() as $k=>$postData){
                if(empty($postData)) continue;

                if(in_array($k, $this->mainProps)){
                    $appliedFilter['manufacturer'] = $postData;
                }

                if(isset($allFilterDataProps[$k])){
                    $appliedFilter[$k] = $postData;
                }

            }
        }



        //\Yii::$app->pr->print_r2($filterData);
        //если был выбран фильтр, но ничего не найдено, покажем уведомление
        if( !empty( \Yii::$app->request->post('catalog_filter') ) ){

            if($totalFound == 0){
	            //если результат поиска нулевой - обнулим все значения
	            $this->isEmptyResult = true;
            }

            /*if(count($appliedFilter) == 0){
                $isEmptyFilter = true;
            }*/
        }

        //переставляем производителя в начало массива
/*        if(isset($appliedFilter['manufacturer'])){
            $manufacturerPop['manufacturer'] = $appliedFilter['manufacturer'];
            unset($appliedFilter['manufacturer']);

            $appliedFilter = $manufacturerPop+$appliedFilter;

        }*/

        //unset($_POST);

        //\Yii::$app->pr->print_r2($appliedFilter);

        $appliedFilter = json_encode($appliedFilter, JSON_UNESCAPED_SLASHES);

	    //\Yii::$app->pr->print_r2($allFilterDataProps);
	    /**
	     * производим добавление пустых значений для фильтра
	     * (полный фильтр + найденные)
	     */
	    //добавим пустые значения для выбранного фильтра
	    $this->_addEmptyProps($allFilterDataProps, $filterData);
	    /*\Yii::$app->pr->print_r2($pagination);
	    \Yii::$app->pr->print_r2($allManufacturers);
	    \Yii::$app->pr->print_r2($filterDataForSection);
	    die();*/
		//unset($allFilterDataProps);

	    //добавим пустые значения для выбранного фильтра по производителям
	    $this->_addEmptyManufacturers($allManufacturers, $filteredManufacturers);

	    static::setAccessoriedProds($filterDataForSection);

        return
            [
                'products' => $filterDataForSection['hits']['hits'],
                'totalProductsFound' => $totalFound,
                'filterData' => $allFilterDataProps,
                'appliedFilterJson' => $appliedFilter,
                'paginator' => $pagination,
                'emptyFilterResult' => $this->isEmptyResult,
                'filterManufacturers' => $allManufacturers,

            ];
    }

	/**
	 * Прикручивает к выборке связанные товары
	 *
	 * EXTENDED версия для отфильтрованных товаров !
	 *
	 * @param $productsList
	 * @return bool
	 */
	public static function setAccessoriedProds(&$productsList){
		// \Yii::$app->pr->print_r2($productsList);
		foreach($productsList['hits']['hits'] as &$oneProduct){

			//\Yii::$app->pr->print_r2($oneProduct);

			if(!empty($oneProduct['_source']['properties']['prinadlejnosti'])){

				$ids = explode(';', $oneProduct['_source']['properties']['prinadlejnosti']);
				//\Yii::$app->pr->print_r2($ids);
				$params = [
					'body' => [
						//'from' => 0,
						//'size' => 3,
						'query' => [
							'ids' => [
								'values' => $ids
							]
						]
					]
				];

				$params = Product::productData + $params;
				$response = Elastic::getElasticClient()->search($params);

				/*\Yii::$app->pr->print_r2($params);
				\Yii::$app->pr->print_r2($response);*/
				$oneProduct['_source']['accessories'] = $response['hits']['hits'];

			}
		}

		return true;
	}



	/**
	 * Получает список товаров по списку их производителей
	 * properties.proizv_id
	 *
	 * @param $manufacturersIds
	 * @return array
	 * @internal param $manufacturersList
	 */
	public function getProductByManufacturer($manufacturersIds){

		if(count($manufacturersIds) <= 0){
			return [];
		}

		//пробрасывается в контроллер из Pagination_beh.php
		$pagination = \Yii::$app->controller->pagination;
		//\Yii::$app->pr->print_r2($pagination);

		$params = [
			'body' => [
				'from' => $pagination['from'],
				'size' => $pagination['maxSizeCnt'],
				'sort' => [
					'artikul' => ['order' => 'asc']
				],
				'query' => [
					'constant_score' => [
						'filter' => [
							'terms' => [
								'properties.proizv_id' => $manufacturersIds
							]
						]
					]
				],
			]
		];

		$params = Product::productData + $params;

		//\Yii::$app->pr->print_r2($params);

		$response = Elastic::getElasticClient()->search($params);

		$pagination['totalCount'] = $response['hits']['total'];

		//$response['productsList'] = $response['hits']['hits'];

		$this->_setSingleStorageAsMulti($response);

		$this->_setSinglePriceAsMulty($response);

		$response['paginator'] = $pagination;

		//добавляем аксессуары к продуктам
		$this->setAccessoriedProds($response);


		return $response;
	}


	/**
	 * Приводит один склад к виду массива. Нужен для выпиливания кучи проверок в шаблонах
	 *
	 * @param $response
	 *
	 * @return bool
	 */
	private function _setSingleStorageAsMulti(&$response){
		foreach ($response['hits']['hits'] as $k => $oneProduct){

			/** Если склад один, то приведем его к массиву, чтобы не гемороиться дальше */
			if($oneProduct['_source']['prices']['stores'] == 1 || $oneProduct['_source']['prices']['stores'] == 0){
				$singleStorage = $oneProduct['_source']['prices']['storage'];
				unset($response['hits']['hits'][$k]['_source']['prices']['storage']);
				$response['hits']['hits'][$k]['_source']['prices']['storage'][] = $singleStorage;
				unset($singleStorage);
			}

		}

		return true;
	}

	/**
	 * Приводит цену к виду массива. Нужен для выпиливания кучи проверок в шаблонах
	 *
	 * @param $response
	 *
	 * @return bool
	 */
	private function _setSinglePriceAsMulty(&$response){

		foreach ($response['hits']['hits'] as $k => &$oneProduct){

			if(!empty($oneProduct['_source']['prices']['storage'])){
				foreach($oneProduct['_source']['prices']['storage'] as $storageK => &$oneStorage){
					if(!empty($oneStorage['prices']['price_range'])){

						//если есть, значит надо привести к массиву
						if(!empty($oneStorage['prices']['price_range']['currency'])){

							$singlePrice = $oneStorage['prices']['price_range'];

							unset($oneStorage['prices']);

							$oneStorage['prices']['price_range'][] = $singlePrice;
							unset($singlePrice);

						}
					}
				}
			}

		}

		return true;
	}

	/**
	 * Отдает список товаров по их ИДам
	 *
	 * @param $ids
	 * @return array
	 */
	public function getProductsByIds($ids=[]){

		if(count($ids) <= 0){
			return [];
		}
		$pagination = [];
		$pagination['from'] = 0;
		$pagination['maxSizeCnt'] = 50000;


		if(isset(\Yii::$app->controller->pagination) && !empty(\Yii::$app->controller->pagination)){
			$pagination = \Yii::$app->controller->pagination;
		}


		$params = [
			'body' => [
				'from' => $pagination['from'],
				'size' => $pagination['maxSizeCnt'],
				'sort' => [
					'artikul' => ['order' => 'asc']
				],
				'query' => [
					'constant_score' => [
						'filter' => [
							'terms' => [
								'id' => $ids
							]
						]
					]
				]
			]
		];

		$params = Product::productData + $params;
		//\Yii::$app->pr->print_r2($params);
		//die();
		$response = Elastic::getElasticClient()->search($params);

		//\Yii::$app->pr->print_r2($response);

		//$response = Elastic::getElasticClient()->search($params)['hits']['hits'];

		$this->_setSingleStorageAsMulti($response);

		$this->_setSinglePriceAsMulty($response);
		//добавляем аксессуары к продуктам
		$this->setAccessoriedProds($response);


		return $response['hits'];
	}


	/**
	 * Получает товар по его св-ву url
	 *
	 * @param $productUrl
	 * @return bool
	 */
	public function getProductByUrl($productUrl)
	{

		$url = str_replace('/', '|', $productUrl);

		$params = [
			'body' => [
				//'from' => 0,
				//'size' => 3,
				'query' => [
					'term' => [
						'url' => $url
					]
				]
			]
		];


		$json = '{
            "from" : 0,
            "size" : 3,
            "query" : {
                "term" : {
                    "uri" : "'.$url.'"
                }
            }
        }';

		/*$params = [
			'body' => $json
		];*/

		//\Yii::$app->pr->print_r2($params);
		//\Yii::$app->pr->print_r2($response);
		// die();
		//print_r($response);

		$params = Product::productData + $params;

		$response = Elastic::getElasticClient()->search($params);

		/*\Yii::$app->pr->print_r2($params);
		\Yii::$app->pr->print_r2($response);
		die();*/

		if(!empty($response['hits']['hits'][0]['_source']) && isset($response['hits']['hits'][0]['_source'])){

			$this->_setSingleStorageAsMulti($response);

			$this->_setSinglePriceAsMulty($response);

			/** заполним аксессуарами (если они есть) */
			$this->setAccessoriedProds($response);
			return $response['hits']['hits'][0]['_source'];
		}

		return false;

	}

	/**
	 * Проходит по всем товарам корзины и убирает из них не относящиеся к ним склады
	 */
	public function removeCartStorages(&$products, $cartStorages){

		/** Пройдем по всем записям и удалим те скалды, которые не были в покупках */
		foreach ($products as &$oneCartProduct){

			if($oneCartProduct['_source']['prices']['stores'] == 0){
				unset($oneCartProduct['_source']['prices']['storage']);
				continue;
			}
			//\Yii::$app->pr->print_r2($cartStorages);
			//\Yii::$app->pr->print_r2($oneCartProduct);

			$storagesForCurrentProduct = $cartStorages[$oneCartProduct['_source']['id']];

			//пройдем по складам
			foreach($oneCartProduct['_source']['prices']['storage'] as $k => $oneStorage){
				if( !in_array(  $oneStorage['id'],  $storagesForCurrentProduct   ) ){
					unset($oneCartProduct['_source']['prices']['storage'][$k]);
				}
			}

		}

		return true;
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
                $filterData = \Yii::$app->request->post();
            }
        }



        if(!empty($filterData)){

            $fakes = [
                '_csrf-frontend',
                'perPage',
                'catalog_filter',
                'from',
            ];
            foreach($filterData as $k => $postData){


                if(in_array($k, $fakes)) continue;

                //if(!is_integer($k)) continue;

                if(empty($postData)) continue;

                $searchParams[$k] = $postData;
            }
        }



        //\Yii::$app->pr->print_r2($searchParams );
        $params = $searchParams;

        return true;

    }


    /**
     *
     * Получает все товары и фильтры (без обработки поискового запроса)
     *
     * @param $params
     * @return array|bool
     */
    public function getAllDataForFilter($params){

        //пробрасывается в контроллер из Pagination_beh.php
        $pagination = \Yii::$app->controller->pagination;

        if(!is_numeric($params['section_id']) || empty($params['section_id'])){
            return false;
        }

        $resultData = [];

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
        if(count($_POST) > 0){
            foreach ($_POST as $k=>$postData){
                if(empty($postData)) continue;

                if(isset($filterData[$k])){
                    $appliedFilter[$k] = $postData;
                }

            }
        }


        //если был выбран фильтр, но ничего не найдено, покажем уведомление
        $isEmptyFilter = false;
        if( !empty( \Yii::$app->request->post('catalog_filter') ) ){
            if(count($appliedFilter) == 0){
                $isEmptyFilter = true;
            }
        }

        //unset($_POST);

        //\Yii::$app->pr->print_r2($appliedFilter);

        $appliedFilter = json_encode($appliedFilter, JSON_UNESCAPED_SLASHES);




        return
            [
                'products' => $filterDataForSection['hits']['hits'],
                'totalProductsFound' => $totalFound,
                'filterData' => $filterData,
                'appliedFilterJson' => $appliedFilter,
                'paginator' => $pagination,
                'emptyFilterResult' => $isEmptyFilter

            ];
    }

	/**
	 * Создает массив значений для свойств, индексированный ИДами свойств.
	 *
	 * @param $buckets
	 *
	 * @return array
	 */
    private function _getProps(&$filterDataForSection){

	    /**  собираем свойства товаров */
	    foreach($filterDataForSection['aggregations']['properties_agg']['sub_agg']['buckets'] as &$oneFilter){
		    //if ($oneFilter['key'] != 15) continue;

		    $oneFilter['prop_name'] = $oneFilter['prop_name']['buckets'][0]['key'];
		    $key = $oneFilter['key'];
		    $filterData[$key] = $oneFilter;

		    sort($oneFilter['prop_values']['buckets']);

	    }
	    unset($oneFilter);

    	return $filterData;
    }


	/**
	 * Создает массив значений для свойств, индексированный ИДами свойств.
	 *
	 * @param $buckets
	 *
	 * @return array
	 */
	private function _getManufacturers(&$filterDataForSection){

		/**  собираем производителей */
		$manufacturers = [];
		foreach($filterDataForSection['aggregations']['manufacturers_agg']['buckets'] as $oneFilter){
			$manufacturers[] = $oneFilter;
		}
		sort($manufacturers);
		//\Yii::$app->pr->print_r2($manufacturers);


		return $manufacturers;
	}


	/**
	 * Добавляет пустые значения из $fullFilterData к уже заполненным свойствам $filteredData.
	 *
	 * пройдемся по полному фильтру и обнулим те значения, которых нет в выбранном фильтре.
	 * а те что есть- заменим doc_count на те, что были в выбранном
	 *
	 * @param $fullFilterData
	 * @param $filteredData
	 *
	 * @return bool
	 */
    private function _addEmptyProps(&$fullFilterData, &$filteredData){

    	//если товары не найдены, но фильтрации не было (фильтр по сути не использовался))
    	if(!$filteredData && !$this->isEmptyResult) return false;

	    foreach ( $fullFilterData as $propId => $full_filter_datum ) {

		    //пройдемся по полному фильтру и обнулим те значения, которых нет в выбранном фильтре.
		    foreach($full_filter_datum['prop_values']['buckets'] as $mainPropKey => $oneFullProperty){

		    	//обнулим те значения, которых нет в выбранном фильтре.
			    $fullFilterData[$propId]['prop_values']['buckets'][$mainPropKey]['doc_count'] = 0;

			    //если результат поиска нулевой - обнулим все значения
			    if($this->isEmptyResult) continue;

			    //а те что есть- заменим doc_count на те, что были в выбранном
		    	foreach($filteredData[$propId]['prop_values']['buckets'] as $onePickedProperty){
					if($oneFullProperty['key'] == $onePickedProperty['key']){
						$fullFilterData[$propId]['prop_values']['buckets'][$mainPropKey]['doc_count'] = $onePickedProperty['doc_count'];
					}
			    }

		    }

	    }

    	return true;
    }



	/**
	 * Добавляет пустые значения из $fullFilterData к уже заполненным свойствам $filteredData.
	 *
	 * пройдемся по полному фильтру и обнулим те значения, которых нет в выбранном фильтре.
	 * а те что есть- заменим doc_count на те, что были в выбранном
	 *
	 * @param $allManufacturers
	 * @param $filterManufacturers
	 *
	 * @return bool
	 */
	private function _addEmptyManufacturers(&$allManufacturers, &$filterManufacturers){

		//если товары не найдены, но фильтрации не было (фильтр по сути не использовался))
		if(!$filterManufacturers && !$this->isEmptyResult) return false;

		//пройдемся по полному фильтру и обнулим те значения, которых нет в выбранном фильтре.
		foreach ( $allManufacturers as $key => $full_filter_datum ) {

			//обнулим те значения, которых нет в выбранном фильтре.
			$allManufacturers[$key]['doc_count'] = 0;

			//если результат поиска нулевой - обнулим все значения
			if($this->isEmptyResult) continue;

			//а те что есть- заменим doc_count на те, что были в выбранном
			foreach($filterManufacturers as $onePickedProperty){

				if($full_filter_datum['key'] == $onePickedProperty['key']){
					$allManufacturers[$key]['doc_count'] = $onePickedProperty['doc_count'];
				}
			}


		}

		return true;
	}

}