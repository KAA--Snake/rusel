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
                    'id'    => [
                        'type' => 'integer',


                        /**
                         * ANALYZER НЕЛЬЗЯ ДОБАВЛЯТЬ К KEYWORD типу !!!!!!!
                         * */
                        //'analyzer' => 'simple',
                        //'analyzer' => 'autocomplete',
                        //'search_analyzer' => 'standard'
                        //"term_vector" => "yes",

                    ],
                    'quantity'    => ['type' => 'integer'],
                    'name'    => ['type' => 'text'],

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
            //'settings' => [],
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
}