/**
 *
 * js скрипт, който се използва из цялото приложение
 *
 */

$(document).ready(function () {
    //за page loader-a
    setTimeout(function () {
        $('#pageLoader').hide()
    }, 20);

    $("#floatingButton").click(function () {
        $("#postModal")
            .modal({
                transition: 'fade',
            })
            .modal('show');
        $('#calendarStart').calendar();
        $('#calendarEnd').calendar();
    });
});


