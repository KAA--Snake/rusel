<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.12.17
 * Time: 14:59
 */

namespace common\modules\catalog\models\search\searches;


interface iSearch
{

    //public function search():array;

    /**
     * Возвращает список найденных товаров
     * @return array
     */
    public function getArticlesList():array;


}