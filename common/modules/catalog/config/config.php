<?php
return [
    'params' => [
        'importFolderName' => 'upload_xml',
        'allowedExtensions' => ['xml', 'csv', 'txt'],
        'allowedSearchFileExtensions' => ['csv', 'txt', 'xls', 'xlsx'],
        'catalogDir' => '/catalog', //первоначальный адрес в УРЛ (по нему будут строиться пути в каталоге и тп)
        'uploadImagesDir' => '/upload/images/',
        'uploadFilesDir' => '/upload/files/',
        'uploadSearchDir' => '/upload/search/', //для загрузки файлов для поиска

        /** Настройки для показа "Популярные Линейки" на главной */
        'popular' => [
            'default_img_width' => 200,
            'default_img_height' => 100,
        ],

        /** ниже настройки каталога*/

        //пароль для ерп
        'erp' => [
            'login' => 'erp',
            'password' => 'tgRdj674G',
            'upload_folder' => '/webapp/upload/erp/',
            'server' => 'https://q1.rusel24.ru/',
        ],

        //макс число выводимых разделов
        'max_sections_cnt' => 30,

        //макс число выводимых товаров в списке
        'max_products_cnt' => 25,

        //адреса для рассылки
        'email' => [
            'admin_order' => 'ordsite@rusel24.ru',
            'feedback' => 'ordsite@rusel24.ru' //для отправки формы обратной связи
        ],

        'search' => [
            'max_by_files_result' => 100,
            'max_by_manual_result' => 100,
            'min_artikul_length' => 2,
            'max_artikul_length' => 100,

            //для поска в StockData
            'min_search_length' => 2,
            'max_search_length' => 100,
        ]



    ]
];
