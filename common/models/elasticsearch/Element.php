<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.05.2017
 * Time: 19:02
 */

namespace common\models\elasticsearch;


use yii\elasticsearch\ActiveRecord;

class Element extends ActiveRecord
{
    /**
     * Используем базу постгреса
     * @return mixed
     */
    /*public function getDb() {
        return Yii::$app->db;
    }*/


    public function attributes(){
        return [
            'id',
            'name',
            'quantity',
        ];
    }
    /*
        public function rules(){
            return ['name', 'surname'];
        }
    */

    /**
     * @return array This model's mapping
     */
    public static function mapping()
    {
        return [
            static::type() => [
                '_source' => ['enabled' => true],
                'properties' => [
                    'id'    => ['type' => 'integer'],
                    'quantity'    => ['type' => 'integer'],

                    'name'    => [
                        'type' => 'text',
                        //'analyzer' => 'simple',
                        'analyzer' => 'russian',
                        //'preserve_separators' => ['enabled' => true],
                    ],

                ]
            ],
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    /**
     * Create this model's index
     */
    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex(static::index(), [
            'settings' => static::__getSettings(),
            'mappings' => static::mapping(),
            //'warmers' => [  ],
            //'aliases' => [  ],
            //'creation_date' => '...'
        ]);
    }

    /**
     * Delete this model's index
     */
    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::index(), static::type());
    }



    public static function __getSettings(){
        return [

                "analysis"=> [

                    "filter"=> [
                        "russian_stop" => [
                            "type" =>       "stop",
                            "stopwords"=>  "_russian_"
                        ],/*
                        "keywords"=> [
                            "type"=>       "keyword_marker",
                            "keywords"=>   new \stdClass()
                        ],*/
                        /*
                        "russian_keywords"=> [
                            "type"=>       "keyword_marker",
                            "keywords"=>   new \stdClass()
                        ],*/
                        "russian_stemmer"=> [
                            "type"=>       "stemmer",
                            "language"=>   "russian"
                        ]
                    ],

                    "analyzer" => [
                        "russian" => [
                            "tokenizer" =>  "standard",
                            "filter" => [
                                "lowercase",
                                "russian_stop",
                                //"russian_keywords",
                                //"keywords",
                                "russian_stemmer",
                            ]
                        ]
                    ]

                ]

        ];

    }


}