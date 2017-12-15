<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.12.17
 * Time: 13:09
 */

namespace common\modules\catalog\models\search\searches;


use common\modules\catalog\models\search\searches\byFiles\BaseFileSearch;

abstract class FileSearchDecorator extends BaseSearch
{
    /** @var  BaseFileSearch $BaseFileSearch */
    protected $BaseFileSearch;

    /**
     * FileSearchDecorator constructor.
     * @param $BaseFileSearch
     */
    public function __construct($BaseFileSearch)
    {
        $this->BaseFileSearch = $BaseFileSearch;
    }

}