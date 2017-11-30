<?php
return [
    'params' => [
        'importFolderName' => 'upload_xml',
        'allowedExtensions' => ['xml', 'csv', 'txt'],
        'catalogDir' => '/catalog', //первоначальный адрес в УРЛ (по нему будут строиться пути в каталоге и тп)
        'uploadImagesDir' => '/upload/images/',
        'uploadFilesDir' => '/upload/files/',
        /** ниже настройки каталога*/

        //пароль для ерп
        'erp' => [
            'login' => 'erp',
            'password' => 'tgRdj674G',
            'upload_folder' => '/webapp/upload/erp/',
        ],

        //макс число выводимых разделов
        'max_sections_cnt' => 30,

        //макс число выводимых товаров в списке
        'max_products_cnt' => 25,

        //адреса для рассылки
        'email' => [
            'admin_order' => 'ordsite@rusel24.ru'
            //'admin_order' => 'smu_139@mail.ru'
        ]
    ]
];
