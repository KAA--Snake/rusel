<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 04.11.2020
 * Time: 16:41
 */

namespace common\modules\catalog\modules\admin\models\stock_data;

use common\models\elasticsearch\Product;
use common\modules\catalog\models\Section;
use yii\helpers\Url;

class StockDataPropertyGetter {

    var $product;

    var $serverPath = 'http://rusel24.ru';

    /** @var Section $section */
    var $section;

    public function setProduct(&$product)
    {
        $this->product = $product;
    }

    public function setSection(&$section)
    {
        $this->section = $section;
    }

    private function xml_escape($s)
    {
        $s = html_entity_decode($s, ENT_QUOTES, 'UTF-8');
        $s = htmlspecialchars($s, ENT_QUOTES, 'UTF-8', false);
        return $s;
    }


    private function ifAvailableAndNotArray(&$something)
    {
        if (isset($something) && !is_array($something)) {
            return $something;
        }

        return false;
    }

    private function ifAvailableAndArray(&$something)
    {
        if (isset($something) && is_array($something)) {
            return $something;
        }

        return [];
    }


    function stock_data()
    {
        $prices = $this->ifAvailableAndArray($this->product['_source']['prices']);

        $startCDATA = json_encode($prices, JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_UNICODE);

        return $startCDATA;
    }

    //это новое свойтсво, которого еще нет в товаре, сделаем в будущем
    function trade_info()
    {
        return false;
    }

    //это новое свойтсво, которого еще нет в товаре, сделаем в будущем
    function analogi()
    {
        return false;
    }

    /**
     * перечисление параметров товара в одной строке через разделитель ";",
     * последовательность такая : ИД_параметра, сортировка_параметра, имя_параметра, значение_параметра; ...
     * @return string
     */
    function properties()
    {
        //$properties = $this->ifAvailableAndArray($this->product['_source']['other_properties']['property']);
        $properties = $this->ifAvailableAndArray($this->product['_source']['other_properties']);
        //\Yii::$app->pr->print_r2($properties);
       // die();

        $CDATA = json_encode($properties, JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_UNICODE);

        //echo $CDATA;
        //die();

        return $CDATA;
    }

    function prinadlejnosti()
    {
        $prinadlejnosty = $this->ifAvailableAndNotArray($this->product['_source']['properties']['prinadlejnosti']);

        return $this->xml_escape( $prinadlejnosty );
    }

    function teh_doc_file()
    {

        return $this->ifAvailableAndNotArray($this->product['_source']['properties']['teh_doc_file']);

        return $this->xml_escape( $this->ifAvailableAndNotArray($this->product['_source']['properties']['teh_doc_file']) );
    }

    function picture()
    {
        $picture = $this->ifAvailableAndNotArray($this->product['_source']['properties']['main_picture']);

        if ($picture) {
            $picture = $this->serverPath.Url::to('@catImages/' . $picture);
        }

        return $this->xml_escape( $picture );
    }

    function pricesTotal()
    {
        $total = $this->ifAvailableAndNotArray($this->product['_source']['prices']['total']);

        if (!$total) {
            return 0;
        }

        return $this->xml_escape( $total );
    }

    function detail_text()
    {
        return $this->xml_escape( $this->product['_source']['properties']['detail_text'] );
    }

    function proizv_kod()
    {
        return $this->xml_escape( $this->product['_source']['properties']['proizv_id'] );
    }

    function proizvoditel()
    {
        return $this->xml_escape( $this->product['_source']['properties']['proizvoditel'] );
    }

    function ed_izmerenia()
    {
        return $this->xml_escape( $this->product['_source']['ed_izmerenia'] );
    }

    function artikul()
    {
        return $this->xml_escape( $this->product['_source']['artikul'] );
    }

    function code()
    {
        return $this->xml_escape( $this->product['_source']['code'] );
    }

    function name()
    {
        return $this->xml_escape( $this->product['_source']['name'] );
    }

    function full_url()
    {
        $url = $this->serverPath.'/catalog/'.str_replace('|', '/', $this->product['_source']['url']).'/';

        return $this->xml_escape( $url );
    }

    function id()
    {
        return $this->product['_source']['id'];
    }

    function section()
    {

        if (isset($this->section) && !empty($this->section)) {
            $sectionId = $this->section->getAttribute('unique_id');
            if ($sectionId) {
                return $this->xml_escape( $sectionId );
            }
        }

        return 'No ID !';
    }

    //текст названия секции(категории по каталогу товаров)
    function section_nazvanie()
    {
        $sectionName = '';

        if (isset($this->section) && !empty($this->section)) {
            $sectionName = $this->xml_escape( $this->section->getAttribute('name') );
        }

        return $sectionName === null ? 'No Section Name !' : $sectionName;
    }


}