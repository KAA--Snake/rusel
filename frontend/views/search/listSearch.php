<?php
use yii\widgets\ActiveForm;


?>

<?php
foreach (\Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>

<div class="search_by_list">

    <h1>Поиск по списку</h1>

    <p>
        Данный сервис служит для того что бы найти сразу все требуемые наименования «одним кликом» не утруждаясь в поиске каждого по отдельности.
        <br>
        Для этого:
    </p>

    <ul class="searchlist_instructions">
        <li class="searchlist_instructions_item">
            <div class="searchlist_instructions_icon">1</div>
            <div>
                Загрузите файл ( xls, xlsx, txt, csv ), где все артикулы должны быть без описания в первом столбце (на Лист1).
            </div>
        </li>

        <li class="searchlist_instructions_item">
            <div class="searchlist_instructions_icon">2</div>
            <div>
                Проверьте корректность прочитанных артикулов, при необходимости откорректируйте ошибки.
            </div>
        </li>

        <li class="searchlist_instructions_item">
            <div class="searchlist_instructions_icon">3</div>
            <div>
                Запустите поиск и дождитесь окончания процесса.
            </div>
        </li>

    </ul>

    <p>
        Программа выдаст результат поиска сразу по всем совпадениям. Вам останется только добавить нужные позиции в форму запроса.
    </p>

    <div class="searchlist_upload_wrap">
        <?php $form = ActiveForm::begin(
                [
                    'action' => '/search/by-file/',
                    'method' => 'POST',
                    'id' => 'search-by-list',

                    'options' =>
                        [
                            'enctype' => 'multipart/form-data',
                            'class' => 'js-search-by-list-form',
                        ]

                ]);
        ?>

            <button class="upload_btn">Выбрать файл</button>

            <span class="file_name"></span>
            <?=$form->field($searchModel, 'file')->fileInput(['class' => 'searchlist_file hidden'])->label(false);?>

        <?php ActiveForm::end();?>
    </div>


    <!--<p class="attention">Внимание! Процесс поиска может занять некоторое время, которое зависит от количества артикулов в файл</p>-->

</div>