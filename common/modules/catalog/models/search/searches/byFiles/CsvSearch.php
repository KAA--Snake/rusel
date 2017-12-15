<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.12.17
 * Time: 15:32
 */

namespace common\modules\catalog\models\search\searches\byFiles;

use Yii;
class CsvSearch extends BaseFileSearch
{

    /**
     * Поиск по файлу, возвращает список найденных товаров
     * @return array
     */
    public function search(): array
    {

        $fd = fopen($this->filePath, 'r');


        while (($data = fgetcsv($fd, 1000, ";")) !== FALSE) {

            foreach($data as $oneArtikle){

                if(!empty($oneArtikle)){

                    $artikle = trim($oneArtikle);
                    $artikle = str_replace("\r\n", "", $artikle);
                    $artikle = str_replace("\n", "", $artikle);

                    //проверка на минимальную(максимальную) длину артикула
                    if(!$this->_isLengthIsGood($artikle)) continue;

                    if(!empty($artikle)){
                        $this->productArticles[] = $artikle;
                    }
                }

            }

        }
        fclose($fd);

        //var_dump($this->productArticles);
        //Yii::$app->pr->print_r2($this->productArticles);

        return $this->getProducts();
    }
}