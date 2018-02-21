$(document).ready(function () {
    $('.slider-upload_btn').click(function(e){
        e.preventDefault();
        $(".slider-img-upload").trigger('click');
    });

    $('.info-upload_btn').click(function(e){
        e.preventDefault();
        $(".info-img-upload").trigger('click');
    });
});