<?php
/**
 * Контроллер для импорта и elastic поиска по товарам
 */
namespace frontend\controllers;

//set_time_limit(0);

use common\modules\catalog\models\search\SearchByFile;
use common\modules\catalog\models\search\searches\ProductsSearch;
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
            ],
            'pagination' => [
                'class' => 'common\modules\catalog\behaviours\Pagination_beh',
                'maxSizeCnt' => \Yii::$app->getModule('catalog')->params['max_products_cnt']

            ],
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
     * Обработка и вывод артикулов из присланного файла.
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
                    //$searchResult = $fileSearchModel->search($filePath);
                    $artiklesList = $fileSearchModel->getArticlesFromFile($filePath);

                    //\Yii::$app->pr->print_r2($searchResult);

                    //пробрасывавем имя файла для последующей страницы
                    $fn = $fileSearchModel->file->baseName . '.' . $fileSearchModel->file->extension;
	                \Yii::$app->session->set('uploadedFileNameAfter', $fn);

                    return $this->render('listSearchLoaded', [
                        'uploadedFileName' => $fn,
                        'artiklesList' => $artiklesList,
                        //'products' => $searchResult,
                        //'searchModel' => $fileSearchModel,
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



    public function actionByArtikuls(){
        $catalogModule = Yii::$app->getModule('catalog');
        $allowedExtensions = $catalogModule->params['allowedSearchFileExtensions'];
        $searchResult = [];

        if(isset(Yii::$app->getRequest()->post()['articles']) && count(Yii::$app->getRequest()->post()['articles']) > 0){
            //\Yii::$app->pr->print_r2(Yii::$app->getRequest()->post()['articles']);
            $searchModel = new ProductsSearch();
            $searchResult = $searchModel->searchByArtikuls(Yii::$app->getRequest()->post()['articles']);

        }

	    //пробрасывавем имя файла для последующей страницы
	    $fn = \Yii::$app->session->get('uploadedFileNameAfter', 'unknown name');
	    \Yii::$app->session->remove('uploadedFileNameAfter');
	    //\Yii::$app->pr->print_r2($uploadedFilename);

	    //die();

        return $this->render('listSearchResult', [
	        'uploadedFileName' => $fn,
            'productsList' => $searchResult,
            'artiklesList' => Yii::$app->getRequest()->post()['articles'],
        ]);
    }


    public function actionManual(){
	    //пробрасывается в контроллер из Pagination_beh.php
	    $pagination = \Yii::$app->controller->pagination;


	    $perPage = \Yii::$app->getModule('catalog')->params['max_products_cnt'];

	    $isNeedPerPage = \Yii::$app->request->get('perPage');
	    if(isset($isNeedPerPage)){
		    $perPage = $isNeedPerPage;
	    }
	    $this->view->params['perPage'] = $perPage;


	    $searchQuery = '';
	    $searchResult = [];
	    if(isset(Yii::$app->getRequest()->post()['msearch']) && !empty(Yii::$app->getRequest()->post()['msearch'])){
		    $searchQuery = Yii::$app->getRequest()->post()['msearch'];
	    }

	    if(isset(Yii::$app->getRequest()->get()['msearch']) && !empty(Yii::$app->getRequest()->get()['msearch'])){
		    $searchQuery = Yii::$app->getRequest()->get()['msearch'];
	    }

	    if($searchQuery != ''){

		    $searchModel = new ProductsSearch();
		    $searchResult = $searchModel->searchManual($searchQuery);

		    //die();

		    if( isset($searchResult['products']['hits']['total']) ){
			    $totalFound = $searchResult['products']['hits']['total'];

			    $pagination['totalCount'] = $searchResult['products']['hits']['total'];
		    }
	    }
        //\Yii::$app->pr->print_r2($searchResult);
        //\Yii::$app->pr->die();

	    return $this->render('manualSearchResult', [
	    	'searchBy' => $searchQuery,
		    'productsList' => $searchResult['products']['hits']['hits'],
		    'paginator' => $pagination,
		    'totalFound' => $totalFound,
		    'perPage' => $perPage,

            'filterData' => $searchResult['filterData'],
            'appliedFilterJson' => $searchResult['appliedFilterJson'],
            'emptyFilterResult' => $searchResult['emptyFilterResult'],
            'filterManufacturers' => $searchResult['filterManufacturers'],
            'filterSections' => $searchResult['filterSections'],
		    //'artiklesList' => Yii::$app->getRequest()->post()['articles'],
	    ]);
    }

}