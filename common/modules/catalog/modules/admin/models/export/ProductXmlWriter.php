<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 04.11.2020
 * Time: 16:43
 */
namespace common\modules\catalog\modules\admin\models\export;

use common\modules\catalog\models\search\searches\ProductsSearch;
use common\modules\catalog\models\Section;

class ProductXmlWriter {

    var $writer;
    var $propertyGetter;

    function __construct()
    {
        $this->writer = new \XMLWriter();
        $this->propertyGetter = new PropertyGetter();

        //очищаем файл
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/exportCatalog.xml', "");

        //TODO здесь надо создать стартовую переменную для мониторинга результата (в сессии)

        //начинаем запись потока + ставим начальный тег
        $this->openDocument();
    }

    function __destruct()
    {
        //TODO здесь надо создать конечную переменную для мониторинга результата (в сессии)
        $this->closeDocument();
    }

    public function goThrousgSection($sectionId)
    {
        $productSearch = new ProductsSearch();
        $sectionModel = new Section();
        $productsSearchModel = new ProductsSearch();

        //получаем данные по выбранному разделу
        $returnData = $sectionModel->getSectionWithSiblingsById($sectionId);

        //получаем товары из текущего раздела (если есть)
        if(!empty($returnData['currentSection']['unique_id']) && $returnData['currentSection']['unique_id'] > 0) {

            $filterParams = [
                'section_id' => $returnData['currentSection']['unique_id']
            ];

            $sectionProducts = $productsSearchModel->getProductsForSectionId($returnData['currentSection']['unique_id']);

            //отправить на формирование хмл для массива $sectionProducts
            $this->writeArrayToXml($sectionProducts);

        }

        //\Yii::$app->pr->print_r2($returnData['currentSection']->getAttributes());

        //получаем список подразделов для выбранного раздела
        if(!empty($returnData['unGroupedSiblings']) && is_array($returnData['unGroupedSiblings'])) {

            foreach($returnData['unGroupedSiblings'] as $oneSibling) {
                //проходим по всем подразделам
                $sectionProducts = $productsSearchModel->getProductsForSectionId($oneSibling->unique_id);

                //здесь отправить на формирование хмл для массива $sectionProducts
                $this->writeArrayToXml($sectionProducts);
                //\Yii::$app->pr->print_r2($sectionProducts);
            }
        }

        //закрываем запись + закрываем последний тег
        $this->closeDocument();




        //получаем первый продукт

        //далее обходим все продукты поочередно после первого записывая их, пока не закончатся
        //writeXmlForSection()...

    }

    //<list>
    private function openDocument()
    {
        $this->writer->openURI("file:///{$_SERVER['DOCUMENT_ROOT']}/exportCatalog.xml");
        $this->writer->startDocument('1.0','UTF-8');
        $this->writer->setIndent(4);

        $this->writer->startElement('list');
    }

    //</list>
    private function closeDocument()
    {
        $this->writer->endElement();
        $this->writer->endDocument();
        $this->writer->flush();
    }

    //<item>
    private function openItem()
    {
        $this->writer->startElement('item');
    }

    //</item>
    private function closseItem()
    {
        $writer->endElement();
    }

    private function writeArrayToXml($products)
    {
        if (!empty($products) && is_array($products)) {
            foreach($products as $oneProduct) {
                $this->writeXmlForProduct($oneProduct);
                //\Yii::$app->pr->print_r2($oneProduct);
            }
        }
    }



    private function writeXmlForProduct(&$oneProduct)
    {
        $this->propertyGetter->setProduct($oneProduct);
        //$this->openItem();

        $this->writer->startElement('item');
        //записать здесь один продукт
        $this->writer->writeElement('id', $this->propertyGetter->id());
        $this->writer->writeElement('section', $this->propertyGetter->section());
        $this->writer->writeElement('section_nazvanie', $this->propertyGetter->section_nazvanie());
        $this->writer->writeElement('full_url', $this->propertyGetter->full_url());
        $this->writer->writeElement('name', $this->propertyGetter->name());
        $this->writer->writeElement('code', $this->propertyGetter->code());
        $this->writer->writeElement('artikul', $this->propertyGetter->artikul());
        $this->writer->writeElement('ed_izmerenia', $this->propertyGetter->ed_izmerenia());
        $this->writer->writeElement('proizvoditel', $this->propertyGetter->proizvoditel());
        $this->writer->writeElement('proizv_kod', $this->propertyGetter->proizv_kod());
        $this->writer->writeElement('detail_text', $this->propertyGetter->detail_text());
        $this->writer->writeElement('picture', $this->propertyGetter->picture());
        $this->writer->writeElement('teh_doc_file', $this->propertyGetter->teh_doc_file());
        $this->writer->writeElement('prinadlejnosti', $this->propertyGetter->prinadlejnosti());
        $this->writer->writeElement('properties', $this->propertyGetter->properties());
        $this->writer->writeElement('stock_data', $this->propertyGetter->stock_data());
        $this->writer->writeElement('prices', $this->propertyGetter->prices());
        $this->writer->writeElement('analogi', $this->propertyGetter->analogi());
        $this->writer->writeElement('trade_info', $this->propertyGetter->trade_info());

        $this->writer->endElement();
        //$this->closseItem();

    }



}