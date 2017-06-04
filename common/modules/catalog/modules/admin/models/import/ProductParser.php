<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 04.06.2017
 * Time: 21:29
 */

namespace common\modules\catalog\modules\admin\models\import;


class ProductParser
{

    function object2array($object) { return @json_decode(@json_encode($object),1); }

    public function parsePrices(&$block){
        $parsed = [];
        if(count($block) > 0){

            foreach($block as $singles){

                foreach($singles as $single){
                    echo '<br /> TagValue = '. $single[0];

                    //сохраняем значение тега
                    $parsed['value'] = $single[0];

                    foreach($single->attributes() as $attrName=>$attrValue ){
                        echo '<br /> $attrName = '. $attrName;
                        echo '<br /> $attrValue = '. $attrValue;
                    }

                }
            }
        }

        return $parsed;
    }




    public function parseMarketing(&$block){
        if(count($block) > 0){

            foreach($block as $singles){

                foreach($singles as $single){
                    echo '<br /> TagValue = '. $single[0];


                    foreach($single->attributes() as $attrName=>$attrValue ){
                        echo '<br /> $attrName = '. $attrName;
                        echo '<br /> $attrValue = '. $attrValue;
                    }

                }

            }
        }
    }


}