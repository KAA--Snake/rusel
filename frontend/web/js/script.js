var excludedFilterParams = ['page', 'perPage'];
$(document).ready(function () {


    if($('#by-artikuls').length > 0) {
        var form = $('#by-artikuls');
        form.on('submit', function (e) {
            // e.preventDefault();
            var shadow = document.createElement('div');
            var popup = document.createElement('div');

            shadow.classList.add('s_shadow_layer');
            popup.classList.add('s_popup');

            popup.innerHTML = `<div class="preloader"></div> <div class="text"> Пожалуйста, подождите. <br> Идет обработка данных... </div> <a class="reset_link" href="/search/">Остановить процесс</a>`
            document.body.appendChild(shadow);
            document.body.appendChild(popup);
        });
    }

    if($('.js-sp_filter').length > 0) {
        $('.js-sp_filter').on('input', function() {
            var sp_list = $('.js-sp_item');
            if(this.value.length > 2){

                for(let k=0;k<sp_list.length;k++) {

                    if (sp_list.eq(k).find('a').text().toLowerCase().indexOf(this.value.toLowerCase()) == -1){
                        sp_list.eq(k).hide();
                    }else {
                        sp_list.eq(k).show();
                    }
                }
            }else {
                for(let k=0;k<sp_list.length;k++) {
                    sp_list.eq(k).show();
                }
            }

        })
    }

    if($('.js-delete_item').length > 0) {
        $(document).on('click', '.js-delete_item', function (e) {
            $(this).closest('.list_cell').remove();
        })
    }

    if($('.js-search-list-item').length > 0) {
        $('.js-search-list-item').on('input', function (e) {
            var cell = $(this).closest('.list_cell');
            if(this.value.length < 4){
                if(!cell.find('.article_err').length){
                    cell.append('<span class="article_err">Поиск по данному артиклу невозможен (min 4 символа)</span>')
                }
            }else {
                cell.find('.article_err').remove();
            }
        });
    }

    if($('.js-show-product_card--hidden').length > 0) {
        $('.js-show-product_card--hidden').on('click', function (e) {
            var item = $(this).closest('.articles_item'),
                cards = item.find('.product_card--hidden');

            cards.each(function () {
               $(this).show();
            });
            $(this).prev('.show_10').hide();
            $(this).hide();
        })
    }

    if($('.js-add_item-row').length > 0) {
        $('.js-add_item-row').on('click', function (e) {
            var item = '<div class="list_cell">\n' +
                '<span class="square_icon"></span>\n' +
                '<input class="item_input js-search-list-item" name="articles[]" type="text" value="">\n' +
                '<span class="delete_item js-delete_item"></span>\n' +
                '</div>';
            $(item).insertBefore(this);

            $('.js-search-list-item').on('input', function (e) {
                var cell = $(this).closest('.list_cell');
                if(this.value.length < 4){
                    if(!cell.find('.article_err').length){
                        cell.append('<span class="article_err">Поиск по данному артиклу невозможен (min 4 символа)</span>')
                    }
                }else {
                    cell.find('.article_err').remove();
                }
            });
        });
    }
    if($('.article_expand-btn').length > 0) {
        $('.article_expand-btn').on('click', function (e) {
            var item = $(this).closest('.articles_item'),
                cards = item.find('.product_card--hidden'),
                itemPrev = item.prevAll('.articles_item').eq(0),
                itemNext = item.nextAll('.articles_item').eq(0),
                itemHead = item.find('.articles_item_head'),
                itemBody = item.find('.articles_item_body'),
                itemFoot = item.find('.articles_item_foot'),
                dividerBottom = item.next('.fake_divider'),
                dividerTop = item.prev('.fake_divider'),
                btnText = itemHead.find('.head-article_collapse-btn .js-word'),
                btnTextBottom = itemFoot.find('.foot-article_collapse-btn .js-word');
            if(item.hasClass('collapsed')){
                item.removeClass('collapsed').addClass('expanded');
                btnText.text('Свернуть');
                btnTextBottom.text('Свернуть');
                itemHead.find('.arrow').addClass('exp');
                dividerTop.slideDown();
                dividerBottom.slideDown();
                itemBody.slideDown();
                itemFoot.slideDown();

            }else if(item.hasClass('expanded')){
                item.removeClass('expanded').addClass('collapsed');

                btnText.text('Подробнее');
                btnTextBottom.text('Подробнее');
                itemHead.find('.arrow').removeClass('exp');
                if(itemPrev.hasClass('collapsed')){
                    dividerTop.slideUp();
                }
                if(itemNext.hasClass('collapsed')){
                    dividerBottom.slideUp();
                }
                itemBody.slideUp();
                itemFoot.slideUp();


                cards.each(function () {
                    $(this).hide();
                });

                item.find('.show_10').show();
                item.find('.js-show-product_card--hidden').show();
            }



        })
    }



    $('.slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay:true,
        autoplaySpeed:6000,
        arrows:false
    });

    if($('.producers_block').length > 0){
        $('.producers_block').each(function () {
            var linksCollection = $(this).find('.producers_item');
            if(linksCollection.length > 15){
                $(this).append('<span class="expand">Показать весь список</span>');
                for(var i = 15;i<linksCollection.length;i++){
                    linksCollection.eq(i).hide().addClass('hidden');
                }
                var expandTrigger = $(this).find('.expand');
                expandTrigger.on('click', function () {
                    for(var i = 15;i<linksCollection.length;i++){
                        linksCollection.eq(i).show().removeClass('hidden');
                        $(this).hide();
                    }
                })
            }
        })
    }

//<span class="expand">Показать весь список</span>

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
        var spListHeight = $('.wrap').outerHeight() - $('.sp_list').offset().top - 116;
        var spListWrap = $('.sp_list').closest('.js-sp_list_wrap');
        if(spListWrap.hasClass('sp_body-fullwidth')){
            spListHeight = document.body.clientHeight - $('.sp_list').offset().top - 60;
        }
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


    /*$('.manufacturer_tree_wrap .ct_first, .ct_last').prepend('<div class="corner"></div>');*/


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

    $('.js-selected_show_in_stock_vars').click(function () {
        if($(this).next('.show_in_stock_vars').hasClass('active')){
            $(this).next('.show_in_stock_vars').fadeOut().removeClass('active');
        }else{
            $(this).next('.show_in_stock_vars').fadeIn().addClass('active');
        }

    });



    $('.tree_header').click(function(e){
        var producersBlock = $(this).closest('h2').next('.producers_block');
        var catalogItem;
        if(producersBlock.length){
            catalogItem = producersBlock.next('.tree_list');
        }else{
            catalogItem = $(this).closest('h2').next('.tree_list');
        }

        if($(this).hasClass('inactive') && catalogItem.length) {
            e.preventDefault();
            catalogItem.slideDown(function () {
                spListHeightToggle();
            }).removeClass('hidden');
            producersBlock.slideDown().removeClass('hidden');
            $(this).removeClass('inactive').addClass('active');
            $(this).find('.tree_header_icon').removeClass('inactive').addClass('active');
        }else if($(this).hasClass('active')  && catalogItem.length) {
            e.preventDefault();
            catalogItem.slideUp(function () {
                spListHeightToggle();
            });
            producersBlock.slideUp();
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


    $('.js-filter-post-send').click(function (e) {
       var filterForm = $('#filter-form');
       var filterParams = $('.js-filter-param');
       if(filterForm.length) {
           var params = [];
           filterParams.each(function () {
               if($(this).val()) {
                   params.push($(this).val());
               }
           });
           if(params.length > 0) {
               e.preventDefault();
               $('#filter-form').attr('action', e.target.pathname + e.target.search);
               $('#filter-form').submit();
           }
       }
    });

    $('.js-filter-param-item').click(function (e) {
        var selectedFliterLine = $('.filter_params_applied');
        var filterForm = $('#filter-form');
        var parentParam = $(this).closest('.tag_list').find('.js-filter-param-name').data('param');
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

    $('.js-filter-param-item-more').click(function () {
       var list = $(this).closest('.tag_list'),
           items = list.find('.js-filter-param-item.hidden');

       items.each(function (k, item) {

           item.classList.remove('hidden');
       });
       $(this).hide();
    });


    var filterQuery = $('#filter_applied').attr('data') || '';

    if(filterQuery.length && filterQuery !== '[]') {

        var queryParams = JSON.parse(filterQuery);

        var selectedFliterLine = $('.filter_params_applied');
            selectedFliterLine.html('');
            for( var p in queryParams) {
                queryParams[p] = queryParams[p].split('|');

                for(var i=0;i<queryParams[p].length;i++){
                    $('.tag_item').each(function () {
                        var filterParamCat = $(this).closest('.tag_list').find('.js-filter-param-name');
                        if(filterParamCat.data('param') == p && $(this).data('tag') == queryParams[p][i]) {

                            /*selectedFliterLine.append('<span data-param="'+ p +'" class="selected_tag">'+ queryParams[p][i] + '</span>');*/

                            if(selectedFliterLine.find('.applied_param_' + p).data('param') == p) {

                                selectedFliterLine.find('.applied_param_' + p).next('.applied_param_values').append('; <span>'+ queryParams[p][i] + '</span>');
                            }else{
                                selectedFliterLine.append('<div class="applied_param_block"><div class="applied_param_name applied_param_' + p + '" data-param="'+ p +'">' + filterParamCat.text() + '</div><div class="applied_param_values"><span>'+ queryParams[p][i] + '</span></div> </div><div class="divider"></div>');
                            }

                            $(this).addClass('selected');
                            $('#filter-form').find('input[name="'+ p +'"]').val(
                                queryParams[p].length !== 1 ? queryParams[p].join('|') : queryParams[p][0]);
                        }
                    });
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
                }else{
                    formData.set(param, vars[i].slice(vars[i].indexOf('=')+1));

                }

                for(var pair of formData.entries()) {

                }
            }
        }

        filterForm.submit();
    });

    $('.filter_reset_btn').click(function (e) {
        window.location = window.location.href;
        /*if (window.location.search) {
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
        }*/
    });

    $('.upload_btn').click(function(e){
        e.preventDefault();
        $(".searchlist_file").trigger('click');
    });

    $("input[type='file'].searchlist_file").change(function(){
        $('.file_name').text(this.value.replace(/C:\\fakepath\\/i, ''));
        $('.js-search-by-list-form').submit();
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



