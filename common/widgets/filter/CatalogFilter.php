<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.08.2017
 * Time: 14:46
 */

namespace common\widgets\filter;


//use common\modules\catalog\models\Section;
use common\helpers\translit\Translit;
use common\modules\catalog\models\search\searches\ProductsSearch;
use yii\base\Widget;
use yii\redis\Cache;

class CatalogFilter extends Widget
{
    public $perPage;
    public $options;
    public $cacheTime = 1; //TODO увеличить время кеширования

    public function init()
    {
        parent::init();

        //\Yii::$app->pr->print_r2($this->options);
        //die();

        //yiiwebJqueryAsset::register($this->getView());
    }

    public function run()
    {

        if(empty($this->options['filterData']) || !isset($this->options['filterData'])){
            $this->options['filterData'] = [];
        }
        //\Yii::$app->pr->print_r2(\Yii::$app->request->post());

        if($this->options['emptyFilterResult']){

            /** При применении фильтра не кешируем @TODO может будем кешировать? */
            if( \Yii::$app->request->isPost){ //если был применен фильтр
                if( !empty( \Yii::$app->request->post('catalog_filter') ) ){

                    //\Yii::$app->pr->print_r2(\Yii::$app->request->post() );
                    //die();

                    $fakes = [
                        '_csrf-frontend',
                        'perPage',
                        'catalog_filter',
                    ];
                    foreach(\Yii::$app->request->post() as $k => $postData){
                        if(in_array($k, $fakes)) continue;

                        if(!is_integer($k)) continue;

                        if(empty($postData)) continue;

                        $this->options['filterData'][$k] = $postData;

                    }


                }
            }


        }


        return $this->render('catalog_filter', $this->options);
    }



}