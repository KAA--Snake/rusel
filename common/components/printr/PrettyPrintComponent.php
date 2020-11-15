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

    public function printR2WOChecks($whatPrint) {
        ob_start();
        print_r2($whatPrint);
        $dump = ob_get_clean();
        echo $dump;
    }

    public function pre_dump($whatPrint) {
        if ($_COOKIE['dev']) {
            ob_start();
            call_user_func_array('var_dump', func_get_args());
            $dump = ob_get_clean();
            echo '<pre style="background:#fff; color:#070; text-align:left;">';
            echo preg_replace(["/]=>\n/", "/{\n *}/"], ["] =>\t", "{}"], $dump);
            echo '</pre>';

            //die();
        }

    }

    public function print_r($whatPrint){

        if ($_COOKIE['dev']) {
            ob_start();
            echo '<pre>';
                print_r($whatPrint);
            echo '</pre>';

            $dump = ob_get_clean();
            echo $dump;
        }
    }


    public function print_r2($whatPrint){
        if ($_COOKIE['dev']) {
            ob_start();
            $bcktrace = debug_backtrace();

            $filename = $bcktrace[0]['file'];
            $line = $bcktrace[0]['line'];
            //$functionName = $bcktrace[0]['function'];

            $textInfo = 'Called PRINT_R2 in ' . $filename . ' >>> ' . ' at line: ' . $line . '<br />';
            echo $textInfo;
            print_r2($whatPrint);

            $dump = ob_get_clean();
            echo $dump;
        }
    }

    public function die() {
        if ($_COOKIE['dev']) {
            ob_start();
            $bcktrace = debug_backtrace();

            $filename = $bcktrace[0]['file'];
            $line = $bcktrace[0]['line'];
            //$functionName = $bcktrace[0]['function'];

            $textInfo = 'Called DIE in ' . $filename . ' >>> ' . ' at line: ' . $line;

            echo $textInfo;
            $dump = ob_get_clean();
            echo $dump;
            die();
        }
    }

}