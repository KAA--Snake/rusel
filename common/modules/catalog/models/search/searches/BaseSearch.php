<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.12.17
 * Time: 15:04
 */

namespace common\modules\catalog\models\search\searches;


abstract class BaseSearch implements iSearch
{
    public $filePath; //если поиск по файлам, сюда падает путь к файлу

}