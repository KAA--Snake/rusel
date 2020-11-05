<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.05.2017
 * Time: 13:42
 */

namespace common\modules\catalog\modules\admin\models\export;

set_time_limit(0);
$start_time = microtime(true);

use common\modules\catalog\models\catalog_import\Import_log;
use common\modules\catalog\models\mongo\Product;
use common\modules\catalog\models\Section;
use yii\base\Model;


class CatalogExport extends Model
{
    public $enableCsrfValidation = false;

    public $section_id;
    public $manufacturer_id;

    public function rules()
    {
        //$catalogModule = \Yii::$app->getModule('catalog');

        return [
            //[['section_id'], 'required'],
            [['section_id'], 'integer'],
            [['manufacturer_id'], 'integer'],
            //[['m_name', 'm_text', 'm_group_ids'], 'string'],
            //[['m_id'], 'unique'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'section_id' => 'ИД раздела (ОБЯЗАТЕЛЬНО)',
            'manufacturer_id' => 'ИД производителя',
        ];
    }


    /**
     * Сам экспорт
     */
    public function export(){

        //TODO здесь будет экспорт

    }


}