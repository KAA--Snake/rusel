$(document).ready(function () {
    $('.js-img-upload_btn').click(function(e){
        e.preventDefault();
        $(".js-img-upload_input").trigger('click');
    });

    $('.js-article-delete-btn').click(function(e){
        e.preventDefault();
        var articleId = $(this).data('articleId')
        window.location.href = articleId;
    });

    $(".js-img-upload_input").change(function(){
        readURL(this);
    });

    if($('.js-info-textarea-em').length){
        var editablediv = document.querySelector('.js-info-textarea-em');
        editablediv.contentEditable = true;
        $('.js-info-textarea-em').on('blur', function (e) {
            var x = editablediv.innerText;
            $('.js-info-textarea').val(x);
        });
    }

});


function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.js-filereader-target').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

