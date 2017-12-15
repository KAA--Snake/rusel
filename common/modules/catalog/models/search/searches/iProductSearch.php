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
}