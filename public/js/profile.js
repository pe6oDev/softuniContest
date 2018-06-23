/**
 * Created by nikola on 11/13/17.
 *
 * за профил менюто
 *
 */
$(document).ready(function () {
    $('.dropdown').dropdown();


    $('#profileEditButton').click(function () {
        $('#profilеЕditModal').modal({
            autofocus: false,
        }).modal('show');
    });

    if($('#changePassButton').length){
        $('#changePasswordModal')
            .modal('attach events', '#profilеЕditModal #changePassButton')
        ;
    }
    else if($('#makePassButton').length){
        $('#makePasswordModal')
            .modal('attach events', '#makePassButton')
        ;
    }



});