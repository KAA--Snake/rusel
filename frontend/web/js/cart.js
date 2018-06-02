var currenciesData;
$(document).ready(function () {


    getCityList();
    cartCheck();
    orderLinkCountUpdate();


    $('.contact_block .contact_item.order').click(function () {
        window.location.href = '/cart/';
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
        onSelect: function (suggestion) {
            $('input[name="Order[delivery_city_index]"]').val(suggestion.data.postal_code);
        }
    });

    /*$('.js-city-select').selectmenu();*/
    $('.js-city-select').on('change', function () {
        getDeliveryTime(this.value);
        $('.js-delivery_city_index').val(this.value);
        $('.js-delivery_city_name').val($(this).find('option[value="' + this.value + '"]').text());
        //this.value = $(this).find('option[value="'+this.value+'"]');
    });

    /*$('.order_request_form').on('submit', function (e) {
        e.preventDefault();
        if(!$('.js-city-select').val().length){
            $('.delivery_city-button').css({
                'border':'1px solid red'
            });
        }
    })*/

    $('.js-delivery-radio').click(function (e) {
        if (this.checked && $(this).hasClass('js-delivery-full')) {
            $('.js-delivery-input').show();
            $('.address_subheader').show();
            $('.js-delivery-input input').attr('data-validation', 'required');
            $('#delivery_city').attr('data-validation', 'required');

            if ($('.delivery_time_text').text().indexOf(' + 1-2 раб.дн. до двери.') == -1 && $('.delivery_time_text').text().length > 0) {
                $('.delivery_time_text').append(' + 1-2 раб.дн. до двери.');
            }
        } else if (this.checked && $(this).hasClass('js-delivery-half')) {
            $('.js-delivery-input.js-delivery-full').hide();
            $('.js-delivery-input.js-delivery-full input').attr('data-validation', '');
            $('.js-delivery-input.js-delivery-half').show();
            $('.js-delivery-input.js-delivery-half input').attr('data-validation', 'required');
            $('#delivery_city').attr('data-validation', 'required');
            $('.address_subheader').show();
            if ($('.delivery_time_text').text().indexOf(' + 1-2 раб.дн. до двери.') !== -1 && $('.delivery_time_text').text().length > 0) {
                $('.delivery_time_text').text($('.delivery_time_text').text().slice(0, $('.delivery_time_text').text().indexOf(' + 1-2 раб.дн. до двери.')));
            }
        } else {
            $('.js-delivery-input').hide();
            $('.js-delivery-input input').attr('data-validation', '');
            $('#delivery_city').attr('data-validation', '');
            $('.address_subheader').hide();
            $('.delivery_time_text').text('');
        }
    });


    $('.js-cancel-order').click(function () {
        var productContainer = $(this).closest('.js-order_data'),
            productData = {
                productCount: JSON.parse(decodeURIComponent(productContainer.data().productCount)),
                productMarketingPrice: JSON.parse(decodeURIComponent(productContainer.data().productMarketingPrice)),
                productMin_zakaz: JSON.parse(decodeURIComponent(productContainer.data().productMin_zakaz)),
                productNorma_upakovki: JSON.parse(decodeURIComponent(productContainer.data().productNorma_upakovki)),
                productPartnerCount: JSON.parse(decodeURIComponent(productContainer.data().productPartnerCount)),
                productPrices: JSON.parse(decodeURIComponent(productContainer.data().productPrices)),
                product_id: JSON.parse(decodeURIComponent(productContainer.data().product_id))
            },
            productID = productContainer.data('product_id'),
            productCount = productContainer.find('.js-order_count').val(),
            orderInput = productContainer.find('.order_block'),
            orderedBlock = productContainer.find('.ordered_block'),
            orderedCountField = orderedBlock.find('.ordered_count .bold'),
            orderedPriceField = orderedBlock.find('.ordered_price .bold'),
            orderValue = productID + '|' + productCount,
            orderPrice = 0;


        if (document.location.pathname == '/cart/') {
            $(this).closest('.ordered_block').append('<span class="count_tooltip">Удалить наименование из формы запроса?<br><span class="order_buttons_block"><span class="order_button approve_delete_pos">да</span> <span class="order_button decline_delete_pos">нет</span></span><span>Для изменения количества в запросе нужно только повторить ввод с новым значением.</span> <span class="corner"></span></span>');

            $('.approve_delete_pos').click(function () {
                cartPositionDelete(productID, productCount);
                productContainer.closest('.js-product_card').remove();

                var sum = 0;
                $('.ordered_price .bold').each(function () {
                    sum += parseFloat($(this).text());
                });
                $('.sum_amount').text(sum.toFixed(2) + ' руб');

            });
            $('.decline_delete_pos').click(function () {
                $(this).closest('.count_tooltip').remove();
            });
        } else {
            cartPositionDelete(productID, productCount);
            orderedBlock.hide().addClass('hidden');
            productContainer.find('.js-order_count').val('');


        }


    });

    $('.js-add_to_cart').click(function () {
        var productContainer = $(this).closest('.js-order_data'),
            productData = {
                productCount: JSON.parse(decodeURIComponent(productContainer.data().productCount)) == null ? '0' : JSON.parse(decodeURIComponent(productContainer.data().productCount)),
                productMarketingPrice: JSON.parse(decodeURIComponent(productContainer.data().productMarketingPrice)),
                productMarketingPriceCurrency: JSON.parse(decodeURIComponent(productContainer.data().productMarketingPriceCurrency)),
                productMin_zakaz: JSON.parse(decodeURIComponent(productContainer.data().productMin_zakaz)),
                productNorma_upakovki: JSON.parse(decodeURIComponent(productContainer.data().productNorma_upakovki)),
                productPartnerCount: JSON.parse(decodeURIComponent(productContainer.data().productPartnerCount)) == null ? '0' : JSON.parse(decodeURIComponent(productContainer.data().productPartnerCount)),
                productPrices: JSON.parse(decodeURIComponent(productContainer.data().productPrices)) == null ? {price_not_available:true} : JSON.parse(decodeURIComponent(productContainer.data().productPrices)),
                product_id: productContainer.data().product_id,
                storage_id: productContainer.data().productStorageId
            },
            productID = productContainer.data('product_id'),
            productCount = parseInt(productContainer.find('.js-order_count').val()),
            orderInput = productContainer.find('.order_block'),
            orderedBlock = productContainer.find('.ordered_block'),
            orderedCountField = orderedBlock.find('.ordered_count .bold'),
            orderedPriceField = orderedBlock.find('.ordered_price .bold'),
            orderValue = productID + '|' + productCount,
            orderPrice = 0;

        if (productCount.length == 0 || productCount <= 0) {
            return false;
        }

        console.log(productData);
        if (!productData.productPrices.price_not_available) {
            if (productData.productPrices.price_range) {

                if (productData.productMarketingPrice !== null) {
                    var sd = +productData.productMarketingPriceCurrency;
                    orderPrice = +productData.productMarketingPrice * getRateOfExchange(sd);

                } else {
                    if (productData.productPrices.price_range.length) {
                        for (var r = 0; r < productData.productPrices.price_range.length; r++) {

                            var rn = r + 1 == productData.productPrices.price_range.length ? productData.productPrices.price_range.length - 1 : r + 1;
                            if (parseInt(productData.productPrices.price_range[r].range) <= productCount && parseInt(productData.productPrices.price_range[rn].range) > productCount) {
                                orderPrice = parseFloat(+productData.productPrices.price_range[r].value * getRateOfExchange(productData.productPrices.price_range[r].currency)).toFixed(2);
                                break;
                            } else {
                                orderPrice = parseFloat(+productData.productPrices.price_range[rn].value * getRateOfExchange(productData.productPrices.price_range[rn].currency)).toFixed(2);
                            }
                        }
                    } else {
                        orderPrice = parseFloat(+productData.productPrices.price_range.value * getRateOfExchange(productData.productPrices.price_range.currency)).toFixed(2);
                    }
                }
            }
        } else {
            if (productData.productMarketingPrice !== null) {
                var sd = +productData.productMarketingPriceCurrency;
                orderPrice = +productData.productMarketingPrice * getRateOfExchange(sd);

            }
        }


        if (parseInt(productData.productCount) == 0) {
            if (parseInt(productData.productPartnerCount) == 0 || productData.productPartnerCount == null) {
                var cartStr = cookie.getCookie('cart');
                if (cartStr.indexOf(productData.product_id) == -1) {
                    orderedBlock.hide().addClass('hidden');
                }
                /*cartPositionDelete(productID, productCount);*/
                if (productCount < parseInt(productData.productMin_zakaz)) {
                    orderInput.append('<span class="count_tooltip">Неверное количество! <br>Запрашиваемое количество должно соответствовать минимальной партии.<span class="corner"></span></span>');
                    setTimeout(function () {
                        orderInput.find('.count_tooltip').fadeOut(function () {
                            $(this).remove();
                        });
                    }, 5000);
                } else if (productCount % parseInt(productData.productNorma_upakovki) != 0) {
                    orderInput.append('<span class="count_tooltip">Неверное количество! <br>Запрашиваемое количество должно быть кратно упаковке.<span class="corner"></span></span>');
                    setTimeout(function () {
                        orderInput.find('.count_tooltip').fadeOut(function () {
                            $(this).remove();
                        });
                    }, 5000);
                } else {
                    orderInput.find('.count_tooltip').fadeOut(function () {
                        $(this).remove();
                    });
                    orderedBlock.show().removeClass('hidden');
                    cartUpdate(productID, productCount);
                    orderedCountField.html(productCount + ' шт');
                    orderedPriceField.html((productCount * orderPrice).toFixed(2) + ' р');

                    productContainer.find('.js-order_count').val('');
                    if (productData.productPrices.price_not_available && (productData.productMarketingPrice == null || productData.productMarketingPrice == 0) && orderedPriceField.find('.count_tooltip').length == 0) {
                        orderedPriceField.addClass('tooltip_sum');
                        orderedPriceField.append('<span class="count_tooltip">Стоимость будет сообщена после обработки запроса.<span class="corner"></span></span>')
                    }
                }
            } else {
                orderInput.find('.count_tooltip').fadeOut(function () {
                    $(this).remove();
                });
                orderedBlock.show().removeClass('hidden');
                cartUpdate(productID, productCount);
                orderedCountField.html(productCount + ' шт');
                orderedPriceField.html((productCount * orderPrice).toFixed(2) + ' р');

                productContainer.find('.js-order_count').val('');
                if (productData.productPrices.price_not_available && (productData.productMarketingPrice == null || productData.productMarketingPrice == 0) && orderedPriceField.find('.count_tooltip').length == 0) {
                    orderedPriceField.addClass('tooltip_sum');
                    orderedPriceField.append('<span class="count_tooltip">Стоимость будет сообщена после обработки запроса.<span class="corner"></span></span>')
                }
            }

        } else {
            orderInput.find('.count_tooltip').fadeOut(function () {
                $(this).remove();
            });
            orderedBlock.show().removeClass('hidden');
            cartUpdate(productID, productCount);
            orderedCountField.html(productCount + ' шт');
            orderedPriceField.html((productCount * orderPrice).toFixed(2) + ' р');

            productContainer.find('.js-order_count').val('');
            if (productData.productPrices.price_not_available && (productData.productMarketingPrice == null || productData.productMarketingPrice == 0) && orderedPriceField.find('.count_tooltip').length == 0) {
                orderedPriceField.addClass('tooltip_sum');
                orderedPriceField.append('<span class="count_tooltip">Стоимость будет сообщена после обработки запроса.<span class="corner"></span></span>')
            }

        }

        /*orderInput.hide();*/

        console.log(productData);
    });


    $('.js-order_count').inputmask({
        'mask': '[9]',
        'repeat': 16,
        'greedy': false
    });

    $.validate({
        form: '#order_request_form',
        lang: 'ru'
    });

});

function getRateOfExchange(code) {
    var currencies = 0;
    if (!!!$('body').data('currencies') || !$('body').data('currencies')[code]) {
        $.ajax({
            url: '/ajax/get-currencies/',
            async: false,
            success: function (data) {
                $('body').data('currencies', data);
                if (data[code]) {
                    currencies = +data[code];
                }
            }
        });
    } else {
        currencies = +$('body').data('currencies')[code]
    }

    return currencies;
};

function cartCheck() {
    var catalogLength = $('.js-product_card').length;
    var cartString = cookie.getCookie('cart') ? cookie.getCookie('cart') : '';
    if (cartString.length > 0 && catalogLength > 0) {
        var cartArr = cartString.length ? cartString.split('&') : [];
        for (var i = 0; i < cartArr.length; i++) {
            var x = cartArr[i].split('|');

            $('.js-product_card').each(function () {
                if ($(this).find('.js-order_data').data().product_id == x[0]) {


                    var productContainer = $(this).find('.js-order_data').first(),
                        productData = {
                            productCount: JSON.parse(decodeURIComponent(productContainer.data().productCount)),
                            productMarketingPrice: JSON.parse(decodeURIComponent(productContainer.data().productMarketingPrice)),
                            productMarketingPriceCurrency: JSON.parse(decodeURIComponent(productContainer.data().productMarketingPriceCurrency)),
                            productMin_zakaz: JSON.parse(decodeURIComponent(productContainer.data().productMin_zakaz)),
                            productNorma_upakovki: JSON.parse(decodeURIComponent(productContainer.data().productNorma_upakovki)),
                            productPartnerCount: JSON.parse(decodeURIComponent(productContainer.data().productPartnerCount)),
                            productPrices: JSON.parse(decodeURIComponent(productContainer.data().productPrices)),
                            product_id: JSON.parse(decodeURIComponent(productContainer.data().product_id))
                        },
                        productID = productContainer.data('product_id'),
                        productCount = +x[1],
                        orderInput = productContainer.find('.order_block'),
                        orderedBlock = productContainer.find('.ordered_block'),
                        orderedCountField = orderedBlock.find('.ordered_count .bold'),
                        orderedPriceField = orderedBlock.find('.ordered_price .bold'),
                        orderValue = productID + '|' + productCount,
                        orderPrice = 0;


                    if (!productData.productPrices.price_not_available) {
                        if (productData.productPrices.price_range) {

                            if (productData.productMarketingPrice !== null) {
                                var sd = +productData.productMarketingPriceCurrency;
                                orderPrice = +productData.productMarketingPrice * getRateOfExchange(sd);
                            } else {
                                if (productData.productPrices.price_range.length) {
                                    for (var r = 0; r < productData.productPrices.price_range.length; r++) {

                                        var rn = r + 1 == productData.productPrices.price_range.length ? productData.productPrices.price_range.length - 1 : r + 1;
                                        if (parseInt(productData.productPrices.price_range[r].range) <= productCount && parseInt(productData.productPrices.price_range[rn].range) > productCount) {
                                            orderPrice = parseFloat(+productData.productPrices.price_range[r].value * getRateOfExchange(productData.productPrices.price_range[r].currency)).toFixed(2);
                                            break;
                                        } else {
                                            orderPrice = parseFloat(+productData.productPrices.price_range[rn].value * getRateOfExchange(productData.productPrices.price_range[rn].currency)).toFixed(2);
                                        }
                                    }
                                } else {
                                    orderPrice = parseFloat(+productData.productPrices.price_range.value * getRateOfExchange(productData.productPrices.price_range.currency)).toFixed(2);
                                }
                            }

                        }
                    } else {
                        if (productData.productMarketingPrice !== null) {
                            var sd = +productData.productMarketingPriceCurrency;
                            orderPrice = +productData.productMarketingPrice * getRateOfExchange(sd);
                        }
                    }

                    orderedCountField.html(productCount + ' шт');
                    orderedPriceField.html((productCount * orderPrice).toFixed(2) + ' р');

                    if (productData.productPrices.price_not_available && (productData.productMarketingPrice == null || productData.productMarketingPrice == 0) && orderedPriceField.find('.count_tooltip').length == 0) {
                        orderedPriceField.addClass('tooltip_sum');
                        orderedPriceField.append('<span class="count_tooltip">Стоимость будет сообщена после обработки запроса.<span class="corner"></span></span>')
                    }

                    if (parseInt(productData.productCount) == 0) {
                        if (parseInt(productData.productPartnerCount) == 0) {
                            orderedBlock.hide().addClass('hidden');
                            if (productCount < parseInt(productData.productMin_zakaz)) {
                                orderInput.append('<span class="count_tooltip">Неверное количество! <br>Запрашиваемое количество должно соответствовать минимальной партии.<span class="corner"></span></span>');
                                setTimeout(function () {
                                    orderInput.find('.count_tooltip').fadeOut(function () {
                                        $(this).remove();
                                    });
                                }, 5000);
                            } else if (productCount % parseInt(productData.productNorma_upakovki) != 0) {
                                orderInput.append('<span class="count_tooltip">Неверное количество! <br>Запрашиваемое количество должно быть кратно упаковке.<span class="corner"></span></span>');
                                setTimeout(function () {
                                    orderInput.find('.count_tooltip').fadeOut(function () {
                                        $(this).remove();
                                    });
                                }, 5000);
                            } else {
                                orderInput.find('.count_tooltip').fadeOut(function () {
                                    $(this).remove();
                                });
                                orderedBlock.show().removeClass('hidden');
                                cartUpdate(productID, productCount);
                            }
                        } else {
                            orderInput.find('.count_tooltip').fadeOut(function () {
                                $(this).remove();
                            });
                            orderedBlock.show().removeClass('hidden');
                            cartUpdate(productID, productCount);
                            if (productData.productPrices.price_not_available && (productData.productMarketingPrice == null || productData.productMarketingPrice == 0) && orderedPriceField.find('.count_tooltip').length == 0) {
                                orderedPriceField.addClass('tooltip_sum');
                                orderedPriceField.append('<span class="count_tooltip">Стоимость будет сообщена после обработки запроса.<span class="corner"></span></span>')
                            }
                        }

                    } else {
                        orderInput.find('.count_tooltip').fadeOut(function () {
                            $(this).remove();
                        });
                        orderedBlock.show().removeClass('hidden');
                        cartUpdate(productID, productCount);
                        if (productData.productPrices.price_not_available && (productData.productMarketingPrice == null || productData.productMarketingPrice == 0) && orderedPriceField.find('.count_tooltip').length == 0) {
                            orderedPriceField.addClass('tooltip_sum');
                            orderedPriceField.append('<span class="count_tooltip">Стоимость будет сообщена после обработки запроса.<span class="corner"></span></span>')
                        }
                    }
                }
            });


        }
    }
    if (document.location.pathname == '/cart/') {
        if (cartString.length == 0) {
            //$('.product_cards_block._order').html('<h1>Вы еще не добавили ни одного наименования в запрос</h1>');
            $('.product_cards_block._order').html(
                `<h1>Форма запроса</h1>
                <div class="_order_section _selected_products">
                    <h2>Выбранные наименования</h2>
                    <div class="empty_order">Вы еще не добавили ни одного наименования в запрос</div>
                </div>`
            );

        }
        var sum = 0;
        $('.ordered_price .bold').each(function () {
            sum += parseFloat($(this).text());
        });
        $('.sum_amount').text(sum.toFixed(2) + ' руб');
    }
};

function cartPositionDelete(id, count) {
    var cartString = cookie.getCookie('cart') ? cookie.getCookie('cart') : '';
    var cartArr = cartString.length ? cartString.split('&') : [];

    for (var i = 0; i < cartArr.length; i++) {
        if (cartArr[i].indexOf(id) !== -1) {
            cartArr.splice(i, 1);
        }
    }


    $('.contact_item.order .order_count').text(cartArr.length);
    cookie.setCookie('cart', cartArr.join('&'), {
        path: '/',
        expires: 'Tue, 19 Jan 2038 03:14:07 GMT'
    });
};

function orderLinkCountUpdate() {
    var cartString = cookie.getCookie('cart') ? cookie.getCookie('cart') : '';
    var cartArr = cartString.length ? cartString.split('&') : [];

    $('.contact_item.order .order_count').text(cartArr.length);
}

function cartUpdate(id, count) {
    var cartString = cookie.getCookie('cart') ? cookie.getCookie('cart') : '';
    var cartArr = cartString.length ? cartString.split('&') : [];
    for (var i = 0; i < cartArr.length; i++) {
        if (cartArr[i].indexOf(id) !== -1) {
            cartArr[i] = id + '|' + count;
        }
    }

    cartString = cartArr.join('&');

    if (cartString.indexOf(id + '|' + count) == -1) {
        cartArr.push(id + '|' + count);
    }
    console.log(cartArr);
    $('.contact_item.order .order_count').text(cartArr.length);
    cookie.setCookie('cart', cartArr.join('&'), {
        path: '/',
        expires: 'Tue, 19 Jan 2038 03:14:07 GMT'
    });

    if (document.location.pathname == '/cart/') {
        var sum = 0;
        $('.ordered_price .bold').each(function () {
            sum += parseFloat($(this).text());
        });
        $('.sum_amount').text(sum.toFixed(2) + ' руб');
    }
}


function join(arr /*, separator */) {
    var separator = arguments.length > 1 ? arguments[1] : ", ";
    return arr.filter(function (n) {
        return n
    }).join(separator);
}

function typeDescription(type) {
    var TYPES = {
        'INDIVIDUAL': 'Индивидуальный предприниматель',
        'LEGAL': 'Организация'
    }
    return TYPES[type];
}

function showSuggestion(suggestion) {
    console.log(suggestion);
    $('.selected_org').html(
        '<p>' + suggestion.data.name.full_with_opf + '</p>' +
        '<p>Адрес: ' + suggestion.data.address.value + '</p>' +
        '<p>ИНН: ' + suggestion.data.inn + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;КПП: ' + suggestion.data.kpp + '</p>'
    );

    $('input[name="Order[client_kpp]"]').val(suggestion.data.kpp);
    $('input[name="Order[client_inn]"]').val(suggestion.data.inn);
    $('input[name="Order[client_fullname]"]').val(suggestion.data.name.full_with_opf);
    $('input[name="Order[client_shortname]"]').val(suggestion.data.name.short_with_opf);
    $('input[name="Order[client_address]"]').val(suggestion.data.address.value);
    $('input[name="Order[client_city]"]').val(suggestion.data.address.data.city);

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
    $.getJSON('/admin/pek/get-towns', function (data) {
        var cityList = {};
        var citySelector = $('.js-city-select');

        for (var k in data) {
            for (var x in data[k]) {

                if (x < 0) {
                    cityList[x] = k;
                    citySelector.append('<option value="' + x + '">' + cityList[x] + '</option>')
                }
            }
        }
        return cityList
    });
};

function getDeliveryTime(cityId) {
    var delivery_var = document.getElementById('delivery_var3').checked;
    var url = 'http://rusel24.fvds.ru/admin/pek/get-delivery/?delivery=' + cityId;
    var dop_text = ' + 1-2 раб.дн. до двери.';
    $.getJSON(url, function (data) {
        if (!delivery_var) {
            dop_text = '';
        }
        if (data.periods_days) {
            $('.delivery_time_text').text('Срок доставки ' + data.auto[1] + ' ориентировочно : ' + data.periods_days + ' раб.дн.' + dop_text);
            $('.js-delivery_time').val('Срок доставки ' + data.auto[1] + ' ориентировочно : ' + data.periods_days + ' раб.дн.' + dop_text);
        } else {
            $('.delivery_time_text').text('');
            $('.js-delivery_time').val('');
        }


    });
};

var cookie = {
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
    deleteCookie: function (name) {
        this.setCookie(name, "", {
            expires: -1
        });
    }
};