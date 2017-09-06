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
        $hrefTotal = $this->getHref($total_pages);

        if($total_pages >= 5){
            $pagePlus1 = $currentPage + 1;
            $pagePlus2 = $currentPage + 2;
            $pagePlus3 = $currentPage + 3;
            $pagePlus4 = $currentPage + 4;

            $pageMinus1 = $currentPage - 1;
            $pageMinus2 = $currentPage - 2;
            $pageMinus3 = $currentPage - 3;
            $pageMinus4 = $currentPage - 4;

            if($currentPage == 1){
                echo '<li class="pagination_item active"><a href="'.$this->getHref(1).'">1</a></li>';
                echo '<li class="pagination_item"><a href="'.$this->getHref($pagePlus1).'">'.$pagePlus1.'</a></li>';
                echo '<li class="pagination_item"><a href="'.$this->getHref($pagePlus2).'">'.$pagePlus2.'</a></li>';
                echo '<li class="pagination_item"><a href="'.$this->getHref($pagePlus3).'">'.$pagePlus3.'</a></li>';

                echo '<li class="pagination_item">...</li>';
                echo '<li class="pagination_item"><a href="'.$this->getHref($total_pages).'">'.$total_pages.'</a></li>';

            }else{

                if($currentPage == 2){
                    echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus1).'">'.$pageMinus1.'</a></li>';
                    echo '<li class="pagination_item active"><a href="'.$this->getHref($currentPage).'">'.$currentPage.'</a></li>';
                    echo '<li class="pagination_item"><a href="'.$this->getHref($pagePlus1).'">'.$pagePlus1.'</a></li>';
                    echo '<li class="pagination_item"><a href="'.$this->getHref($pagePlus2).'">'.$pagePlus2.'</a></li>';

                    //не показываем ... если текущая страница + 2 меньше максимальной
                    if($pagePlus2 < $total_pages){
                        echo '<li class="pagination_item">...</li>';
                        echo '<li class="pagination_item"><a href="'.$this->getHref($total_pages).'">'.$total_pages.'</a></li>';
                    }

                }else if($currentPage > 2){

                    //если выбранная страница помещается в последние 4 значения
                    if($currentPage+3 >= $total_pages){

                        for($i=$currentPage; $i <= $total_pages; $i++){
                            $href = $this->getHref($i);

                            if($currentPage == $i){ //строим от текущей выбранной страницы
                                if($currentPage + 1 == $total_pages){
                                    //echo 'if $currentPage + 1 == $total_pages';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref(1).'">1</a></li>';
                                    echo '<li class="pagination_item">...</li>';
                                    //echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus3).'">'.$pageMinus3.'</a></li>';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus2).'">'.$pageMinus2.'</a></li>';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus1).'">'.$pageMinus1.'</a></li>';

                                }else if($currentPage < $total_pages){
                                    //echo 'if $currentPage < $total_pages';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref(1).'">1</a></li>';
                                    echo '<li class="pagination_item">...</li>';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus2).'">'.$pageMinus2.'</a></li>';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus1).'">'.$pageMinus1.'</a></li>';

                                }else{
                                    //echo 'else';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref(1).'">1</a></li>';
                                    echo '<li class="pagination_item">...</li>';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus3).'">'.$pageMinus3.'</a></li>';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus2).'">'.$pageMinus2.'</a></li>';
                                    echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus1).'">'.$pageMinus1.'</a></li>';

                                }

                                echo '<li class="pagination_item active"><a href="">'.$i.'</a></li>';
                            }else{
                                echo '<li class="pagination_item"><a href="'.$href.'">'.$i.'</a></li>';
                            }
                        }

                    }else{//если выбранная страница НЕ помещается в последние 5 значений
                        //echo 'если выбранная страница НЕ помещается в последние 5 значений';

                        if($currentPage - 2 > 1){//если текущая страница - 2 будет больше 1, значит нужно многоточие назад
                            //echo 'если текущая страница - 2 будет больше 1';
                            echo '<li class="pagination_item"><a href="'.$this->getHref(1).'">1</a></li>';
                            echo '<li class="pagination_item">...</li>';
                            echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus2).'">'.$pageMinus2.'</a></li>';
                            echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus1).'">'.$pageMinus1.'</a></li>';
                            echo '<li class="pagination_item active"><a href="'.$this->getHref($currentPage).'">'.$currentPage.'</a></li>';
                            echo '<li class="pagination_item"><a href="'.$this->getHref($pagePlus1).'">'.$pagePlus1.'</a></li>';
                            echo '<li class="pagination_item"><a href="'.$this->getHref($pagePlus2).'">'.$pagePlus2.'</a></li>';
                        }else{//значит нужно многоточие назад не нужно

                            echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus2).'">'.$pageMinus2.'</a></li>';
                            echo '<li class="pagination_item"><a href="'.$this->getHref($pageMinus1).'">'.$pageMinus1.'</a></li>';
                            echo '<li class="pagination_item active"><a href="'.$this->getHref($currentPage).'">'.$currentPage.'</a></li>';
                            echo '<li class="pagination_item"><a href="'.$this->getHref($pagePlus1).'">'.$pagePlus1.'</a></li>';
                            echo '<li class="pagination_item"><a href="'.$this->getHref($pagePlus2).'">'.$pagePlus2.'</a></li>';
                        }

                        //не показываем ... если текущая страница + 2 меньше максимальной
                        if($pagePlus2 < $total_pages){
                            echo '<li class="pagination_item">...</li>';
                            echo '<li class="pagination_item"><a href="'.$this->getHref($total_pages).'">'.$total_pages.'</a></li>';
                        }

                    }
                }
            }

        }else{
            //здесь пагинатор с меньшим чем 4 кол-вом макс страниц
            for($i=1; $i <= $total_pages; $i++){
                $href = $this->getHref($i);
                if($currentPage == $i){
                   echo '<li class="pagination_item active"><a href="">'.$i.'</a></li>';
               }else{
                   echo '<li class="pagination_item"><a href="'.$href.'">'.$i.'</a></li>';
               }
            }
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



    function run3(){

        $per_page = 2;

        $total_pages = ceil($this->pagination['totalCount'] / $this->pagination['max_elements_cnt']);

        /** если всего 1 страница. то пагинатор не показываем*/
        if($total_pages <= 1) return;


        $page = $this->pagination['current_page'];//, текущая выбранная страница

        $prevPage = $currentPage - 1;
        $nextPage = $currentPage + 1;


        $adjacents = 0;

        $prevlabel = "&lsaquo; Prev";
        $nextlabel = "Next &rsaquo;";
        $lastlabel = "Last &rsaquo;&rsaquo;";

        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $per_page;

        $prev = $page - 1;
        $next = $page + 1;

        //$lastpage = ceil($total_pages/$per_page);
        $lastpage = $total_pages;

        $lpm1 = $lastpage - 1; // //last page minus 1

        $pagination = "";
        if($lastpage > 1){
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";

            if ($page > 1) $pagination.= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";

            if ($lastpage < 3 + ($adjacents * 2)){
                for ($counter = 1; $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                }

            } elseif($lastpage > 3 + ($adjacents * 2)){

                if($page < 1 + ($adjacents * 2)) {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>{$counter}</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                    $pagination.= "<li class='dot'>...</li>";
                    $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                    $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";

                } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                    $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                    $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                    $pagination.= "<li class='dot'>...</li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>{$counter}</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                    $pagination.= "<li class='dot'>..</li>";
                    $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                    $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";

                } else {

                    $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                    $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                    $pagination.= "<li class='dot'>..</li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>{$counter}</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }

            $pagination.= "</ul>";
        }

        echo $pagination;
    }

}