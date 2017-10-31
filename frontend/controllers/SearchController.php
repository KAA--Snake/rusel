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




    /**
     * Первая страница поиска (выводит шаблон поиска по списку артикулов (через файл)
     *
     * @return string
     */
    public function actionIndex(){

        return $this->render('listSearch', []);
    }

}