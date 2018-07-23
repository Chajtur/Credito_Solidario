$(document).ready(function(){
    
    $('.parallax').parallax();
    $('.parallax2').parallax();
    $("#mynav").addClass('z-depth-0');
    $(document).scroll(function() {
        var height = $(document).scrollTop();
        if (height > 240) {
            $("#mynav").removeClass("transparent z-depth-0");
            $("#mynav").addClass('indigo darken-3 z-depth-1');
        } else {
            $("#mynav").removeClass("indigo darken-3 z-depth-1");
            $("#mynav").addClass("transparent z-depth-0");
        }
    });
    $(".button-collapse").sideNav({
        menuWidth: 240
    });
    $('.carousel.carousel-slider').carousel({
      full_width: true
    });
    new WOW().init();

});