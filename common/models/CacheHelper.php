<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 13.07.2018
 * Time: 13:51
 */

namespace common\models;


class CacheHelper
{

    public static function getAdditionalCacheParamsFromRequest(){
        $cacheParams = [];

        //\Yii::$app->pr->print_r2(\Yii::$app->request->post());

        if(!empty(\Yii::$app->request->get('on_stores'))){
            $cacheParams['on_stores'] = \Yii::$app->request->get('on_stores');
        }

        if(!empty(\Yii::$app->request->get('marketing'))){
            $cacheParams['marketing'] = \Yii::$app->request->get('marketing');
        }


        /*if(!empty($cacheParams)){
            return md5(serialize($cacheParams));
        }else if(empty(\Yii::$app->request->post())){
            //если не выбраны пагинация НО и не выбран фильтр, то все же занесем в кеш
            return true;
        }*/

        return $cacheParams;
    }


    /**
     * Блок для примера кеша не используется нигде
     */
    private function __promerForCacheBlock(){
        /** @var Cache $cache */
        $cache = \Yii::$app->cache;
        //$cache->flush();
        /** Кешируем первичный запрос на полную выборку */
        $serializedParams = serialize($params);
        $cacheKey = md5($serializedParams);

        //пробрасываем в колбек поисковые параметры для запроса
        $this->cacheCallbackParams = $params;

        //echo '<br>' . $cacheKey . '<br>';
        $filterDataForSection = $cache->getOrSet(
            $cacheKey,
            function(){
                return $this->getFilterDataForSectionId($this->cacheCallbackParams);
            }
        );
    }

    /**
     * Блок для примера кеша не используется нигде
     */
    private function __primer_dva()
    {
        /** @var Cache $cache */
        $cache = \Yii::$app->cache;

        $cacheKey = sha1('getTreeForGroupIds_' . $groupIds);

        if ($cacheKey) {

            if ($cache->exists($cacheKey)) {
                //взять из кеша
                //echo 'taked from cache <br>';
                $grouped = $cache->get($cacheKey);
            } else {
                //echo 'caching <br>';
                /** делаем запрос на выборку*/

                $idsList = explode(';', $groupIds);

                //$idsList = array_unique($idsList);
                $unsortedSections = static::find()
                    //->where(['unique_id' => $idsList])
                                          ->orderBy
                    (
                    //['depth_level' => SORT_ASC]
                        ['sort' => SORT_ASC]
                    //['parent_id' => SORT_ASC]

                    )
                                          ->asArray()
                                          ->all();

                //индексирование массива ИДами разделов
                foreach ($unsortedSections as $group) {
                    $this->unsortedSections[$group['unique_id']] = $group;
                }
                unset($unsortedSections);

                $this->deleteUnnecessarySections($idsList);

                //пересобираем заново с уже измененными(убранными) разделами
                $grouped = $this->buildTreeManufacturer($this->unsortedSections, 0);

                $cache->set($cacheKey, $grouped, 86400);
            }
        }
    }
}