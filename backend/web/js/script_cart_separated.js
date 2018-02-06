var excludedFilterParams = ['page', 'perPage'];
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
            $(this).find('.tree_header_icon').removeClass('inactive').addClass('active');
        }else if($(this).hasClass('active')  && catalogItem.length) {
            e.preventDefault();
            catalogItem.slideUp(function () {
                spListHeightToggle();
            });
            $(this).removeClass('active').addClass('inactive');
            $(this).find('.tree_header_icon').removeClass('active').addClass('inactive');
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
        var query = decodeURIComponent(window.location.search.substring(1));
        var vars = query.split('&');
        var finishSearchQuery = [];
        var finishSearchString = '';

        for (var i = 0; i < vars.length; i++) {
            var param = vars[i].slice(0, vars[i].indexOf('='));
            if (excludedFilterParams.indexOf(param) !== -1) {
                finishSearchQuery.push(vars[i]);
            }
        }
        for (var x = 0; x < finishSearchQuery.length; x++) {
            if (x == finishSearchQuery.length - 1) {
                finishSearchString += finishSearchQuery[x]
            } else {
                finishSearchString += finishSearchQuery[x] + '&'
            }
        }
        localStorage.setItem('searchQuery', finishSearchString);

        var queryParams = buildQueryFilter();
        var selectedFliterLine = $('.filter_params_applied');

        if(queryParams.length > 0){
            selectedFliterLine.html('');
            for( var p in queryParams) {
                for(var i=0;i<queryParams[p].length;i++){
                    $('.tag_item').each(function () {
                       if($(this).closest('td.tags').prev('td.name').data('param') == p && $(this).data('tag') == queryParams[p][i]) {
                           selectedFliterLine.append('<span data-param="'+ p +'" class="selected_tag">'+ queryParams[p][i] + '</span>');
                           $(this).addClass('selected');
                           $('#filter-form').find('input[name="'+ p +'"]').val(
                               queryParams[p].length !== 1 ? queryParams[p].join('|') : queryParams[p][0]);
                       }
                    });
                }
            }
        }

    }

    $('.apply_filter_btn').click(function(e){
        e.preventDefault();
        var filterForm = document.forms.productFilterForm,
            formData = new FormData(filterForm),
            query = decodeURIComponent(window.location.search.substring(1)),
            vars = query.split('&'),
            finishSearchQuery = [];

        for (var i = 0; i < vars.length; i++) {
            var param = vars[i].slice(0, vars[i].indexOf('='));
            if (excludedFilterParams.indexOf(param) !== -1) {
                finishSearchQuery.push(vars[i]);
                if(param == 'page'){
                    formData.set(param,1);
                    console.log(param);
                    console.log(formData.get(param));
                }else{
                    formData.set(param, vars[i].slice(vars[i].indexOf('=')+1));
                    console.log(param);
                    console.log(formData.get(param));
                }

                for(var pair of formData.entries()) {
                    console.log(pair[0]+ ', '+ pair[1]);
                }
            }
        }


        filterForm.submit();
    });

    $('.filter_reset_btn').click(function (e) {

        if (window.location.search) {
            var query = decodeURIComponent(window.location.search.substring(1));
            var vars = query.split('&');
            var finishSearchQuery = [];
            var finishSearchString = '';


            //window.location.search = '';

            for (var i = 0; i < vars.length; i++) {
                var param = vars[i].slice(0, vars[i].indexOf('='));
                if (excludedFilterParams.indexOf(param) !== -1) {
                    finishSearchQuery.push(vars[i]);
                }
            }
            for (var x = 0; x < finishSearchQuery.length; x++) {
                if (x == finishSearchQuery.length - 1) {
                    finishSearchString += finishSearchQuery[x]
                } else {
                    finishSearchString += finishSearchQuery[x] + '&'
                }
            }
            window.location.search = finishSearchString;
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
        if(excludedFilterParams.indexOf(pair[0]) === -1){
            pair[1] = pair[1].split('|');
            if(pair[1][0] !== "") {
                filterParams[pair[0]] = pair[1];
                filterParams.length++;
            }
        }
    }
    return filterParams;
}



