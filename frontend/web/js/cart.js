$(document).ready(function () {

    getCityList();

    $('.js-city-select').selectmenu();
    $('.js-city-select').on('selectmenuchange', function () {
        getDeliveryTime(this.value);
    });



    $('.js-delivery-radio').click(function(e) {
        if(this.checked && $(this).hasClass('js-delivery-full')){
            $('.js-delivery-input').show();
            $('.address_subheader').show();
            if($('.delivery_time_text').text().indexOf(' + 1-2 раб.дн. до двери.') == -1 && $('.delivery_time_text').text().length > 0){
                $('.delivery_time_text').append(' + 1-2 раб.дн. до двери.');
            }
        }else if(this.checked && $(this).hasClass('js-delivery-half')) {
            $('.js-delivery-input.js-delivery-full').hide();
            $('.js-delivery-input.js-delivery-half').show();
            $('.address_subheader').show();
            if($('.delivery_time_text').text().indexOf(' + 1-2 раб.дн. до двери.') !== -1 && $('.delivery_time_text').text().length > 0){
                $('.delivery_time_text').text($('.delivery_time_text').text().slice(0, $('.delivery_time_text').text().indexOf(' + 1-2 раб.дн. до двери.')));
            }
        }else {
            $('.js-delivery-input').hide();
            $('.address_subheader').hide();
            $('.delivery_time_text').text('');
        }
    });

    $("#org").suggestions({
        token: "240612ffd28e9888533a15c054c025ea2968155f",
        type: "PARTY",
        count: 10,
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: showSuggestion
    });

    $("#delivery_address").suggestions({
        token: "240612ffd28e9888533a15c054c025ea2968155f",
        type: "ADDRESS",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            /*console.log(suggestion);*/
        }
    });

    $('.js-add_to_cart').click(function () {
       var productContainer = $(this).closest('.js-order_data'),
           productID = productContainer.data('product_id'),
           productCount = productContainer.find('.js-order_count').val(),
           orderInput = productContainer.find('.order_block'),
           orderedBlock = productContainer.find('.ordered_block'),
           orderedCount = orderedBlock.find('.ordered_count .bold'),
           orderedPrice = orderedBlock.find('.ordered_price .bold'),

           orderValue = productID + '|' + productCount;
       /*orderInput.hide();*/
       orderedCount.html(productCount + ' шт');
       orderedBlock.show().removeClass('hidden');
        Cart.setCookie('cart',orderValue);
    });


    $('.js-order_count').inputmask({
        'mask': '[9]',
        'repeat': 16,
        'greedy' : false
    });
});

function join(arr /*, separator */) {
    var separator = arguments.length > 1 ? arguments[1] : ", ";
    return arr.filter(function(n){return n}).join(separator);
}

function typeDescription(type) {
    var TYPES = {
        'INDIVIDUAL': 'Индивидуальный предприниматель',
        'LEGAL': 'Организация'
    }
    return TYPES[type];
}

function showSuggestion(suggestion) {
    $('.selected_org').html(
        '<p>'+ suggestion.data.name.full_with_opf +'</p>' +
        '<p>Адрес: '+ suggestion.data.address.value +'</p>' +
        '<p>ИНН: '+ suggestion.data.inn +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;КПП: '+ suggestion.data.kpp +'</p>'
    );
    var data = suggestion.data;
    if (!data)
        return;

    $("#type").text(
        typeDescription(data.type) + " (" + data.type + ")"
    );

    if (data.name)
        $("#name_short").val(join([data.opf && data.opf.short || "", data.name.short || data.name.full], " "));

    if (data.name && data.name.full)
        $("#name_full").val(join([data.opf && data.opf.full || "", data.name.full], " "));

    $("#inn_kpp").val(join([data.inn, data.kpp], " / "));

    if (data.address)
        $("#address").val(data.address.value);
}

function getCityList() {
    $.getJSON('/admin/pek/get-towns',function (data) {
        var cityList = {};
        var citySelector = $('.js-city-select');

        for (var k in data){
            for (var x in data[k]) {

                if(x < 0){
                    cityList[x] = k;
                    citySelector.append('<option value="' + x + '">' + cityList[x] + '</option>')
                }
            }
        }
        console.log(cityList);
        return cityList
    });
};

function getDeliveryTime(cityId) {
    var delivery_var = document.getElementById('delivery_var3').checked;
    var url = 'http://rusel24.fvds.ru/admin/pek/get-delivery/?delivery=' + cityId;
    var dop_text = ' + 1-2 раб.дн. до двери.';
    $.getJSON(url, function (data) {
        if(!delivery_var){
            dop_text = '';
        }
        if(data.periods_days) {
            $('.delivery_time_text').text('Срок доставки '+ data.auto[1] +' ориентировочно : '+ data.periods_days +' раб.дн.' + dop_text);
        }else{
            $('.delivery_time_text').text('');
        }


    });
};

var Cart = {
    getCookie: function (name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    },
    setCookie: function (name, value, options) {
        options = options || {};

        var expires = options.expires;

        if (typeof expires == "number" && expires) {
            var d = new Date();
            d.setTime(d.getTime() + expires * 1000);
            expires = options.expires = d;
        }
        if (expires && expires.toUTCString) {
            options.expires = expires.toUTCString();
        }

        value = encodeURIComponent(value);

        var updatedCookie = name + "=" + value;

        for (var propName in options) {
            updatedCookie += "; " + propName;
            var propValue = options[propName];
            if (propValue !== true) {
                updatedCookie += "=" + propValue;
            }
        }

        document.cookie = updatedCookie;
    },
    deleteCookie:function (name) {
        this.setCookie(name, "", {
            expires: -1
        });
    }
};