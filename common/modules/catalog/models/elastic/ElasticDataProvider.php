<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 19.08.2017
 * Time: 17:09
 */

namespace common\modules\catalog\models\elastic;


use yii\data\BaseDataProvider;

class ElasticDataProvider extends BaseDataProvider
{
    /**
     * @var string name of the CSV file to read
     */
    public $filename;

    /**
     * @var string|callable name of the key column or a callable returning it
     */
    public $key;

    /**
     * @var SplFileObject
     */
    protected $fileObject; // SplFileObject is very convenient for seeking to particular line in a file


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // open file
       // $this->fileObject = new SplFileObject($this->filename);
    }

    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        $models = [];
        $pagination = $this->getPagination();

        if ($pagination === false) {
            // in case there's no pagination, read all lines
            while (!$this->fileObject->eof()) {
                $models[] = $this->fileObject->fgetcsv();
                $this->fileObject->next();
            }
        } else {
            // in case there's pagination, read only a single page
            $pagination->totalCount = $this->getTotalCount();
            $this->fileObject->seek($pagination->getOffset());
            $limit = $pagination->getLimit();

            for ($count = 0; $count < $limit; ++$count) {
                $models[] = $this->fileObject->fgetcsv();
                $this->fileObject->next();
            }
        }

        return $models;
    }

    /**
     * @inheritdoc
     */
    protected function prepareKeys($models)
    {
        if ($this->key !== null) {
            $keys = [];

            foreach ($models as $model) {
                if (is_string($this->key)) {
                    $keys[] = $model[$this->key];
                } else {
                    $keys[] = call_user_func($this->key, $model);
                }
            }

            return $keys;
        } else {
            return array_keys($models);
        }
    }

    /**
     * @inheritdoc
     */
    protected function prepareTotalCount()
    {
        $count = 0;

        while (!$this->fileObject->eof()) {
            $this->fileObject->next();
            ++$count;
        }

        return $count;
    }
}