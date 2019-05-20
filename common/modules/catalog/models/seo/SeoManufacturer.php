<?php
/**
 * Created by PhpStorm.
 * User: Serg S
 * Date: 09.11.19
 * Time: 14:38
 */

namespace common\modules\catalog\models\seo;

use yii\base\Model;
use yii\db\ActiveRecord;


class SeoManufacturer extends ActiveRecord
{

    public static function tableName()
    {
        return 'public.seo_manufacturers';
    }

    public function rules()
    {
        return [
            [['text', 'name'],'string'],
            [['id','manufacturer_id'], 'integer'],
        ];
    }


    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if(!empty($this->text)) {
            $this->text = htmlentities($this->text);
        }
        return true;
    }


    public function __get($name) {
        switch ($name ) {
            case 'text':
                return html_entity_decode($this->getAttribute('text'));
                break;
        }

        return parent::__get($name);
    }


    public function saveMe(){
        $model = $this;

        //\Yii::$app->pr->print_r2($model->getAttributes());
        //die();
        $attributes = [
            'text' => $model->text,
            'name' => $model->name,
            'manufacturer_id' => $model->manufacturer_id,
        ];

        //если обновляем запись, то подменяем текущую модель той которую обновляем
        if(isset($model->id) && $model->id > 0 && !empty($model->id)){
            $model = self::findOne($model->id);
        }else if(isset($model->manufacturer_id) && $model->manufacturer_id > 0 && !empty($model->manufacturer_id)){
            $searchForUpsert = self::findOne(['manufacturer_id' => $model->manufacturer_id]);

            if (!empty($searchForUpsert)) {
                $model = $searchForUpsert;
            } else {
                //SiC bug null != empty...
                unset($model->id);
            }
        } else {
            //SiC bug null != empty...
            unset($model->id);
        }

        //\Yii::$app->pr->print_r2($model->getAttributes());
        //die();
        $model->setAttributes($attributes);

        try {
            $model->save();
        } catch (\Exception $e) {
            $model->addError($model->id, $e->getMessage());
        }

        return $model;

    }

}