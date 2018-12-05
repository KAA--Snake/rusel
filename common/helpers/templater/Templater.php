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


    public static function makeSubstitution($text, $artikle, $manufacturer)
    {
        $text = preg_replace('/{artikle}/i', $artikle, $text);

        $text = preg_replace('/{manufacturer}/', $manufacturer, $text);

        return $text;
    }

}