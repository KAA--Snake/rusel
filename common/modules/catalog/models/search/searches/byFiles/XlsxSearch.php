<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.12.17
 * Time: 15:32
 */

namespace common\modules\catalog\models\search\searches\byFiles;



class XlsxSearch extends BaseFileSearch
{

    /**
     * Возвращает список найденных товаров
     * @return array
     */
    public function search(): array
    {
        // TODO: Implement search() method.

        return $this->getProducts();
    }
}