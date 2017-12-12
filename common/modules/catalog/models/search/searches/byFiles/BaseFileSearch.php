<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.12.17
 * Time: 10:10
 */

namespace common\modules\catalog\models\search\searches\byFiles;


use common\modules\catalog\models\search\searches\BaseSearch;

abstract class BaseFileSearch extends BaseSearch
{
    public $filePath;

    public function __construct($filePath){
        $this->filePath = $filePath;
    }
}