<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.12.17
 * Time: 15:05
 */

namespace common\modules\catalog\models\search\searches;

use common\modules\catalog\models\search\searches\byFiles\TxtSearch;
use common\modules\catalog\models\search\searches\byFiles\CsvSearch;
use common\modules\catalog\models\search\searches\byFiles\XlsSearch;
use common\modules\catalog\models\search\searches\byFiles\XlsxSearch;

class FileSearchFabric
{

    /** @var BaseSearch $searchModel */
    public $searchModel;

    public $filePath;

    public function __construct($extension, $filePath)
    {

        switch ($extension){
            case 'txt':
                $this->searchModel = new TxtSearch($filePath);

                break;
            case 'csv':
                $this->searchModel = new CsvSearch($filePath);
                break;
            case 'xls':
                $this->searchModel = new XlsSearch($filePath);
                break;
            case 'xlsx':
                $this->searchModel = new XlsxSearch($filePath);
                break;
        }


    }


    /**
     * Дергает метод поиска для соответствующего объекта BaseFileSearch
     *
     * @return array
     */
    public function search(){
        return $this->searchModel->search();
    }

}