<?/*=\Yii::$app->session->getFlash('order_id')[0];*/
if(empty(\Yii::$app->session->getFlash('order_id')[0])){?>
<script>
    location.href = "/"
</script>
<?
}
?>
<script>

    document.addEventListener("DOMContentLoaded", ready);

    function cartPositionDeleteAll() {

        var date = new Date();
        date.setHours(0,0,0,0);
        date.setDate(date.getDate() + 1);

        cookie.setCookie('cart', [], {
            path: '/',
            expires: date
        });
        $('.contact_item.order .order_count').text(0);
    };


    function ready() {
        cartPositionDeleteAll();
    }


</script>



<div class="product_cards_block _order --done">
    <h1>Форма запроса</h1>

    <div class="_order_section _done">
        <h2>уведомление заказчика</h2>

        <p>Ваш запрос принят! </p>
        <p>
            На указанный Вами e-mail отправлено уведомительное сообщение с номером вашего запроса. <br>
            Если во &laquo;Входящих&raquo; сообщениях Вы не обнаружите наше подтверждение, то проверьте не поало ли оно в СПАМ.
        </p>
        <p>
            При необходимости наши сотрудники обязательно свяжутся с Вами если потребуются уточнения по запросу.
        </p>
        <p>
            Обратите внимание, мы работаем Пн - Пт с 09:00 до 18:00 по Московскому времени.
        </p>
    </div>


</div>

