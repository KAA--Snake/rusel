<?php
/**
 * Контроллер для импорта и elastic поиска по товарам
 */
namespace frontend\controllers;

//set_time_limit(0);

use common\modules\catalog\models\search\SearchByFile;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class SearchController extends Controller
{


    public $layout = 'searchFullWidth';


    public function behaviors()
    {
        return [

            'manufacturers' => [
                'class' => 'common\modules\catalog\behaviours\Manufacturers_beh',
                /*'in_attribute' => 'name',
                'out_attribute' => 'slug',
                'translit' => true*/
            ]
        ];
    }

    /**
     * Первая страница поиска (выводит шаблон поиска по списку артикулов (через файл)
     *
     * @return string
     */
    public function actionIndex(){
        $catalogModule = Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedExtensions'];

        $uploaded = false;

        $fileSearchModel = new SearchByFile();


        if ($fileSearchModel->load(Yii::$app->getRequest()->post()) && $fileSearchModel->validate()){

            $fileSearchModel->file = UploadedFile::getInstance($fileSearchModel, 'file');

            /** если есть файл- загрузим его */
            if(!empty($fileSearchModel->file)){

                if ($fileSearchModel->upload()) {
                    // file is uploaded successfully
                    $uploaded = true;

                    /** @TODO здесь запускается обработка и поиск */

                }
            }

        }

        return $this->render('listSearch', [
            'searchModel' => $fileSearchModel,
            'allowedExtensions' => $allowedExtensions,
            'uploaded' => $uploaded,

        ]);
    }

    /**
     * Обраотка и поиск по товарам из присланного файла.
     */
    public function actionByFile(){
        $catalogModule = Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedSearchFileExtensions'];

        $uploaded = false;

        $fileSearchModel = new SearchByFile();

        if ($fileSearchModel->load(Yii::$app->getRequest()->post()) && $fileSearchModel->validate()){

            $fileSearchModel->file = UploadedFile::getInstance($fileSearchModel, 'file');

            /** если есть файл- загрузим его */
            if(!empty($fileSearchModel->file)){

                $filePath = $fileSearchModel->upload();

                if ($filePath) {

                    // file is uploaded successfully
                    $uploaded = true;

                    /** здесь запускается обработка и поиск */
                    $searchResult = $fileSearchModel->search($filePath);

                    return $this->render('listSearchLoaded', [
                        'products' => $searchResult,
                        'searchModel' => $fileSearchModel,
                        'allowedExtensions' => $allowedExtensions,
                        'uploaded' => $uploaded,

                    ]);

                }

                Yii::$app->session->addFlash('error', 'Ошибка при загрузке файла!');

            }

        }

        //если файл не загружен, редиректим на страницу поиска по файлу
        return $this->redirect('/search/');

    }

}