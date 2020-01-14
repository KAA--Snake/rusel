<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 21.06.2017
 * Time: 20:51
 */

namespace common\helpers\templater;


/**
 * templater helper class.
 */
class Templater
{

    private $templates = [
        'artikle',
        'manufacturer'
    ];


    public static function makeSubstitution(string $text, array $product)
    {
        $text = preg_replace('/{artikle}/i', $product['artikul'] ?? '', $text);

        $text = preg_replace('/{manufacturer}/i', $product['properties']['proizvoditel'] ?? '', $text);

        $text = preg_replace('/{name}/i', $product['name'] ?? '', $text);

        return $text;
    }

}