<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 21.05.2017
 * Time: 15:17
 */

namespace modules\catalog\models\import;
use XMLReader;


class GroupParser extends CatalogXmlReader
{

    public function parseGroup(){
        if($this->reader->nodeType == XMLREADER::ELEMENT && $this->reader->localName == 'group') {

            /*$this->reader->read();
            if($this->reader->nodeType == XMLREADER::TEXT){
                $ratio['name'] = $this->reader->value;
            }*/
            $this->result = simplexml_load_string($this->reader->readOuterXml());
        }
    }
}