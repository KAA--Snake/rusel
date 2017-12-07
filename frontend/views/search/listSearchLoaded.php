
<? if($uploaded){?>
    <p>Файл успешно загружен</p>

<? }?>

    <h1>Поиск по списку</h1>

    <p>Данный сервис служит для того что бы найти сразу все требуемые наименования «одним кликом» не утруждаясь в поиске каждого по отдельности.
        <br>
        Как это сделать?</p>

    <ul class="searchlist_instructions">
        <li class="searchlist_instructions_item">
            <div class="searchlist_instructions_icon">1</div>
            <div>
                Предварительно подготовьте список артикулов в файле формата <span class="bold">.xls</span> <br>
                Все артикулы (без описания) должны быть только в первом столбце (на Лист1) начиная с первой строки.
            </div>
        </li>

        <li class="searchlist_instructions_item">
            <div class="searchlist_instructions_icon">2</div>
            <div>
                Загрузите файл в обработчик.
            </div>
        </li>

        <li class="searchlist_instructions_item">
            <div class="searchlist_instructions_icon">3</div>
            <div>
                Проверьте корректность прочитанных артикулов, при необходимости откорректируйте ошибки.
            </div>
        </li>

        <li class="searchlist_instructions_item">
            <div class="searchlist_instructions_icon">4</div>
            <div>
                Запустите поиск и дождитесь окончания процесса.
            </div>
        </li>
    </ul>

    <p>
        Программа выдаст результат поиска сразу по всем совпадениям. Вам останется только добавить нужные позиции в форму запроса.
        <br>
        Ждем Ваших запросов!
    </p>

    <div class="searchlist_upload_wrap">
        <button class="upload_btn">Выбрать файл</button>
        <span class="file_name"></span>
        <input type="file" class="searchlist_file hidden" title="">
    </div>


    <p class="attention">Внимание! Процесс поиска может занять некоторое время, которое зависит от количества артикулов в файл</p>

