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
            //\Yii::$app->pr->print_r2($parents);
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


    /**
     * формирует шаблон для хлебных крошек для выбранных $parentSections в карточке товара
     *
     * @param $parentSections
     * @param $product
     */
    private function __fillProductItems(&$parentSections, &$product){
        foreach($parentSections as &$oneSection){

            $oneSection['url'] = Url::to('@catalogDir/'.$oneSection['url']);

            $oneSection['template'] = '
                    <li class="breadcrumbs_item">
                        {link}
                        <span class="arrow_next">→</span>
                    </li>
            ';
            //\Yii::$app->pr->print_r2($oneSection);
        }

        /** добавим текущий товар (но без ссылки на него) */
        if($product){
            $parentSections[] = [
                'label' => $product['name'],
                //'url' => $product['url'],
                'template' => '
                    <li class="breadcrumbs_item">
                        {link}
                    </li>
            ',

            ];
            //\Yii::$app->pr->print_r2($parentSections);
        }


    }


}