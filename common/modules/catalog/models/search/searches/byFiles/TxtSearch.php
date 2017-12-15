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

class TxtSearch extends FileSearchDecorator
{


    /**
     * Поиск по файлу, возвращает список найденных товаров
     * @return array
     */
    public function search(): array
    {

        $fd = fopen($this->BaseFileSearch->filePath, 'r');

        if(!$fd){
            return [];
        }


        while(!feof($fd))
        {
            $artikle = fgets($fd);

            $artikle = trim($artikle);
            $artikle = str_replace("\r\n", "", $artikle);
            $artikle = str_replace("\n", "", $artikle);

            //проверка на минимальную(максимальную) длину артикула
            if(!$this->_isLengthIsGood($artikle)) continue;

            if(!empty($artikle)){
                $this->BaseFileSearch->productArticles[] = $artikle;
            }

        }
        fclose($fd);

        //var_dump($productArticles);

        return $this->getProducts();

    }


    public function getArticlesList(): array
    {
        $fd = fopen($this->BaseFileSearch->filePath, 'r');

        if(!$fd){
            return [];
        }


        while(!feof($fd))
        {
            $artikle = fgets($fd);

            $artikle = trim($artikle);
            $artikle = str_replace("\r\n", "", $artikle);
            $artikle = str_replace("\n", "", $artikle);

            //проверка на минимальную(максимальную) длину артикула
            if(!$this->_isLengthIsGood($artikle)) continue;

            if(!empty($artikle)){
                $this->BaseFileSearch->productArticles[] = $artikle;
            }

        }
        fclose($fd);

        return $this->BaseFileSearch->productArticles;
    }
}