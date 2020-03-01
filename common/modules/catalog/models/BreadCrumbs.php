<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 27.08.2017
 * Time: 9:48
 */

namespace common\modules\catalog\models;
use common\models\elasticsearch\Product;
use yii\helpers\Url;

/**
 * Выводит хлебные крошки распарсивая УРЛ
 *
 * Class BreadCrumbs
 * @package common\modules\catalog\models
 */
class BreadCrumbs
{
    public $currentUrl;
    public $currentUrlArr;
    private $foundBreadcrumbs;

    public function __constrict($url=''){
        if($url != ''){
            $this->currentUrl = $url;
        }
    }


    /**
     * пока не используется...подумать нужна ли ?
     */
    public function getBreadCrumbs(){
        $breadcrumbs = $this->getForCatalogProduct();

        $breadcrumbs = $this->getForCatalogSection();
        //var_dump( \Yii::$app->request->resolve());
    }


    /**
     * Возвращает массив  хлебных крошек для карточки товара
     * @param $product
     * @return array
     */
    public function getForCatalogProduct($product){

        /** если раздел задан, то достанем его родителей*/
        if($product['section_id']){

            $sectionModel = new Section();
            $currentSection = $sectionModel->getSectionByUniqueId($product['section_id']);

            $parents = $sectionModel->getParents($currentSection);
            //\Yii::$app->pr->print_r2($product);
            //здесь делаем наполнение шаблонов для хлебных крошек
            $this->__fillProductItems($parents, $product);
            return $parents;
        }

        //выбрать для этого раздела предков
    }

    /**
     * Возвращает массив для разделов
     * @param bool $section
     * @return array
     */
    public function getForCatalogSection($section = false){
        $sectionModel = new Section();

        /** если раздел задан, то достанем его родителей*/
        if($section){
            $parents = $sectionModel->getParents($section);
            //\Yii::$app->pr->print_r2($parents);
            //здесь делаем наполнение шаблонов для хлебных крошек
            $this->__fillSectionItems($parents);
            return $parents;
        }


        /** если раздел не задан, попытаемся распарсить урл */
        $pathForSearch = \Yii::$app->request->resolve()[1]['pathForParse'];
        $foundSection = $sectionModel->getSectionByUrl($pathForSearch);
        if($section){
            $parents = $sectionModel->getParents($foundSection);

            //здесь делаем наполнение шаблонов для хлебных крошек
            $this->__fillSectionItems($parents);
            return $parents;
        }


    }


    /**
     * формирует шаблон для хлебных крошек для выбранных $parentSections для списков товаров
     *
     * @param $parentSections
     * @internal param $oneSection
     */
    private function __fillSectionItems(&$parentSections){

        $cnt = 2;
        foreach($parentSections as &$oneSection){

            if(!$oneSection['finalItem']){

                $oneSection['itemprop'] = 'item';

                $oneSection['url'] = Url::to('@catalogDir/'.$oneSection['url']);
                $seoUrl = Url::to('@catalogDir/'.$oneSection['url'], true);

                $oneSection['template'] = "
                     <li class='width breadcrumbs_item' itemprop='itemListElement' itemscope itemtype='http://schema.org/ListItem'>
                        {link}
                        <span class='arrow_next'>→</span>
                        <meta itemprop='position' content='$cnt'>
                    </li>
                ";
            }else{
                unset($oneSection['url']);
                $oneSection['template'] = "
                    <li class='width breadcrumbs_item current' itemprop='itemListElement' itemscope itemtype='http://schema.org/ListItem'>
                        <span itemprop='name'>{link}</span>
                        <meta itemprop='item' content='{$seoUrl}'>
                        <meta itemprop='position' content='$cnt'>
                    </li>
                ";
            }

            $cnt++;

            //$oneSection["label"] = "<span itemprop='name'>{$oneSection['label']}</span>";

            //if($_GET['yes']) {
                //\Yii::$app->pr->print_r2($oneSection);
                //$url = Url::to('@catalogDir/'.$oneSection['url'].'/'.$product['code'], true);
            //}
        }
    }


    /**
     * формирует шаблон для хлебных крошек для выбранных $parentSections в карточке товара
     *
     * @param $parentSections
     * @param $product
     */
    private function __fillProductItems(&$parentSections, &$product){
        $cnt = 2;
        foreach($parentSections as &$oneSection){
            $url = Url::to('@catalogDir/'.$oneSection['url'].'/'.$product['code'], true);
            $oneSection['itemprop'] = 'item';
            $oneSection['url'] = Url::to('@catalogDir/'.$oneSection['url']);

            $oneSection['template'] = "
                    <li class='width breadcrumbs_item' itemprop='itemListElement' itemscope itemtype='http://schema.org/ListItem'>
                        {link}
                        <span class='arrow_next''>→</span>
                        <meta itemprop='position' content='$cnt'>
                    </li>
            ";
            //\Yii::$app->pr->print_r2($oneSection);
            $cnt++;
        }

        /** добавим текущий товар (но без ссылки на него) */
        if($product){
            $parentSections[] = [
                'label' => $product['artikul'],
                //'url' => $product['url'],
                'template' => "
                     <li class='width breadcrumbs_item' itemprop='itemListElement' itemscope itemtype='http://schema.org/ListItem'>
                        <span itemprop='name'>{link}</span>
                        <meta itemprop='item' content='{$url}'>
                        <meta itemprop='position' content='$cnt'>
                    </li>
            ",

            ];
            //\Yii::$app->pr->print_r2($parentSections);
        }


    }


}