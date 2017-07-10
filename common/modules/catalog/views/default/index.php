<?php
//$this->context->action->uniqueId - catalog/default/index
?>
<br /><br />
<div class="catalog-default-index">
    Путь к текущему разделу/товару: <?= $pathForParse;?>
<br />
<br />

    <div>
        <?php

            foreach($categories as $category){
                echo '<br>' . $category->name;
            }
        ?>

    </div>



</div>
