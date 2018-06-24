/**
 * Created by pepo on 6/23/18.
 */
/**
 * за страницата за детайли само за един календарен ден
 *
 */

leftOrRight='left';

$(document).ready(function () {
    $('#postModal').hide();
    $('#postGroceryModal').hide();
    $('.noDisplay').remove();
    //Показва модала за създаване на събитие
    $("#eventButton").click(function () {
        $("#postModal")
            .modal({
                transition: 'fade',
            })
            .modal('show')

    });

    // $('#notifOther').hide()

    // $('#notifHour').change(function () {
    //     console.log($('#notifHour').val())
    // })
    //
    // $('.notifItems').click(function () {
    //     if($(this).attr('data-value') === "other"){
    //         $('#notifOther').show()
    //     } else {
    //         console.log($('#notifOther').val())
    //     }
    // });

    //Показва модала за създаване на списък
    $("#groceryButton").click(function () {
        $("#postGroceryModal")
            .modal({
                transition: 'fade'
            })
            .modal('show')
    });

    //Зарежда всички събития за деня
    $.ajax({
        method: 'GET',
        url: getEventsUrl,
        data: {date: date, _token: token},
        success: function (data) {
            $.each(data['events'], function (key, value) {
                var event = value;
                eventNew(event)
            })
        },
        error:function (e) {

        }
    })
});

//Показва събитието на страницата
function eventNew(event) {
    date = new Date()
    var currentHour = date.getHours()
    var currentMin = date.getMinutes()
    var month = date.getUTCMonth() + 1; //months from 1-12
    var day = date.getUTCDate();
    var dayMonth = day + "/" + month

    if(event.startHour == 0){
        var idS = "first";
        var startDistance = 22 + parseInt(event.startMinutes)
    } else {
        var idS = parseInt(event.startHour) - 1;
        var startDistance = 53 + parseInt(event.startMinutes)
    }
    var hourHeight = 14;
    if(parseInt(event.startHour) != parseInt(event.endHour)){
        var multiplier = parseInt(event.endHour) - parseInt(event.startHour);
        if(parseInt(event.endMinutes) < parseInt(event.startMinutes)){
            var eventHeight = multiplier*60 + multiplier*hourHeight - (parseInt(event.startMinutes) - parseInt(event.endMinutes))
        } else {
            var eventHeight = multiplier*60 + multiplier*hourHeight + (parseInt(event.endMinutes) - parseInt(event.startMinutes))
        }
    } else {
        var eventHeight = parseInt(event.endMinutes) - parseInt(event.startMinutes)
    }

    if(parseInt(event.startHour) < 10){
        event.startHour = "0" + event.startHour
    }
    if(parseInt(event.startMinutes) < 10){
        event.startMinutes = "0" + event.startMinutes
    }
    if(parseInt(event.endHour) < 10){
        event.endHour = "0" + event.endHour
    }
    if(parseInt(event.endMinutes) < 10){
        event.endMinutes = "0" + event.endMinutes
    }

    $("<div class='"+ "ui segment eventBox" +"' id='" + event.id + "' style='" + "position: absolute; text-align:"+leftOrRight +";height: "  + eventHeight + "px;  margin-top: " + startDistance + "px" + "'>" +
        "<span><b>" + event.startHour + ":" + event.startMinutes + "-"+ event.endHour +":" + event.endMinutes + "</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>" + event.name + "</b></span><div id='" + event.id + "Delete" + "' class='" + "ui " + leftOrRight + " floated icon red button" + "'><i class='"+ "ui delete icon" + "'></i></div><div id='" + event.id + "Edit" + "' class='" + "ui " + leftOrRight + " floated icon black button" + "'><i class='"+ "ui edit icon" + "'></i></div></div>").insertAfter("#" + idS + "");
    $("#" + event.id + "Delete").attr('onclick', "deleteEvent(" + "'" + event.id + "'" + ")")
    $("#" + event.id + "Edit").attr('onclick', "editEvent(" + "'" + event.id + "'" + ")")

    if((currentHour > parseInt(event.startHour) || (currentHour == parseInt(event.startHour) && currentMin > parseInt(event.startMinutes))) && dayMonth === event.day){
        $('#' + event.id).css('background-color', 'rgba(205,92,92, 0.15)')
    }

    if(leftOrRight=='left'){leftOrRight='right';}
    else{leftOrRight='left';}
}

//Изтрива събитие
function deleteEvent(id) {
    $('#deleteModal')
        .modal({
            transition: 'fade',
            onApprove: function () {
                $.ajax({
                    method: 'POST',
                    url: deleteEventUrl,
                    data: {id: id, _token: token},
                    success: function () {
                        $('#deleteMessage').show();
                        $('#deleteMessage').fadeOut(8000);
                        $('#' + id + '').remove()
                    }
                })
            }
        })
        .modal('show')
}

//Отваря модала за редактиране на събитие
function editEvent(id) {
    vueApp.$refs.editModal.showEditModal(id)
}

//Показва модала за преглед списък
function viewLoad(id) {
    vueApp.$refs.viewGroceryModal.loadView(id).then(()=>{
        $("#viewGroceryModal")
.modal({
        transition: 'fade',
    })
        .modal('show')
    console.log('loaded');
})

}

//Показва модала за редактиране на списъй
function showEditModal(id) {
    vueApp.$refs.editGroceryModal.loadEdit(id)
        .then(() => {
        $('#viewGroceryModal').modal('hide')
    $("#editGroceryModal")
        .modal({
            transition: 'fade',
        })
        .modal('show');
})
}
