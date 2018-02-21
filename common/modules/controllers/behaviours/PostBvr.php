<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 19.04.2017
 * Time: 12:48
 */

namespace frontend\controllers\behaviours;

use yii;
use yii\base\Behavior;

class PostBvr extends Behavior
{
    public $soveVar;

    public function events(){
        return [
            //вызываем событие ДО старта контроллера
            yii\web\Controller::EVENT_BEFORE_ACTION => 'myMethod'
        ];
    }

    public function myMethod( $event ){
        //var_dump($this->owner);
       // die();
        $this->owner->myNewVar = 'Выводим проброшенную переменную - ' .$this->soveVar;
    }

}