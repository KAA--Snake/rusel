<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 12.04.2017
 * Time: 11:57
 */

namespace frontend\controllers;

use frontend\models\B_iblock_element;
use yii\data\Pagination;
use yii\web\HttpException;


class PostController extends AppController
{

    public $myNewVar; //для проброса в поведениях





    public function behaviors(){
       parent::behaviors();

       return [
           'PostBvr'=>[
               'class' => 'frontend\controllers\behaviours\PostBvr',
               'soveVar' => 'Эти данные будут проброшены в PostBvr'
           ]
       ];
   }



    public function actionList(){

       /* $posts = B_iblock_element::find()->joinWith('sections')
        ->where(['b_iblock_element.IBLOCK_SECTION_ID' => 24])
        ->all();*/

        //проброшенная через behaviours переменная
        $newVar = $this->myNewVar;

        //use pagination
        $query = B_iblock_element::find()->isActive()->joinWith('sections')
            ->andWhere(['b_iblock_element.IBLOCK_SECTION_ID' => 24]);

        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 2,
            'pageSizeParam' => false,
            'forcePageParam' => false,
        ]);

        //задаем смещение и лимит в зависимости от данных пришедших из пагинатора
        $posts = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        return $this->render('list', compact('posts', 'pages', 'newVar'));
    }



    //выводит одну статью
    public function actionShow(){
        $id = \Yii::$app->request->get('id');//получаем из реквеста параметр с именем id

        $onePost = B_iblock_element::findOne($id);

        if(!$onePost) throw new HttpException(404, 'Страницы не существует');

        return $this->render('show', compact('id', 'onePost'));
    }

}