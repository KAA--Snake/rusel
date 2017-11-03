<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.11.17
 * Time: 15:19
 */

namespace common\modules\catalog\behaviours;

use yii\base\Behavior;
use yii\web\Controller;

class Pagination_beh extends Behavior
{

    public $maxSizeCnt;

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'setPagination'
        ];
    }

    public function setPagination(){

        $from = 0;
        $page = 1; //изначально первая страница

        $pagination = [];

        $perPagePicked = \Yii::$app->request->get('perPage');

        if(isset($perPagePicked) && $perPagePicked > 0){
            $this->maxSizeCnt = $perPagePicked;
        }

        $pagination['max_elements_cnt'] = $this->maxSizeCnt;
        $pagination['current_page'] = $page;
        //echo $pagination->offset;
        //\Yii::$app->pr->print_r2($pagination);
        //die();
        $pagePicked = \Yii::$app->request->get('page');

        $needPage = $pagePicked -1;

        if(isset($pagePicked) && $pagePicked > 0){

            //echo 'page = ' . $page . '<br />';
            //echo '$maxSizeCnt = ' . $maxSizeCnt . '<br />';
            $from = $needPage * $this->maxSizeCnt;

            //\Yii::$app->pr->print_r2($from);

            $pagination['current_page'] = $pagePicked;
        }
        //\Yii::$app->pr->print_r2($pagination);
        $pagination['from'] = $from;
        $pagination['maxSizeCnt'] = $this->maxSizeCnt;

        $this->owner->pagination = $pagination;

        return true;

    }
}