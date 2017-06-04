<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 21.05.2017
 * Time: 14:48
 */

namespace common\modules\catalog\modules\admin\models\import;


use common\modules\catalog\models\mongo\Product;
use common\modules\catalog\models\Section;
use yii\base\Model;
use XMLReader;

class CatalogXmlReader
{
    protected $reader;
    protected $result = array();
    protected $model;

    /** флаг - удалена ли таблица (изпользуется в начале обработки, т.к. разделы всегда удаляются перед обработкой)*/
    private $isTableSectionClear = false;

    public function __construct($xml_path) {

        $this->reader = new XMLReader();
        if(is_file($xml_path))
            $this->reader->open($xml_path);
        else throw new Exception('XML file {'.$xml_path.'} not exists!');
    }


    /**
     * Достает атрибут тега по его имени
     *
     * @param $name
     * @return string
     */
    public function Attribute($name)
    {
        foreach($this->Attributes() as $key=>$val)
        {
            if($key == $name)
                return (string)$val;
        }
    }




    public function parse(){
        while($this->reader->read()){
            if($this->reader->nodeType == XMLREADER::ELEMENT) {
                $fnName = 'parse' . $this->reader->localName;
                $fnModelSaveName = 'save' . $this->reader->localName;
                if(method_exists($this, $fnName)) {

                    //запуск соответствующего парсера (пример - parse.Group)
                    $this->{$fnName}();

                    $this->model->{$fnModelSaveName}($this->result);
                }
            }
        }
    }


    /**
     * Парсинг раздела каталога (группы)
     */
    public function parseGroup(){

        if($this->reader->nodeType == XMLREADER::ELEMENT && $this->reader->localName == 'group') {

            /**Если таблица разделов полная, очистим ее*/
            if(!$this->isTableSectionClear){
                Section::deleteAll();

                //флаг - разделы очищены
                $this->isTableSectionClear = true;
            }


            //задаем модель для записи результата
            $this->model = new Section();

            /*$this->reader->read();
            if($this->reader->nodeType == XMLREADER::TEXT){
                $ratio['name'] = $this->reader->value;
            }*/
            $this->result = simplexml_load_string($this->reader->readOuterXml());
        }
    }


    /**
     * Парсинг товаров каталога
     */
    public function parseProduct(){
        if($this->reader->nodeType == XMLREADER::ELEMENT && $this->reader->localName == 'product') {

            //задаем модель для записи результата
            $this->model = new Product();


            /*$this->reader->read();
            if($this->reader->nodeType == XMLREADER::TEXT){
                $ratio['name'] = $this->reader->value;
            }*/
            $this->result = simplexml_load_string($this->reader->readOuterXml());

            echo '<pre>';
            print_r($this->result);

            die();


        }
    }


    public function __destruct(){
        //echo '<br> parser destruct';
        $this->reader->close();
        unset($this->reader);
        unset($this->result);
        unset($this->model);

    }

}