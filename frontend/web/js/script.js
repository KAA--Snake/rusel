$(document).ready(function () {
    $('.slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay:true,
        arrows:false
    });

   /* $('.js-dropdown-catalog').hover(
        function (e) {
            e.stopImmediatePropagation();
            if(!$(this).hasClass('showed')){
                $('.gc_list-lvl0').slideDown();
                $(this).addClass('showed');
            }
        },
        function (e) {
            e.stopImmediatePropagation();
            if ($(this).hasClass('showed')) {

                $('.gc_list-lvl0').slideUp();
                $(this).removeClass('showed');
            }
        }
    );*/

    $('.js-recall_popup_trigger').click(function () {
            $('.popup_container.recall').fadeIn();
    });

    $('.js-recall_popup_close').click(function () {
        $('.popup_container.recall').fadeOut();
    });

    function spListHeightToggle() {
        var spListHeight = $('.wrap').outerHeight() - $('.sp_list').offset().top - 198;
        $('.sp_list').height(spListHeight);
        /*$('.sp_list').animate({'height':spListHeight})*/
    }
    spListHeightToggle();

    /*$('.sp_list').height('100%');*/


    $('.js-scroll-pane').jScrollPane({
        autoReinitialise :true,
        animateScroll:true
    });

    /*$('.ct_dir.child_collapsed').on('click',function () {
       $(this).find('.catalog_tree').slideDown().removeClass('collapsed').addClass('expanded');
       $(this).removeClass('child_collapsed').addClass('child_expanded');
    });

    $('.ct_dir.child_expanded').on('click',function () {
        $(this).find('.catalog_tree').slideUp().removeClass('expanded').addClass('collapsed');
        $(this).removeClass('child_expanded').addClass('child_collapsed')
    });*/

    $('.ct_dir').on('click',function (e) {
        e.stopImmediatePropagation();
        if(e.target == e.currentTarget || e.target.nextSibling.nodeName == 'UL'){
            e.preventDefault();
            var self = this;
            if($(this).hasClass('child_collapsed')){

                $(this).find('.catalog_tree').first().slideDown(function () {
                    spListHeightToggle();
                    if($(self).hasClass('ct_last')){
                        $(self).find('.corner').first().height($(self).height()).addClass('long');
                    }
                }).removeClass('collapsed').addClass('expanded');

                $(this).removeClass('child_collapsed').addClass('child_expanded');

            }else if($(this).hasClass('child_expanded')){

                $(this).find('.catalog_tree').first().slideUp(function () {
                    spListHeightToggle();

                }).removeClass('expanded').addClass('collapsed');
                if($(self).hasClass('ct_last')){
                    $(self).find('.corner.long').first().height(10).removeClass('long');
                }

                $(this).removeClass('child_expanded').addClass('child_collapsed')
            }
        }
    });

    $('.sp_header').on('click', function(){
        if($(this).hasClass('sp_expanded')){
            $(this).addClass('sp_collapsed').removeClass('sp_expanded');
            /*$(this).next('.sp_body').slideUp();*/
        }else if($(this).hasClass('sp_collapsed')){
            $(this).addClass('sp_expanded').removeClass('sp_collapsed');
            /*$(this).next('.sp_body').slideDown();*/
        }
    });


    $('.ct_first, .ct_last').prepend('<div class="corner"></div>');


    $( ".product_tab" ).tabs({
        active: 0
    });

    $('.js-city-select').selectmenu();

    $('.js-delivery-radio').click(function(e) {
        if(this.checked && $(this).hasClass('js-delivery-full')){
            $('.js-delivery-input').show();
        }else if(this.checked && $(this).hasClass('js-delivery-half')) {
            $('.js-delivery-input.js-delivery-full').hide();
            $('.js-delivery-input.js-delivery-half').show();
        }else {
            $('.js-delivery-input').hide();
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
            console.log(suggestion);
        }
    });

    $('.js-expand-tabs').click(function(e){
        e.preventDefault();
        var productCard = $(this).closest('.product_card');
        if(productCard.hasClass('js-tab_collapsed')){
            productCard.find('.product_card_more').first().slideDown(function () {
                spListHeightToggle();
            }).removeClass('collapsed');
            productCard.addClass('js-tab_expanded').removeClass('js-tab_collapsed');
            $(this).find('a').text('Свернуть  ↑');
        }else if(productCard.hasClass('js-tab_expanded')){
            productCard.find('.product_card_more').first().slideUp(function () {
                spListHeightToggle();
            }).addClass('collapsed');
            productCard.addClass('js-tab_collapsed').removeClass('js-tab_expanded');
            $(this).find('a').text('Подробнее  ↓');
        }
    });

    $('.hide_tabs_btn').click(function(e){
        e.preventDefault();
        var productCard = $(this).closest('.product_card');
        if(productCard.hasClass('js-tab_collapsed')){
            productCard.find('.product_card_more').first().slideDown(function () {
                spListHeightToggle();
            }).removeClass('collapsed');
            productCard.addClass('js-tab_expanded').removeClass('js-tab_collapsed');
            productCard.find('.more a').first().text('Свернуть  ↑');
        }else if(productCard.hasClass('js-tab_expanded')){
            productCard.find('.product_card_more').first().slideUp(function () {
                spListHeightToggle();
            }).addClass('collapsed');
            productCard.addClass('js-tab_collapsed').removeClass('js-tab_expanded');
            productCard.find('.more a').first().text('Подробнее  ↓');
        }

    });

    $('.js-selected_count_vars').click(function () {
        if($(this).next('.count_vars').hasClass('active')){
            $(this).next('.count_vars').fadeOut().removeClass('active');
        }else{
            $(this).next('.count_vars').fadeIn().addClass('active');
        }

    });



    $('.tree_header').click(function(e){
        var catalogItem = $(this).closest('h2').next('.tree_list');
        if($(this).hasClass('inactive') && catalogItem.length) {
            e.preventDefault();
            catalogItem.slideDown(function () {
                spListHeightToggle();
            });
            $(this).removeClass('inactive').addClass('active');
            $(this).next('.tree_header_icon').removeClass('inactive').addClass('active');
        }else if($(this).hasClass('active')  && catalogItem.length) {
            e.preventDefault();
            catalogItem.slideUp(function () {
                spListHeightToggle();
            });
            $(this).removeClass('active').addClass('inactive');
            $(this).next('.tree_header_icon').removeClass('active').addClass('inactive');
        }
    });

    $('.js-filter_dropdown').click(function(e){
        if($(this).hasClass('inactive')) {
            $('.filter_selector_wrap').slideDown(function () {
                spListHeightToggle();
            }).removeClass('collapsed').addClass('expanded');
            $(this).removeClass('inactive').addClass('active');
        }else if($(this).hasClass('active')) {
            $('.filter_selector_wrap').slideUp(function () {
                spListHeightToggle();
            }).removeClass('expanded').addClass('collapsed');
            $(this).removeClass('active').addClass('inactive');
        }
    });

    $('.tag_item').click(function (e) {
        var selectedFliterLine = $('.filter_params_applied');
        var filterForm = $('#filter-form');
        var parentParam = $(this).closest('td.tags').prev('td.name').data('param');
        var self = $(this);

        if(!$(this).hasClass('selected')){
            /*if(selectedFliterLine.html() == selectedFliterLine.data('empty')){
                selectedFliterLine.html('');
            }*/
            /*selectedFliterLine.append('<span class="selected_tag">'+ $(this).data('tag') + '</span>');*/
            $(this).addClass('selected');
            filterForm.find('input[name="'+parentParam+'"]').val(
                filterForm.find('input[name="'+parentParam+'"]').val() +
                (filterForm.find('input[name="'+parentParam+'"]').val() == '' ? '' : '|') +
                self.data('tag')
            );
        }else{
            $(this).removeClass('selected');
            var filterArr = filterForm.find('input[name="'+parentParam+'"]').val().split('|');
            var arrFinish = [];
            for(var i=0;i<filterArr.length;i++){
                if(filterArr[i] !== self.data('tag')+''){
                    arrFinish.push(filterArr[i])
                }
            }
            filterForm.find('input[name="'+parentParam+'"]').val(
                arrFinish.join('|')
            );
        }
    });

    if(window.location.search) {
        var queryParams = buildQueryFilter();
        var selectedFliterLine = $('.filter_params_applied');
        if(queryParams.length > 0){
            selectedFliterLine.html('');
            for( var p in queryParams) {
                for(var i=0;i<queryParams[p].length;i++){
                    selectedFliterLine.append('<span data-param="'+ p +'" class="selected_tag">'+ queryParams[p][i] + '</span>');
                    $('.tag_item').each(function () {
                       if($(this).closest('td.tags').prev('td.name').data('param') == p && $(this).data('tag') == queryParams[p][i]) {
                           $(this).addClass('selected');
                           $('#filter-form').find('input[name="'+ p +'"]').val(
                               queryParams[p].length !== 1 ? queryParams[p].join('|') : queryParams[p][0]);
                       }
                    });
                }
            }
        }

    }

    $('.filter_reset_btn').click(function (e) {

        if(window.location.search) {
            var query = decodeURIComponent(window.location.search.substring(1));
            var vars = query.split('&');
            for(var i=0;i<vars.length;i++) {
                if(vars[i].indexOf('page=') != -1) {
                    window.location.search = vars[i];
                }else {
                    window.location.search = '';
                }
            }
        }
    });

    $('.upload_btn').click(function(e){
        e.preventDefault();
        $(".searchlist_file").trigger('click');
    });

    $("input[type='file']").change(function(){
        $('.file_name').text(this.value.replace(/C:\\fakepath\\/i, ''));
    });

});

function buildQueryFilter() {
    var query = decodeURIComponent(window.location.search.substring(1));
    var vars = query.split('&');
    var filterParams = {};
    Object.defineProperty(filterParams, "length", {enumerable: false, writable:true});
    filterParams.length = 0;
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if(pair[0] !== 'page'){
            pair[1] = pair[1].split('|');
            filterParams[pair[0]] = pair[1];
            filterParams.length++;
        }
    }
    return filterParams;
}

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
    console.log(suggestion);
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