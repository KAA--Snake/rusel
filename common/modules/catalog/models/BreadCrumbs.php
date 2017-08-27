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


    public function getBreadCrumbs(){
        $breadcrumbs = $this->getForCatalogProduct();

        $breadcrumbs = $this->getForCatalogSection();
        //var_dump( \Yii::$app->request->resolve());
    }


    /**
     * Возвращает массив для карточки товара
     */
    public function getForCatalogProduct(){
        $productModel = new Product();
        //выбрать раздел для него

        //выбрать для этого раздела предков
    }

    /**
     * Возвращает массив для разделов
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
     * формирует шаблон для хлебных крошек для выбранных $parentSections
     *
     * @param $oneSection
     */
    private function __fillSectionItems(&$parentSections){
        foreach($parentSections as &$oneSection){


            if(!$oneSection['finalItem']){

                $oneSection['url'] = Url::to('@catalogDir/'.$oneSection['url']);

                $oneSection['template'] = '
                    <li class="breadcrumbs_item">
                        {link}
                        <span class="arrow_next">→</span>
                    </li>
                ';
            }else{
                unset($oneSection['url']);
                $oneSection['template'] = '
                    <li class="breadcrumbs_item current">
                        {link}
                    </li>
                ';
            }

            //\Yii::$app->pr->print_r2($oneSection);
        }
    }


}