/**
 * Created by pepo on 6/23/18.
 */
/**
 * Created by pepo on 4/21/18.
 */
$(document).ready(function () {
    //Преминаване към минала седмица
    $('.toPreviousWeek').click(function () {
        changeWeek("backwards");
    });

    //Преминаване към следваща седмица
    $('.toNextWeek').click(function () {
        changeWeek("forwards");
    });

    var date = new Date();
    var year = date.getUTCFullYear();
    var month = date.getUTCMonth() + 1; //months from 1-12
    var day = date.getUTCDate();

    //Зареждане на дните от настоящата седмица
    loadWeek(day, month, year, "none");

    //Проверка за бутоните за дните от седмицата
    if($(window).width() > 748){
        $('.dayButtons').hide();
    } else {
        $('.dayButtons').show();
    }
});

//Промяна на седмицата
function changeWeek($forwardsOrBackwards){
    if($forwardsOrBackwards === "forwards"){
        var day = $('.toNextWeek').attr('data-day');
        var month = $('.toNextWeek').attr('data-month');
        var year = $('.toNextWeek').attr('data-year');
    } else {
        var day = $('.toPreviousWeek').attr('data-day');
        var month = $('.toPreviousWeek').attr('data-month');
        var year = $('.toPreviousWeek').attr('data-year');
    }
    $('.eventBox').remove();

    loadWeek(day, month, year, $forwardsOrBackwards);
}

//Зареждане на седмицата
function loadWeek(day, month, year, $forwardsOrBackwards) {
    $('.toNextWeek').hide();
    $('.toPreviousWeek').hide();
    var date = new Date();
    if(date.getUTCDate() < 10){
        var dayToday = "0" + date.getUTCDate();
    } else {
        var dayToday = date.getUTCDate();
    }

    var monthToday = date.getUTCMonth() + 1;
    if(monthToday < 10){
        monthToday = "0" + monthToday;
    } else {
        monthToday = monthToday;
    }

    var today = "" + date.getUTCFullYear() + "-" + monthToday + "-" + dayToday + "";
    $.ajax({
        url: changeWeekUrl,
        method: "GET",
        data: {day: day, month: month, year: year, forOrBack: $forwardsOrBackwards},
        success: function (data) {
            if(data.week.indexOf(today) < 0){
                $('.toPreviousWeek').show();
            }
            $('.toNextWeek').show();
            $.each(data.week, function (index, value) {
                date = value.split("-");

                // За правнее на миналите дни disabled
                let currentDate= new  Date();
                let dayDate  = new Date(date[0], date[1]-1, date[2], 23, 59);
                if(dayDate.getTime() < currentDate.getTime()){
                    $('#daySegment' + index).addClass('weekDisabled');
                    $('#weekDay' + index).removeAttr('href');
                }
                else {
                    $('#daySegment' + index).removeClass('weekDisabled');
                    $('#weekDay' + index).attr('href', APP_URL+'/calendar/day/' + parseInt(date[1]) + '/' + parseInt(date[2]) + '')
                }


                if(index == 0){
                    $('.toPreviousWeek').attr('data-day', date[2]);
                    $('.toPreviousWeek').attr('data-month', date[1]);
                    $('.toPreviousWeek').attr('data-year', date[0]);
                    $('#startDate').text("" + date[2]  + " " + months[parseInt(date[1])])
                }
                if(index == 6){
                    $('.toNextWeek').attr('data-day', date[2]);
                    $('.toNextWeek').attr('data-month', date[1]);
                    $('.toNextWeek').attr('data-year', date[0]);
                    $('#endDate').text("" + date[2] + " " + months[parseInt(date[1])]);
                }
                $('#dayHeaderDate'+index).text(date[2]+" "+months[parseInt(date[1])])
            });
            // loadEvents(data.week)
        }
    });
}

//Зареждане на събитията за седмицата
function loadEvents(week) {
    $.ajax({
        url: getWeekEventsUrl,
        method: "GET",
        data: {week: week},
        success: function (data) {
            $.each(week, function (index, value) {
                var keyId = index;
                $.each(data.weekEvents[value], function (index, value) {
                    console.log(value);
                    eventNew(value)    ;
                })
            })
        }
    })
}

//Изкарване на екрана на нов евент
function eventNew(event){
    date = new Date()
    var currentHour = date.getHours();
    var currentMin = date.getMinutes();
    var month = date.getUTCMonth() + 1; //months from 1-12
    var day = date.getUTCDate();
    var dayMonth = day + "/" + month;

    var splitDate = event.day.split("/");
    var day = splitDate[0];
    var month = parseInt(splitDate[1]) - 1;
    var year = parseInt(event.year);

    var eventDate = new Date(year, month, day);
    var number = eventDate.getDay();

    if (number == 0){
        var keyId = 6;
    } else {
        var keyId = number - 1;
    }
    console.log(keyId)  ;

    if(event.startHour == 0){
        var idS = "first";
        var startDistance = 22 + parseInt(event.startMinutes);
    } else {
        var idS = parseInt(event.startHour) - 1;
        var startDistance = 53 + parseInt(event.startMinutes);
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
        event.startHour = "0" + event.startHour;
    }
    if(parseInt(event.startMinutes) < 10){
        event.startMinutes = "0" + event.startMinutes;
    }
    if(parseInt(event.endHour) < 10){
        event.endHour = "0" + event.endHour;
    }
    if(parseInt(event.endMinutes) < 10){
        event.endMinutes = "0" + event.endMinutes;
    }

    $("<div class='"+ "ui segment eventBox" +"' id='" + event.id + "' style='" + "position: absolute; text-align: left; height: "  + eventHeight + "px;  margin-top: " + startDistance + "px" + "'><span id='" + event.id + "text" + "'><b>" + event.name + "</b></span><div class='"  + "ui flowing popup" + "'><div class='" + "ui two column center aligned grid" + "'><div class='column'><div id='" + event.id + "Edit" + "' class='" + "ui tiny icon black button" + "'><i class='"+ "ui edit icon" + "'></i></div></div><div class='column'><div id='" + event.id + "Delete" + "' class='" + "ui tiny icon red button" + "'><i class='"+ "ui delete icon" + "'></i></div></div></div></div>").insertAfter("#" + idS + "-" + keyId + "");

    $("#" + event.id + "Delete").attr('onclick', "deleteEvent(" + "'" + event.id + "'" + ")");
    $("#" + event.id + "Edit").attr('onclick', "editEvent(" + "'" + event.id + "'" + ")");

    $('#' + event.id + "text").popup({
        inline: true,
        hoverable: true,
        position: 'top left',
        delay: {
            hide: 800
        }
    });

    if((currentHour > parseInt(event.startHour) || (currentHour == parseInt(event.startHour) && currentMin > parseInt(event.startMinutes))) && dayMonth === event.day){
        if(theme === "dark"){
            $('#' + event.id).css('background-color', 'rgb(205,92,92)');
        } else {
            $('#' + event.id).css('background-color', 'rgb(255,160,122)');
        }
    } else {
        if(theme === "dark"){
            $('#' + event.id).css('background-color', 'rgb(128,128,128)');
        } else {
            $('#' + event.id).css('background-color', 'rgb(152,251,152)');
        }
    }
}

//Изтриване на събитие
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

//Показване на модала за редактиране
function editEvent(id) {
    vueApp.$refs.editModal.showEditModal(id)
}

//Показване на ден
function goToDay($i){
    var day = document.getElementById("daySegment" + $i);
    day.scrollIntoView();
}
