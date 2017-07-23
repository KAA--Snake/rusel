<?php
return [
    'params' => [
        'importFolderName' => 'upload_xml',
        'allowedExtensions' => ['xml', 'csv', 'txt'],
        'catalogDir' => '/catalog', //первоначальный адрес в УРЛ (по нему будут строиться пути в каталоге и тп)

        /** ниже настройки каталога*/

        //макс число выводимых разделов
        'max_sections_cnt' => 30,

        //макс число выводимых товаров в списке
        'max_products_cnt' => 100,
    ]
];
