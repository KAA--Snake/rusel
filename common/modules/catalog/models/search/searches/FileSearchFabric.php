<?php
/**
 * Created by PhpStorm.
 * User: Sergei
 * Date: 11.12.17
 * Time: 15:05
 */

namespace common\modules\catalog\models\search\searches;

use common\modules\catalog\models\search\searches\byFiles\BaseFileSearch;
use common\modules\catalog\models\search\searches\byFiles\TxtSearch;
use common\modules\catalog\models\search\searches\byFiles\CsvSearch;
use common\modules\catalog\models\search\searches\byFiles\XlsSearch;
use common\modules\catalog\models\search\searches\byFiles\XlsxSearch;

final class FileSearchFabric
{

    /** @var BaseSearch $searchModel */
    private $searchModel;


    /**
     * FileSearchFabric constructor.
     * @param $extension
     * @param $BaseFileSearchObj
     */
    public function __construct($extension, BaseFileSearch $BaseFileSearchObj)
    {

        switch ($extension){
            case 'txt':
                $this->searchModel = new TxtSearch($BaseFileSearchObj);
                break;
            case 'csv':
                $this->searchModel = new CsvSearch($BaseFileSearchObj);
                break;
            case 'xls':
                $this->searchModel = new XlsSearch($BaseFileSearchObj);
                break;
            case 'xlsx':
                $this->searchModel = new XlsxSearch($BaseFileSearchObj);
                break;
        }


    }

    public function getSearchModel():FileSearchDecorator{
        return $this->searchModel;
    }

}