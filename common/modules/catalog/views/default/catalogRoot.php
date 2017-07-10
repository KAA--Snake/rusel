<?php
echo 'Корневой раздел каталога. Список разделов:';


foreach($rootSections as $category){
    echo '<br>' . $category->name;
}
