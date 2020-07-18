<?php
/**
 * print_r2
 */
namespace common\components\printr;


use yii\base\Component;
include_once 'print_r.php';

class PrettyPrintComponent extends Component
{
    public function init(){
        parent::init();
    }


    public function print_r2($whatPrint){
        if ($_COOKIE['dev']) {
            $bcktrace = debug_backtrace();

            $filename = $bcktrace[0]['file'];
            $line = $bcktrace[0]['line'];
            //$functionName = $bcktrace[0]['function'];

            $textInfo = 'Called PRINT_R2 in ' . $filename . ' >>> ' . ' at line: ' . $line . '<br />';
            echo $textInfo;
            print_r2($whatPrint);


        }
    }

    public function die() {
        if ($_COOKIE['dev']) {
            $bcktrace = debug_backtrace();

            $filename = $bcktrace[0]['file'];
            $line = $bcktrace[0]['line'];
            //$functionName = $bcktrace[0]['function'];

            $textInfo = 'Called DIE in ' . $filename . ' >>> ' . ' at line: ' . $line;

            die($textInfo);
        }
    }

}