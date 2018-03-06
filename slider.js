var slideNow = 1;
var translateWidth = 0;
var slideInterval = 2000;
var slideCount = 0;
var navBtnId = 0;

function nextSlide() {
    if (slideNow == slideCount || slideNow <= 0 || slideNow > slideCount) {
        $('#slidewrapper').css('transform', 'translate(0, 0)');
        slideNow = 1;
        navColorChange();
    } else {
        translateWidth = -$('#viewpoint').width() * (slideNow);
        $('#slidewrapper').css({
            'transform': 'translate(' + translateWidth + 'px, 0)',
            '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
            '-ms-transform': 'translate(' + translateWidth + 'px, 0)',
        });
        slideNow++;
        navColorChange();
    }

}
function prevSlide() {
    if (slideNow == 1 || slideNow <= 0 || slideNow > slideCount) {
        translateWidth = -$('#viewpoint').width() * (slideCount - 1);
        $('#slidewrapper').css({
            'transform': 'translate(' + translateWidth + 'px, 0)',
            '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
            '-ms-transform': 'translate(' + translateWidth + 'px, 0)',
        });
        slideNow = slideCount;
        navColorChange();
    } else {
        translateWidth = -$('#viewpoint').width() * (slideNow - 2);
        $('#slidewrapper').css({
            'transform': 'translate(' + translateWidth + 'px, 0)',
            '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
            '-ms-transform': 'translate(' + translateWidth + 'px, 0)',

        });
        slideNow--;
        navColorChange();
    }
}
function navColorChange() {

    $('.slide-nav-btn').each(function(){
        if($(this).css("background-color") != "#dbdbdb"){
            $(this).css("background-color", "#dbdbdb");
        }
    });
    $('.slide-nav-btn:eq('+(slideNow-1)+')').css("background-color","#2b2b2b");


}
$(document).ready(function () {
    navColorChange();
    var switchInterval = setInterval(nextSlide, slideInterval);
    slideCount = $('ul#slidewrapper').children().length;
    $('#viewpoint').hover(function(){
        clearInterval(switchInterval);
    },function() {
        switchInterval = setInterval(nextSlide, slideInterval);
    });
    $('#next-btn').click(function() {
        nextSlide();
    });

    $('#prev-btn').click(function() {
        prevSlide();
    });
    $('.slide-nav-btn').click(function() {
        navBtnId = $(this).index();

        if (navBtnId + 1 != slideNow) {
            translateWidth = -$('#viewpoint').width() * (navBtnId);
            $('#slidewrapper').css({
                'transform': 'translate(' + translateWidth + 'px, 0)',
                '-webkit-transform': 'translate(' + translateWidth + 'px, 0)',
                '-ms-transform': 'translate(' + translateWidth + 'px, 0)'
            });
            slideNow = navBtnId + 1;
            navColorChange();
        }
    });
});
