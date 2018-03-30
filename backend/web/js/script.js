$(document).ready(function () {
    $('.slider-upload_btn').click(function(e){
        e.preventDefault();
        $(".slider-img-upload").trigger('click');
    });

    $('.info-upload_btn').click(function(e){
        e.preventDefault();
        $(".info-img-upload").trigger('click');
    });

    $('.slider-delete_btn').click(function(e){
        e.preventDefault();
        var slideId = $(this).data('slideId')
        window.location.href = `/admin/slider/delete/${slideId}`;

    });

    $(".slider-img-upload").change(function(){
        readURL(this);
    });
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

