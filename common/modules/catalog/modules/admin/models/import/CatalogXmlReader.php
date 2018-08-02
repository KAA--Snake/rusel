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
use common\modules\catalog\models\catalog_import\Import_log;
use common\modules\catalog\models\elastic\Elastic;
use common\modules\catalog\models\Manufacturer;
use common\modules\catalog\models\rabbit\import\RabbitImportProduct;
use common\modules\catalog\modules\admin\models\import\ProductParser;
use common\modules\catalog\models\Section;
use yii\base\Model;
use XMLReader;
use yii\elasticsearch\Exception;

class CatalogXmlReader
{
    protected $reader;
    protected $result = array();
    protected $model;

    protected $bulkData;
    private $docsCount = 1;

    private $productModel;

    //для динамического наполнения импорта
    private $errors_log = [];

    /** флаг - удалена ли таблица (изпользуется в начале обработки, т.к. разделы всегда удаляются перед обработкой)*/
    private $isTableSectionClear = false;

    public function __construct($xml_path) {
        //$xml_path = '/webapp/upload/erp/stock.xml';
        $this->productModel = new Product();

        $this->reader = new XMLReader();
        if(is_file($xml_path)){
            //file_put_contents('/webapp/import.log', 'opened file');
            $this->reader->open($xml_path);
        }else{
            //file_put_contents('/webapp/import.log', 'XML file {'.$xml_path.'} STILL not exists!');
            throw new \Exception('XML file {'.$xml_path.'} not exists!');
        }


    }


    /**
     * Последовательно запускает методы с названием тегов ХМЛа.
     * Пример <group> тег запускает метод $this->parseFroup()
     */
    public function parse(){

        //file_put_contents('/webapp/impordResult', 'started ' . date('H:i:s') ,FILE_APPEND);

        while($this->reader->read()){
            if($this->reader->nodeType == XMLREADER::ELEMENT) {

                $fnName = 'parse' . $this->reader->localName;
                //echo $fnName . '<br/>';
                $fnModelSaveName = 'save' . $this->reader->localName;
                //echo $fnModelSaveName . '<br/>';
                if(method_exists($this, $fnName)) {

                    //запуск соответствующего парсера (пример - parse.Group)
                    if(method_exists($this, $fnName)){
                        $this->{$fnName}();
                    }

					//продукт и остатки прогоняем через раббит (или булк)
                    if($this->reader->localName != 'product' || $this->reader->localName != 'good'){

                        if(method_exists($this->model, $fnModelSaveName)){
                            /*echo 'class = '.$this->model. PHP_EOL;
                            echo '$fnModelSaveName = '.$fnModelSaveName. PHP_EOL;*/

                            //запуск соответствующего метода (пример- Product.Save($this->result))
                            $this->model->{$fnModelSaveName}($this->result);
                        }


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
            try{
                $responses = Elastic::getElasticClient()->bulk($this->bulkData);

                //$rabbitModel = new RabbitImportProduct('import_product_queue');
                //$rabbitModel->sendDataToRabbit(@json_encode($simpleXmlString));

                // unset the bulk response when you are done to save memory
                $this->bulkData = null;
                unset($responses);

            }catch (Exception $exception){
                Import_log::$currentImportModel['errors_log'][] = $exception->getMessage();

            }

            //file_put_contents('/webapp/impordResult', '| ended ' . date('H:i:s') ,FILE_APPEND);

            //echo 'name = '.$this->reader->localName. PHP_EOL;
            //echo 'count = '.$this->docsCount. PHP_EOL;

            Import_log::$currentImportModel['import_status'] = 1;
            Import_log::$currentImportModel['end_date'] =  date('Y-m-d H:i:s');
            Import_log::$currentImportModel['errors_log'] =  implode('|', $this->errors_log);
            //сохраним кол-во импортируемых товаров в лог
            Import_log::$currentImportModel['imported_cnt'] = $this->docsCount - 1;

            //print_r(Import_log::$currentImportModel);
            Import_log::checkAndSave();

        }




    }


    /**
     *  Парсинг списк апроизводителей
     */
    public function parsemanufacturer(){
        if($this->reader->nodeType == XMLREADER::ELEMENT && $this->reader->localName == 'manufacturer') {

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
    public function parseproduct(){
        if($this->reader->nodeType == XMLREADER::ELEMENT && $this->reader->localName == 'product') {

            //file_put_contents('/webapp/prodsCount', 'test \r\n' ,FILE_APPEND);

            //собираем 1000 записей для булк лоада
            $simpleXmlString = simplexml_load_string($this->reader->readOuterXml());

            $encoded =  @json_decode(@json_encode($simpleXmlString),1);

            $this->bulkData['body'][] = $this->productModel->getParamsForBulkLoad($encoded)['for_index'];
            $this->bulkData['body'][] = $this->productModel->getParamsForBulkLoad($encoded)['for_body'];

            if ($this->docsCount % 1000 === 0) {

                //\Yii::$app->pr->print_r2($this->bulkData);

                try{

                    $responses = Elastic::getElasticClient()->bulk($this->bulkData);

                    //сохраним кол-во импортируемых товаров в лог
                    Import_log::$currentImportModel['imported_cnt'] = $this->docsCount;
                    Import_log::checkAndSave();

                    //$rabbitModel = new RabbitImportProduct('import_product_queue');

                    //$rabbitModel->sendDataToRabbit(@json_encode($simpleXmlString));

                    // unset the bulk response when you are done to save memory
                    $this->bulkData = null;
                    unset($responses);


                    //sleep(1);

                }catch (Exception $exception){
                    Import_log::$currentImportModel['errors_log'][] = $exception->getMessage();
                }

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


	/**
	 * Парсинг товаров каталога
	 */
	public function parsegood(){
		if($this->reader->nodeType == XMLREADER::ELEMENT && $this->reader->localName == 'good') {

			//file_put_contents('/webapp/prodsCount', 'test \r\n' ,FILE_APPEND);

			//собираем 1000 записей для булк лоада
			$simpleXmlString = simplexml_load_string($this->reader->readOuterXml());

			$encoded =  @json_decode(@json_encode($simpleXmlString),1);

			//\Yii::$app->pr->print_r2($encoded);
			//die();

			$this->bulkData['body'][] = $this->productModel->clearBlockForUpdate($encoded)['for_index'];
			$this->bulkData['body'][] = $this->productModel->clearBlockForUpdate($encoded)['for_body'];

			$this->bulkData['body'][] = $this->productModel->getParamsForBulkLoadRemains($encoded)['for_index'];
			$this->bulkData['body'][] = $this->productModel->getParamsForBulkLoadRemains($encoded)['for_body'];

			if ($this->docsCount % 1000 === 0) {

				//\Yii::$app->pr->print_r2($this->bulkData);

				try{

					$responses = Elastic::getElasticClient()->bulk($this->bulkData);

					//сохраним кол-во импортируемых товаров в лог
					Import_log::$currentImportModel['imported_cnt'] = $this->docsCount;
					Import_log::checkAndSave();

					//$rabbitModel = new RabbitImportProduct('import_product_queue');

					//$rabbitModel->sendDataToRabbit(@json_encode($simpleXmlString));

					// unset the bulk response when you are done to save memory
					$this->bulkData = null;
					unset($responses);


					//sleep(3);

				}catch (Exception $exception){
					Import_log::$currentImportModel['errors_log'][] = $exception->getMessage();
				}

			}

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