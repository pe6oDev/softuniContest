/**
 *
 * за показване / скриване на sidebar менюто
 *
 */
$(document).ready(function () {

    $('#sideBarHideButton').click(function () {
        $('.ui.sidebar')
            .sidebar('setting', 'transition', 'overlay')
            .sidebar('setting', 'dimPage', false)
            .sidebar('hide')
        ;
    });
    $('#sideBarShowButton').click(function () {
        $('.ui.sidebar')
            .sidebar('setting', 'transition', 'overlay')
            .sidebar('setting', 'dimPage', false)
            .sidebar('show')
        ;
    });

    if($(window).width()<=1350 || (typeof hideSidebar !== 'undefined' && hideSidebar) ){
        $('.ui.sidebar')
            .sidebar('setting', 'transition', 'overlay')
            .sidebar('setting', 'dimPage', false)
            .sidebar('hide');
    }
    else{
       // $('.ui.sidebar').show();
        $('.ui.sidebar')
            .sidebar('setting', 'transition', 'overlay')
            .sidebar('setting', 'dimPage', false)
            .sidebar('show');
    }



});