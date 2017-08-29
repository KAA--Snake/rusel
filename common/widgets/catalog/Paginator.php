<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\catalog;


use common\modules\catalog\models\Section;
use yii\base\Widget;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

class Paginator extends Widget
{

    public $pagination;


    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return  Html::tag('span', $label);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        //return '<a href="/cat/"></a>';
        //echo Url::current(['id' => 100]);
        //echo Url::current(['page' => null]);

        //$queryParams = \Yii::$app->request->setQueryParams($queryParams);

        //echo Url::to([Url::to(), 'page' => $page]);
        //\Yii::$app->pr->print_r2($pathinfo);
        //return Html::a($label, $this->pagination->createUrl($page), $linkOptions);
        return Html::a($label, $this->createUrl($page, $this->pagination), $linkOptions);
        //return Html::a($label, Url::to(['/'.$pathinfo, 'page' => $page]), $linkOptions);



        //return Html::a($label, "/cat/");
    }




    public function createUrl($page, $paginator, $pageSize = null, $absolute = false)
    {

        $page = (int) $page;
        $pageSize = (int) $pageSize;
        if (($params = $paginator->params) === null) {
            /*$request = \Yii::$app->getRequest();
            $params = $request instanceof Request ? $request->getQueryParams() : [];*/
            $params = \Yii::$app->request->getQueryParams();
        }

        if ($page > 0 || $page == 0 && $paginator->forcePageParam) {
            $params[$paginator->pageParam] = $page + 1;
        } else {
            unset($params[$paginator->pageParam]);
        }
        if ($pageSize <= 0) {
            $pageSize = $paginator->getPageSize();
        }
        if ($pageSize != $paginator->defaultPageSize) {
            $params[$paginator->pageSizeParam] = $pageSize;
        } else {
            unset($params[$paginator->pageSizeParam]);
        }
        $params[0] = $paginator->route === null ? \Yii::$app->controller->getRoute() : $paginator->route;
        $urlManager = $paginator->urlManager === null ? \Yii::$app->getUrlManager() : $paginator->urlManager;

        $pathinfo = \Yii::$app->request->getPathInfo();
        $queryParams = \Yii::$app->request->getQueryParams();

        unset($queryParams['pathForParse']);
        unset($queryParams[0]);

        $queryParams['page'] = $params[$paginator->pageParam];
        //\Yii::$app->pr->print_r2($_SERVER['QUERY_STRING']);
        //die();
        //$path = parse_url($pathinfo.'?'.$_SERVER['QUERY_STRING']);

        //parse_str($_SERVER['QUERY_STRING'], $res);

        //\Yii::$app->pr->print_r2($queryParams);
        $newQuery = urlencode(http_build_query($queryParams));
        $newQuery = http_build_query($queryParams);
        //\Yii::$app->pr->print_r2($newQuery);
        //return Url::to(['/'.$pathinfo.'?'.$newQuery]);
        return '/'.$pathinfo.'?'.$newQuery;


        return Url::toRoute(['/'.$pathinfo, $params]);

        return Url::toRoute(['/'.$pathinfo]);

        /*if ($absolute) {
            return $urlManager->createAbsoluteUrl($params);
        } else {
            return $urlManager->createUrl($params);
        }*/
    }

    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        return Html::tag('div', implode("\n", $buttons), $this->options);
    }


    protected function registerLinkTags(){
        $view = $this->getView();
        foreach ($this->pagination->getLinks() as $rel => $href) {
            $view->registerLinkTag(['rel' => $rel, 'href' => '/catalog/'], $rel);
        }
    }



    public function init()
    {
        parent::init();


        //yiiwebJqueryAsset::register($this->getView());
    }


    public function getHref($page=1){

        $pathinfo = \Yii::$app->request->getPathInfo();
        $queryParams = \Yii::$app->request->getQueryParams();

        unset($queryParams['pathForParse']);
        unset($queryParams[0]);



        $queryParams['page'] = $page;
        //\Yii::$app->pr->print_r2($_SERVER['QUERY_STRING']);
        //die();
        //$path = parse_url($pathinfo.'?'.$_SERVER['QUERY_STRING']);

        //parse_str($_SERVER['QUERY_STRING'], $res);

        //\Yii::$app->pr->print_r2($queryParams);
        $newQuery = urlencode(http_build_query($queryParams));
        $newQuery = http_build_query($queryParams);
        //\Yii::$app->pr->print_r2($newQuery);
        //return Url::to(['/'.$pathinfo.'?'.$newQuery]);
        $new_addr = '/'.$pathinfo.'?'.$newQuery;

        return $new_addr;
    }




    public function run()
    {


        $total_pages = ceil($this->pagination['totalCount'] / $this->pagination['max_elements_cnt']);

        /** если всего 1 страница. то пагинатор не показываем*/
        if($total_pages <= 1) return;


        $currentPage = $this->pagination['current_page'];//, текущая выбранная страница

        $prevPage = $currentPage - 1;
        $nextPage = $currentPage + 1;

        //\Yii::$app->pr->print_r2($prevPage);
        //\Yii::$app->pr->print_r2($nextPage);

        if($prevPage >= 1){
            $hrefPrevPage = $this->getHref($prevPage);
        }

        if($nextPage <= $total_pages){
            $hrefNextPage = $this->getHref($nextPage);
        }

        //'totalPages' => $total_pages, всего страниц
        //'totalElementsCount' => $this->pagination['totalCount'], общее кол-во элементов

?>
<div class="pagination_block">
    <ul class="pagination_list">

        <? if(isset($hrefPrevPage)) {?>
            <li class="pagination_item prev"><a href="<?=$hrefPrevPage;?>"></a></li>
        <?}?>

        <?
        $counter = 1;
        //for($i=$currentPage; $i <= $total_pages; $i++){
        for($i=1; $i <= $total_pages; $i++){

            $href = $this->getHref($i);

            if($currentPage == $i){
                echo '<li class="pagination_item active"><a href="">'.$i.'</a></li>';
            }else{
                echo '<li class="pagination_item"><a href="'.$href.'">'.$i.'</a></li>';
            }

            /*
            if($counter <= 3){

                if($this->pagination['current_page'] == $i){
                    echo '<li class="pagination_item active"><a href="">'.$i.'</a></li>';
                }else{
                    echo '<li class="pagination_item"><a href="">'.$i.'</a></li>';
                }


            }else{
                echo '<li class="pagination_item">...</li>';
                echo '<li class="pagination_item"><a href="">'.$total_pages.'</a></li>';

                break;
            }*/


            $counter++;
        }
?>
        <? if(isset($hrefNextPage)) {?>
            <li class="pagination_item next"><a href="<?=$hrefNextPage;?>"></a></li>
        <?}?>
    </ul>
</div>

<?
        //\Yii::$app->pr->print_r2($total_pages);

        return;


        return $this->render('catalog_paginator', [
            'totalPages' => $total_pages,
            'totalElementsCount' => $this->pagination['totalCount'],
            'currentPage' => $this->pagination['current_page'],
        ]);
    }
}