<?php

namespace common\modules\catalog\modules\admin\controllers;

use common\modules\catalog\models\Section;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $sectionQuery = Section::find();



        $provider = new ActiveDataProvider([
            'query' => $sectionQuery,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'depth_level' => SORT_ASC,
                    'sort' => SORT_ASC,
                ]
            ],
        ]);


        return $this->render('index', ['provider' => $provider]);
    }
}
