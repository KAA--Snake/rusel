<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 04.11.2020
 * Time: 16:43
 */
namespace common\modules\catalog\modules\admin\models\stock_data;

use common\modules\catalog\models\search\searches\ProductsSearch;
use common\modules\catalog\models\search\searches\StockProductsSearch;
use common\modules\catalog\models\Section;

class StockDataXmlWriter {

    var $writer;
    var $propertyGetter;

    var $countedProducts = 0;

    function __construct()
    {
        $this->writer = new \XMLWriter();
        $this->propertyGetter = new StockDataPropertyGetter();

        //начинаем запись потока + ставим начальный тег
        $this->openDocument();
    }

    function __destruct()
    {
        $this->closeDocument();
    }

    public function writeXmlBySearchQuery($searchQuery)
    {
        if (empty($searchQuery) || $searchQuery == '') {
            //закрываем запись + закрываем последний тег
            $this->closeDocument();

            return;
        }

        $searchModel = new StockProductsSearch();
        try {
            $searchResult = $searchModel->searchManual($searchQuery);

            if (isset($searchResult['hits']['hits']) & !empty($searchResult['hits']['hits'])) {
                $this->writeArrayToXml($searchResult['hits']['hits']);
            }

        } catch (\Exception $exception) {
            $this->writer->writeElement('ERROR', $exception->getMessage());
        }

        //закрываем запись + закрываем последний тег
        $this->closeDocument();
    }

    //<list>
    private function openDocument()
    {
        $res = $this->writer->openURI('php://output');

        $this->writer->startDocument('1.0','UTF-8');
        $this->writer->setIndent(4);


        $this->writer->startElement('data');
        $this->writer->writeAttribute('version', '2.0');
    }

    //</list>
    private function closeDocument()
    {
        $this->writer->endElement();
        $this->writer->endElement();
        $this->writer->flush();
    }

    //<item>
    private function openItem()
    {
        $this->writer->startElement('item');
    }

    private function writeArrayToXml($products)
    {
        if (!empty($products) && is_array($products)) {
            foreach($products as $oneProduct) {
                //\Yii::$app->pr->print_r2($oneProduct);
                //print_r($oneProduct);

                $this->writeXmlForProduct($oneProduct);

                $this->countedProducts++;
            }
        }
    }

    /**
     * https://stackoverflow.com/questions/3212982/need-to-write-xml-using-php-how
     * @param $oneProduct
     */
    private function writeXmlForProduct(&$oneProduct)
    {
        $this->propertyGetter->setProduct($oneProduct);

        $this->writer->startElement('item');
            $this->writer->writeElement('mfg', $this->propertyGetter->proizvoditel()); //<!-- значение proizvoditel  -->
            $this->writer->writeElement('part', $this->propertyGetter->artikul());//<!-- значение artikul  -->
            $this->writer->writeElement('note', $this->propertyGetter->name()); //<!-- значение из name  -->
            $this->writer->writeElement('img', $this->propertyGetter->picture());//<!-- если картинка имеется, то полный урл картики, если нет картинки, то пусто -->
            $this->writer->writeElement('pdf', $this->propertyGetter->full_url()); //<!-- полный урл товара -->
            $this->writer->writeElement('url', $this->propertyGetter->full_url()); //<!-- полный урл товара -->
            $this->writer->writeElement('cr', ''); //<!-- пустое  -->
            $this->writer->writeElement('sku', $this->propertyGetter->artikul()); //<!-- значение из artikul  -->
            $this->writer->writeElement('cur', ''); //<!-- пустое  -->
            $this->writer->writeElement('pb', ''); //<!-- пустое  -->
            $this->writer->writeElement('moq', ''); //<!-- пустое  -->
            $this->writer->writeElement('mpq', ''); //<!-- пустое  -->
            $this->writer->writeElement('dc', ''); //<!-- пустое  -->
            $this->writer->writeElement('pkg', ''); //<!-- пустое  -->
            $this->writer->writeElement('pack', ''); //<!-- пустое  -->
            $this->writer->writeElement('stock', $this->propertyGetter->pricesTotal()); //<!-- значение из total -->
            $this->writer->writeElement('dlv', ''); //<!-- пустое  -->
            $this->writer->writeElement('bid', ''); //<!-- пустое  -->
/*
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

        $this->writer->startElement('teh_doc_file');
            $this->writer->writeCData($this->propertyGetter->teh_doc_file());
        $this->writer->endElement();

        $this->writer->writeElement('prinadlejnosti', $this->propertyGetter->prinadlejnosti());

        $this->writer->startElement('properties');
            $this->writer->writeCData($this->propertyGetter->properties());
        $this->writer->endElement();

        $this->writer->startElement('stock_data');
            $this->writer->writeCData($this->propertyGetter->stock_data());
        $this->writer->endElement();

        $this->writer->writeElement('analogi', $this->propertyGetter->analogi());
        $this->writer->writeElement('trade_info', $this->propertyGetter->trade_info());
*/
        $this->writer->endElement();

    }



}