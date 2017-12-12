<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.12.17
 * Time: 15:32
 */

namespace common\modules\catalog\models\search\searches\byFiles;


class TxtSearch extends BaseFileSearch
{


    /**
     * Поиск по файлу, возвращает список найденных товаров
     * @return array
     */
    public function search(): array
    {
        echo 'вызов соотв метода: ';
        echo $this->filePath;


        die();

        return [];
    }


}