<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.12.17
 * Time: 15:32
 */

namespace common\modules\catalog\models\search\searches\byFiles;


class CsvSearch extends BaseFileSearch
{

    /**
     * Поиск по файлу, возвращает список найденных товаров
     * @return array
     */
    public function search(): array
    {

        $fd = fopen($this->filePath, 'r');

        if(!$fd){
            return [];
        }


        while(!feof($fd))
        {
            $artikle = fgets($fd);

            $artikle = trim($artikle);
            $artikle = str_replace("\r\n", "", $artikle);
            $artikle = str_replace("\n", "", $artikle);
            if(!empty($artikle)){
                $this->productArticles[] = $artikle;
            }

        }
        fclose($fd);

        //var_dump($productArticles);
        //Yii::$app->pr->print_r2($productArticles);

        return $this->getProducts();
    }
}