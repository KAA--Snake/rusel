<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.12.17
 * Time: 14:37
 */

namespace common\modules\catalog\models\search\searches;


interface iProductSearch
{
    public function searchByArtikuls(array $artikuls);

    /**
     * Получает на вход ИД раздела каталога, а также дополнительные параметры
     * и выбирает все свойства товаров из выбранного раздела, используя условия по выборке по параметрам
     *  [
     *      'property_name1' => [
     *              'code' => 'property_code1',
     *              'values' => [
     *                  'value1',
     *                  'value2',
     *                  'value3',
     *              ],
     *       ],
     *
     *      'property_name2' => [
     *              'code' => 'property_code2',
     *              'values' => [
     *                  'value1',
     *                  'value2',
     *                  'value3',
     *              ],
     *       ],
     *
     *  ]
     * @param $searchParams
     * @return array
     */
    public function getFilterDataForSectionId($searchParams);
}