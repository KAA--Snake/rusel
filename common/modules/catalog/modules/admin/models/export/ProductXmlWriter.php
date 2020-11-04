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


    public function goThrousgSection($sectionId)
    {
        $productSearch = new ProductsSearch();
        $sectionModel = new Section();
        $productsSearchModel = new ProductsSearch();

        $returnData = $sectionModel->getSectionWithSiblingsById(135);

        //получаем товары из текущего раздела (если есть)
        if(!empty($returnData['currentSection']['unique_id']) && $returnData['currentSection']['unique_id'] > 0) {

            $filterParams = [
                'section_id' => $returnData['currentSection']['unique_id']
            ];

            $sectionProducts = $productsSearchModel->getProductsForSectionId($returnData['currentSection']['unique_id']);

            //todo здесь отправить на формирование хмл для массива $sectionProducts
            //\Yii::$app->pr->print_r2($sectionProducts);
        }

        //\Yii::$app->pr->print_r2($returnData['currentSection']->getAttributes());

        if(!empty($returnData['unGroupedSiblings']) && is_array($returnData['unGroupedSiblings'])) {
            foreach($returnData['unGroupedSiblings'] as $oneSibling) {
                $sectionProducts = $productsSearchModel->getProductsForSectionId($oneSibling->unique_id);

                //todo здесь отправить на формирование хмл для массива $sectionProducts
                //\Yii::$app->pr->print_r2($sectionProducts);
            }
        }

//        if(!empty($returnData['groupedSiblings']) && is_array($returnData['groupedSiblings'])) {
//            foreach($returnData['groupedSiblings'] as $oneSibling) {
//                \Yii::$app->pr->print_r($oneSibling->id);
//            }
//        }

        die();

        //получаем список подразделов для выбранного раздела

        //проходим по всем подразделам

        //получаем первый продукт

        //далее обходим все продукты поочередно после первого записывая их, пока не закончатся
        //writeXmlForSection()...

    }


    private function writeXmlForSection($sectionId)
    {
        $propertyGetter = new PropertyGetter();

        $writer = new \XMLWriter();


        $writer->openURI("file:///{$_SERVER['DOCUMENT_ROOT']}/exportCatalog.xml");

        $writer->startDocument('1.0','UTF-8');
        $writer->setIndent(4);
        $writer->startElement('chart');
            $writer->writeAttribute('lowerLimit', '0');
            $writer->writeAttribute('upperLimit', '100');
            $writer->writeAttribute('caption', 'Revenue');
            $writer->writeAttribute('subcaption', 'US $ (1,000s)');
            $writer->writeAttribute('numberPrefix', '$');
            $writer->writeAttribute('numberSuffix', 'K');
            $writer->writeAttribute('showValue', '1');
            $writer->startElement('colorRange');
                $writer->startElement('color');
                    $writer->writeAttribute('minValue', '0');
                    $writer->writeAttribute('maxValue', '50');
                    $writer->writeAttribute('color', 'A6A6A6');
                $writer->endElement();
                $writer->startElement('color');
                    $writer->writeAttribute('minValue', '50');
                    $writer->writeAttribute('maxValue', '75');
                    $writer->writeAttribute('color', 'CCCCCC');
                $writer->endElement();
                $writer->startElement('color');
                        $writer->writeAttribute('minValue', '75');
                        $writer->writeAttribute('maxValue', '100');
                        $writer->writeAttribute('color', 'E1E1E1');
                $writer->endElement();
            $writer->endElement();
        $writer->writeElement('value','78.9');
        $writer->writeElement('target','78.9');
        $writer->endElement();
        $writer->endDocument();
        $writer->flush();

        $file = 'people.txt';

        $person = "John Smith\n";

        //file_put_contents("{$_SERVER['DOCUMENT_ROOT']}/exportCatalog.xml", . "\r\n", FILE_APPEND | LOCK_EX);
        //;
        //\Yii::$app->pr->printR2WOChecks($sectionId);
    }



}