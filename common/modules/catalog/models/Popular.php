<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 16/04/2020
 * Time: 20^38
 */

namespace common\modules\catalog\models;


use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Popular extends ActiveRecord
{
    var $file;

    public static function tableName()
    {
        return 'public.popular';
    }


    public function rules()
    {
        $catalogModule = \Yii::$app->getModule('catalog');
        $popularConfig = $catalogModule->params['popular'];

        return [
            [
                [
                    'name',
                    'url',
                    'url',
                    'target',
                    'big_img_src',
                ],
                'string'
            ],
            [['date'], 'date', 'format' => 'd-m-Y'],
            [['file'],
                'file',
                //'skipOnEmpty' => false,
                'checkExtensionByMimeType' => false, //bug #6148
                //'extensions' => $allowedExtensions,
                'maxFiles' => 1],
            [
                [
                    'id',
                    'big_img_width',
                    'big_img_height',
                    'small_img_width',
                    'small_img_height',
                    'sort',
                    'html_width',
                    'html_height',
                ],
                'integer'
            ],

            [['sort'], 'default', 'value'=> 1],
            [['target'], 'default', 'value'=> '_blank'],
            [['html_width'], 'default', 'value'=> $popularConfig['default_img_width']],
            [['html_height'], 'default', 'value'=> $popularConfig['default_img_height']],
        ];
    }



    public function saveMe(){

        $model = $this;

        //\Yii::$app->pr->print_r2($model->getAttributes());
        //die();

        $attributes = [
            'name' => $model->name,
            'big_img_src' => $model->big_img_src,
            'sort' => $model->sort,
            'url' => $model->url,
            'target' => $model->target,
            'html_width' => $model->html_width,
            'html_height' => $model->html_height,
        ];


        //если обновляем запись, то подменяем текущую модель той которую обновляем
        if(isset($model->id) && $model->id > 0 && !empty($model->id)){
            $model = self::findOne($model->id);
        }else{
            //SiC bug null != empty...
            unset($model->id);
        }

        $model->setAttributes($attributes);

        $model->save();

        //\Yii::$app->pr->print_r2($model->getAttributes());
        //die();

        return $model;


    }

}