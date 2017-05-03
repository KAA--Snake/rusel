<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 18.04.2017
 * Time: 17:31
 */

namespace common\models\elasticsearch;


class Customer extends \yii\elasticsearch\ActiveRecord
{

    public function attributes(){
        return ['name', 'surname'];
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
                    'name'           => [
                        //'type' => 'completion',/*, 'analyzer' => 'standard'*/
                        //'type' => 'text',
                        'type' => 'keyword',

                        /**
                         * The index analyzer to use, defaults to simple.
                         * In case you are wondering why we did not opt for the standard analyzer:
                         * We try to have easy to understand behaviour here, and if you index the field content
                         * At the Drive-in, you will not get any suggestions for a, nor for d (the first non stopword).
                         */
                        /**
                         * ANALYZER НЕЛЬЗЯ ДОБАВЛЯТЬ К KEYWORD типу !!!!!!!
                         * */
                        //'analyzer' => 'simple',
                        //'analyzer' => 'autocomplete',
                        //'search_analyzer' => 'standard'
                        //"term_vector" => "yes",



                        /**
                         * Preserves the separators, defaults to true.
                         * If disabled, you could find a field starting with Foo Fighters, if you suggest for foof.
                         */
                        //'preserve_separators' => ['enabled' => true],


                        /**
                         * Enables position increments, defaults to true.
                         * If disabled and using stopwords analyzer, you could get a field starting with The Beatles,
                         * if you suggest for b. Note: You could also achieve this by indexing two inputs,
                         * Beatles and The Beatles, no need to change a simple analyzer, if you are able to enrich your data.
                         */
                        //'preserve_position_increments' => ['enabled' => true],

                        /**
                         * Limits the length of a single input, defaults to 50 UTF-16 code points.
                         * This limit is only used at index time to reduce the total number of characters
                         * per input string in order to prevent massive inputs from bloating the
                         * underlying datastructure.
                         * Most usecases won’t be influenced by the default value since prefix completions seldom
                         * grow beyond prefixes longer than a handful of characters.
                         */
                        //'max_input_length' => 50
                    ],
                    'surname'    => ['type' => 'keyword'],
                    //'publisher_name' => ['type' => 'string'],
                    //'created_at'     => ['type' => 'long'],
                    //'updated_at'     => ['type' => 'long'],
                    //'status'         => ['type' => 'long'],
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