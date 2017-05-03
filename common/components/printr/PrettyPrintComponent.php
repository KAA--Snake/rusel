<?php
/**
 * print_r2
 */
namespace yii\components\printr;


use yii\base\Component;
include_once 'print_r.php';

class PrettyPrintComponent extends Component
{
    public function init(){
        parent::init();
    }


    public function print_r2(&$whatPrint){
        print_r2($whatPrint);
    }

}