<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 21.05.2017
 * Time: 14:48
 */

namespace common\modules\catalog\modules\admin\models\import;

set_time_limit(0);

use common\models\elasticsearch\Product;
use common\modules\catalog\models\elastic\Elastic;
use common\modules\catalog\models\Manufacturer;
use common\modules\catalog\models\rabbit\import\RabbitImportProduct;
use common\modules\catalog\modules\admin\models\import\ProductParser;
use common\modules\catalog\models\Section;
use yii\base\Model;
use XMLReader;

class CatalogXmlReader
{
    protected $reader;
    protected $result = array();
    protected $model;

    protected $bulkData;
    private $docsCount = 1;

    private $productModel;

    /** флаг - удалена ли таблица (изпользуется в начале обработки, т.к. разделы всегда удаляются перед обработкой)*/
    private $isTableSectionClear = false;

    public function __construct($xml_path) {

        $this->productModel = new Product();

        $this->reader = new XMLReader();
        if(is_file($xml_path))
            $this->reader->open($xml_path);
        else throw new \Exception('XML file {'.$xml_path.'} not exists!');
    }


    /**
     * Последовательно запускает методы с названием тегов ХМЛа.
     * Пример <group> тег запускает метод $this->parseFroup()
     */
    public function parse(){

        file_put_contents('/webapp/impordResult', 'started ' . date('H:i:s') ,FILE_APPEND);

        while($this->reader->read()){
            if($this->reader->nodeType == XMLREADER::ELEMENT) {
                $fnName = 'parse' . $this->reader->localName;
                $fnModelSaveName = 'save' . $this->reader->localName;
                if(method_exists($this, $fnName)) {

                    //запуск соответствующего парсера (пример - parse.Group)
                    $this->{$fnName}();

                    if($this->reader->localName != 'product'){ //продукт прогоняем через раббит

                        //запуск соответствующего метода (пример- Product.Save($this->result))
                        $this->model->{$fnModelSaveName}($this->result);
                    }


                    unset($this->result);//чистим память
                    unset($this->model);//чистим память
                }
            }

            //usleep(250000);
        }

        //после обработки запроса загрузим остатки, которые не вошли в %1000 от загрузки товаров (в методе parseProduct)
        if(!empty($this->bulkData)){
            //\Yii::$app->pr->print_r2($this->bulkData);

            //echo 'final';
            //\Yii::$app->pr->print_r2($this->bulkData);
            $responses = Elastic::getElasticClient()->bulk($this->bulkData);

            //$rabbitModel = new RabbitImportProduct('import_product_queue');
            //$rabbitModel->sendDataToRabbit(@json_encode($simpleXmlString));

            // unset the bulk response when you are done to save memory
            $this->bulkData = null;
            unset($responses);


            file_put_contents('/webapp/impordResult', '| ended ' . date('H:i:s') ,FILE_APPEND);

        }
    }


    /**
     *  Парсинг списк апроизводителей
     */
    public function parseProizvoditel(){
        if($this->reader->nodeType == XMLREADER::ELEMENT && $this->reader->localName == 'proizvoditel') {

            /**Если таблица разделов полная, очистим ее*/
            if(!$this->isTableSectionClear){
                Manufacturer::deleteAll();

                //флаг - разделы очищены
                $this->isTableSectionClear = true;
            }


            //задаем модель для записи результата
            $this->model = new Manufacturer();

            /*$this->reader->read();
            if($this->reader->nodeType == XMLREADER::TEXT){
                $ratio['name'] = $this->reader->value;
            }*/
            $this->result = simplexml_load_string($this->reader->readOuterXml());
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


            //file_put_contents('/webapp/prodsCount', 'test \r\n' ,FILE_APPEND);

            //собираем 1000 записей для булк лоада
            $simpleXmlString = simplexml_load_string($this->reader->readOuterXml());

            $encoded =  @json_decode(@json_encode($simpleXmlString),1);

            $this->bulkData['body'][] = $this->productModel->getParamsForBulkLoad($encoded)['for_index'];
            $this->bulkData['body'][] = $this->productModel->getParamsForBulkLoad($encoded)['for_body'];

            if ($this->docsCount % 1000 === 0) {


                //\Yii::$app->pr->print_r2($this->bulkData);
                //die();

                $responses = Elastic::getElasticClient()->bulk($this->bulkData);

                //$rabbitModel = new RabbitImportProduct('import_product_queue');

                //$rabbitModel->sendDataToRabbit(@json_encode($simpleXmlString));

                // unset the bulk response when you are done to save memory
                $this->bulkData = null;
                unset($responses);

                sleep(15);

            }

            //задаем модель для записи результата
            //$product = new Product();

            //echo '<pre>';
            /*$this->reader->read();
            if($this->reader->nodeType == XMLREADER::TEXT){
                $ratio['name'] = $this->reader->value;
            }*/




           /* $encoded = @json_encode($simpleXmlString);
            \Yii::$app->pr->print_r2($encoded);

            $decoded = @json_decode($encoded);
            \Yii::$app->pr->print_r2($decoded);*/




            /*$product = [];
            $product['prices'] = [];
            $product['marketing'] = [];
            $product['properties'] = [];*/




            //запуск соответствующего метода (пример- Product.Save($this->result))
            //$product->saveProduct($this->result);

            //print_r($res);
            /*if(isset($this->result->prices)){
                $prices = $priceParser->parsePrices($this->result->prices);
                $product['prices'] = $prices;
            }

            if(isset($this->result->marketing)){
                $marketing = $priceParser->parseMarketing($this->result->marketing);
                $product['marketing'] = $marketing;
            }*/
            $this->docsCount++;

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