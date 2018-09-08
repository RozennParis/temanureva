$(document).ready(function(){
    $('.slider').slider({
        interval: 12000,
        // height: 864,
        // indicators: false,
    });
    $('.sidenav').sidenav();

    $('.scrollspy').scrollSpy({
        scrollOffset: 1000,
    });

    $('.chips').chips();

    $('.collapsible').collapsible();

    $('select').formSelect();

    $('.tabs').tabs();

    $('.materialboxed').materialbox();
});
