<?php
/**
 * Created by PhpStorm.
 * User: Sergei
 * Date: 12.12.17
 * Time: 10:10
 */

namespace common\modules\catalog\models\search\searches\byFiles;


use common\modules\catalog\models\search\searches\BaseSearch;
use common\modules\catalog\models\search\searches\FileSearchDecorator;
use common\modules\catalog\models\search\searches\FileSearchFabric;

class BaseFileSearch extends BaseSearch
{
    public $filePath;
    public $searchModel;

    public function __construct($extension, $filePath){

        $this->filePath = $filePath;

        /** @var FileSearchDecorator searchModel */
        $this->searchModel = (new FileSearchFabric($extension, $this))->getSearchModel();
    }


    /**
     * @deprecated Временно не используется, т.к. поиск по артикулам будет не по файлам
     *
     * Возвращает список найденных товаров
     * @return array
     */
    public function search(): array
    {
        return $this->searchModel->search();
    }

    /**
     * Возвращает список артикулов из файла
     *
     * @return array
     */
    public function getArticlesList(): array
    {
        return $this->searchModel->getArticlesList();
    }
}