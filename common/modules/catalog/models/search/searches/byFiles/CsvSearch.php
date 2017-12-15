<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.12.17
 * Time: 15:32
 */

namespace common\modules\catalog\models\search\searches\byFiles;

use common\modules\catalog\models\search\searches\FileSearchDecorator;
use Yii;
class CsvSearch extends FileSearchDecorator
{

    /**
     * Поиск по файлу, возвращает список найденных товаров
     * @return array
     */
    public function search(): array
    {

        $fd = fopen($this->BaseFileSearch->filePath, 'r');


        while (($data = fgetcsv($fd, 1000, ";")) !== FALSE) {

            foreach($data as $oneArtikle){

                if(!empty($oneArtikle)){

                    $artikle = trim($oneArtikle);
                    $artikle = str_replace("\r\n", "", $artikle);
                    $artikle = str_replace("\n", "", $artikle);

                    //проверка на минимальную(максимальную) длину артикула
                    if(!$this->_isLengthIsGood($artikle)) continue;

                    if(!empty($artikle)){
                        $this->BaseFileSearch->productArticles[] = $artikle;
                    }
                }

            }

        }
        fclose($fd);

        //var_dump($this->productArticles);
        //Yii::$app->pr->print_r2($this->productArticles);

        return $this->getProducts();
    }

    public function getArticlesList(): array
    {
        $fd = fopen($this->BaseFileSearch->filePath, 'r');


        while (($data = fgetcsv($fd, 1000, ";")) !== FALSE) {

            foreach($data as $oneArtikle){

                if(!empty($oneArtikle)){

                    $artikle = trim($oneArtikle);
                    $artikle = str_replace("\r\n", "", $artikle);
                    $artikle = str_replace("\n", "", $artikle);

                    //проверка на минимальную(максимальную) длину артикула
                    if(!$this->_isLengthIsGood($artikle)) continue;

                    if(!empty($artikle)){
                        $this->BaseFileSearch->productArticles[] = $artikle;
                    }
                }

            }

        }
        fclose($fd);

        return $this->BaseFileSearch->productArticles;
    }
}