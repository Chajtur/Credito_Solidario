

$(document).ready(function(){
    
    $(".button-collapse").sideNav();
    $('.collapsible').collapsible();
    $('.hide-menu').click(function(){
        $('.button-collapse').sideNav('hide');
    });
    $('.tooltipped').tooltip({delay: 0});
    $('.parallax').parallax();
    $('ul.tabs').tabs();
    $('.slider').slider();
    $('.parallax').parallax();

    // $(function () {
    //     $('a[href*="#"]:not([href="#"])').click(function () {
    //         if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
    //             var target = $(this.hash);
    //             target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    //             if (target.length) {
    //                 $('html, body').animate({
    //                     scrollTop: target.offset().top - 64
    //                 }, 500);
    //                 return false;
    //             }
    //         }
    //     });
    // });
    
});