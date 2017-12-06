<?php
/**
 * Контроллер для импорта и elastic поиска по товарам
 */
namespace frontend\controllers;

//set_time_limit(0);

use yii\web\Controller;

class SearchController extends Controller
{


    public $layout = 'searchFullWidth';


    public function behaviors()
    {
        return [

            'manufacturers' => [
                'class' => 'common\modules\catalog\behaviours\Manufacturers_beh',
                /*'in_attribute' => 'name',
                'out_attribute' => 'slug',
                'translit' => true*/
            ]
        ];
    }

    /**
     * Первая страница поиска (выводит шаблон поиска по списку артикулов (через файл)
     *
     * @return string
     */
    public function actionIndex(){



        if(!empty(Yii::$app->request->post())){
            return $this->render('listSearchLoaded', []);
        }

        return $this->render('listSearch', []);
    }

}