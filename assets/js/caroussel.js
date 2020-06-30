let image1 = document.getElementById("image-1");

let carousel= $('#carousel-overlay');

let carouselClose= $('#carousel-close');

function closePic(){
    carousel.fadeOut(800, function() {carousel.hide(0)
        $('.carousel-item').each(function(){
            $('.carousel-item').removeClass('active');
        });})
};

document.getElementById("carousel-overlay").addEventListener("wheel", closePic);

carouselClose.click(function() {
    carousel.fadeOut('slow', function() {carousel.hide('fast') })
});

/* =============== lecture caroussel==============*/

let imgIds=[];

$('.image').each(function(){
    imgIds.push(this.id);
});


$.each(imgIds, function(key, value) {

    $('#'+value).click(function(){
        carousel.fadeIn('fast',function(){carousel.show('fast')});
        //$('.carousel').carousel(key+1);
        $('#pic'+value).addClass('active');
    })

});