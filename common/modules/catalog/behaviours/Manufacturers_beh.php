<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.10.17
 * Time: 15:13
 */

namespace common\modules\catalog\behaviours;


use common\modules\catalog\models\Manufacturer;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\Controller;

class Manufacturers_beh extends Behavior
{
    public $in_attribute = 'name';
    public $out_attribute = 'slug';
    public $translit = true;

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'getAllManufacturers'
        ];
    }


    /**
     * Отдает список всех производителей
     *
     * @return array|ActiveRecord[]
     */
    public function getAllManufacturers($event){

        $manufacturersModel = new Manufacturer();
        $manufacturers = $manufacturersModel->getAllManufacturers();

        //\Yii::$app->pr->print_r2($manufacturers);

        $this->owner->view->params['manufacturers'] = $manufacturers;

        return $manufacturers;
    }

}