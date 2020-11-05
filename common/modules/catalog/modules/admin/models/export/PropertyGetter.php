<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 04.11.2020
 * Time: 16:41
 */

namespace common\modules\catalog\modules\admin\models\export;

use common\models\elasticsearch\Product;
use common\modules\catalog\models\Section;

class PropertyGetter {

    var $product;

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

    function prices()
    {
        return $this->product['_source']['id'];
    }

    //это новое свойтсво, которого еще нет в товаре, сделаем в будущем
    function trade_info()
    {
        return false;
    }

    function analogi()
    {
        return $this->product['_source']['id'];
    }

    /**
     * перечисление всех имеющихся складов ( часть свойств )
     * в одной строке через разделитель ";",
     * последовательность такакя: ид_склада, количество, срок_со_склада, срок_под_заказ;...
     * @return mixed
     */
    function stock_data()
    {
        return $this->product['_source']['id'];
    }

    /**
     * перечисление параметров товара в одной строке через разделитель ";",
     * последовательность такая : ИД_параметра, сортировка_параметра, имя_параметра, значение_параметра; ...
     * @return string
     */
    function properties()
    {
        $properties = $this->ifAvailableAndArray($this->product['_source']['other_properties']['property']);

        $propArray = array();

        /**
        id	360
        sort	2
        name	Корпус
        value	CASE 267
         */
        foreach ($properties as $oneProperty) {
            $singleProps = array(
                $this->xml_escape( $oneProperty['id'] ),
                $this->xml_escape( $oneProperty['sort'] ),
                $this->xml_escape( $oneProperty['name'] ),
                $this->xml_escape( $oneProperty['value'] )
            );
            $singleProps = implode('::', $singleProps);

            $propArray[] = $singleProps;
        }

        return $this->xml_escape( implode('||', $propArray) );
    }

    function prinadlejnosti()
    {
        //TODO - найти где они - пока неизвестно, спросил
        return $this->xml_escape( $this->product['_source']['id'] );
    }

    function teh_doc_file()
    {
        return $this->xml_escape( $this->ifAvailableAndNotArray($this->product['_source']['properties']['teh_doc_file']) );
    }

    function picture()
    {
        return $this->xml_escape( $this->ifAvailableAndNotArray($this->product['_source']['properties']['main_picture']) );
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
        $url = $_SERVER['HTTP_ORIGIN'].'/catalog/'.str_replace('|', '/', $this->product['_source']['url']).'/';

        return $this->xml_escape( $url );
    }

    function id()
    {
        return $this->product['_source']['id'];
    }

    function section()
    {

        if (isset($this->section) && !empty($this->section)) {
            $sectionId = $this->section->getAttribute('id');
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