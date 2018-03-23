<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.17
 * Time: 14:38
 */

namespace common\modules\catalog\models;


use yii\db\ActiveRecord;

class Slider extends ActiveRecord
{


    public static function tableName()
    {
        return 'public.slider';
    }


    public function rules()
    {
        return [
            [
                [
                    'slide_url',
                    'big_img_src',
                    'small_img_src',
                 ],
                'string'
            ],
            [['id','big_img_width', 'big_img_height', 'small_img_width', 'small_img_height'], 'integer'],
        ];
    }


    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        /**
         *  @TODO Здесь надо генерить миникартинку
         * пока что миникартинка = большой картинке
         *
         */
        if(empty($this->small_img_src)){

            $this->small_img_src = $this->big_img_src;
        }
        //\Yii::$app->pr->print_r2($insert);

        // ...custom code here...
        return true;
    }



}