<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 21.05.2017
 * Time: 14:48
 */

namespace common\modules\catalog\models\import;


use yii\base\Model;
use XMLReader;

class CatalogXmlReader
{
    protected $reader;
    protected $result = array();
    protected $model;

    public function __construct($xml_path) {

        $this->reader = new XMLReader();
        if(is_file($xml_path))
            $this->reader->open($xml_path);
        else throw new Exception('XML file {'.$xml_path.'} not exists!');
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


    public function setModel($model){
        $this->model = new $model();
    }

    public function __destruct(){
        //echo '<br> parser destruct';
        $this->reader->close();
        unset($this->reader);
        unset($this->result);

    }

}