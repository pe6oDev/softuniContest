<!--
Модал за добавяне/редактиране на събитие
-->

<template>
    <div v-bind:id="id" class=" ui   small  vary modal">
        <div class=" header ">{{header}}</div>
        <div class="content">
            <div class="ui two column center aligned doubling grid ">
                <div v-show="Object.keys(errors).length" class="ui row">
                    <div class="sixteen wide column">
                        <!-- Съобщения за грешка -->
                        <div class="ui error message">
                            <ul>
                                <li v-for="error in errors">{{Array.isArray(error) ? error[0]:error}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--Поле за име на дейността-->
                <div class="ui row">
                    <div class="sixteen wide column">
                        <div class="ui fluid  input field">
                            <input v-model="name" type="text" name="name" v-bind:placeholder="question">
                        </div>
                    </div>
                </div>
                <!--Дали да е целодневно-->
                <div class="ui row">
                    <div class="ui toggle checkbox">
                        <input v-model="wholeDay" name="public" type="checkbox"/>
                        <label>Цял ден</label>
                    </div>
                </div>
               <!--Часове-->
                <div v-show="!wholeDay" class="ui row">
                    <!--Начални час и дата-->
                    <div class="ui eight wide column">
                        <div class="ui calendar " id="calendarStart">
                            <div class="ui input fluid left icon">
                                <i class="calendar icon"></i>
                                <input type="text" placeholder="Начало"/>
                            </div>
                        </div>
                    </div>
                    <!--Крайни час и дата-->
                    <div class="ui eight wide column">
                        <div class="ui calendar" id="calendarEnd">
                            <div class="ui input left fluid icon">
                                <i class="calendar icon"></i>
                                <input type="text" placeholder="Край"/>
                            </div>
                        </div>
                    </div>
                </div>


                <!--За напомняниеята-->
                <div class="ui row">
                    <h3 class="header" style="margin-right: 10px">{{notifText}}</h3>
                    <i v-if="!maxNumberReached" v-on:click="notificationShow"
                       class="inverted circular add  link green  icon"></i>
                </div>
                <div v-for="(notification, key) in notifications" class="ui row">
                    <div class="ui fluid grid">
                        <div class="ten wide column">
                            <span>
                                <b v-if="notification.beforeNotif == 0">{{atStart}}</b>
                                <b v-else-if="notification.beforeNotif == 1">{{notification.beforeNotif}} {{hourBefore}}</b>
                                <b v-else>{{notification.beforeNotif}} {{hoursBefore}}</b>
                            </span>
                        </div>
                        <div class="six wide column">
                            <span v-on:click="editNotification(notification, key)"
                                  class="ui circular blue icon mini basic button"><i class="ui  edit icon"></i></span>
                            <span v-on:click="removeNotification(key)"
                                  class="ui circular  red icon mini basic button"><i
                                    class="ui   remove icon"></i></span>
                        </div>
                    </div>
                </div>
                <div v-show="showNotif" class="ui row">
                    <div class="eight wide column">
                        <div class="ui fluid selection dropdown">
                            <input v-bind:id="notifId" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">{{notifTime}}</div>
                            <div class="menu">
                                <div class="item notifItems" v-on:click="addNotif(0)" data-value="0">{{atStart}}</div>
                                <div class="item notifItems" v-on:click="addNotif(1)"
                                     data-value="1">1 {{hourBefore}}</div>
                                <div class="item notifItems" v-on:click="addNotif(8)"
                                     data-value="8">8 {{hoursBefore}}</div>
                                <div class="item notifItems" v-on:click="addNotif(12)"
                                     data-value="12">12 {{hoursBefore}}</div>
                                <div class="item notifItems" v-on:click="addNotif(24)"
                                     data-value="24">24 {{hoursBefore}}</div>
                                <div class="item notifItems" v-on:click="showOther" data-value="other">{{other}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui row notifOther" style="display: none">
                    <div class="ten wide column">

                        <div class="ui labeled  input">
                            <input v-model="notifHourOther" type="number"/>
                            <label class="ui label">{{hoursBefore}} </label>
                        </div>
                    </div>
                </div>
                <div style="display: none" class="ui row notifOther">
                    <div class="four wide column">
                        <div v-on:click="addNotifOther" class="ui green icon button"><i class="ui plus icon"></i>{{addText}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Бутони -->
        <div class="actions">
            <div v-on:click="submit" class="ui blue button">{{save}}</div>
            <div class="ui negative button">{{no}}..</div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id',
        'header',
        'question',
        'beginning',
        'save',
        'no',
        'postUrl',
        'editUrl',
        'theHours',
        'theMinutes',
        'notValid',
        'notifText',
        'atStart',
        'hourBefore',
        'hoursBefore',
        'other',
        'notifTime',
        'addText',
        'maxNumOfNotifications',
        'date',
        'dayId',
        'monthId',
        'months'
    ],

    mounted() {
        if (this.id === "postModal") {
            this.notifId = "notifHourPost"
        } else {
            this.notifId = "notifHourEdit"
        }
    },

    data: function () {
        return {
            wholeDay:false,
            errors: {},
            name: '',
            eventId: "",
            notifications: [],
            notifHour: '',
            notifHourOther: '',
            showNotif: false,
            notifId: '',
            loadedDate: '',
        }
    },
    methods: {
        showOther: function () {
            $('.notifOther').show();
            setTimeout(() => {
                $('#postModal').modal('refresh');
                $('#editModal').modal('refresh');
            }, 300);

        },

        /**
         * добавя известие
         */
        addNotif: function (hour) {
            $('.notifOther').hide();
            if (this.notifications.indexOf(hour) == -1) {
                var hourArray = {beforeNotif: hour};
                this.notifications.push(hourArray)
            }
            $('#postModal').modal('refresh');
            $('#editModal').modal('refresh');
            this.showNotif = !this.showNotif
        },
        /**
         * toggle -ва дабавянето на известия
         */
        notificationShow: function () {
            this.showNotif = !this.showNotif
        },
        /**
         * добавя известие което е добавено от полето "друго"
         */
        addNotifOther: function () {
            ;
            var hour = this.notifHourOther;
            $('.notifOther').hide();
            $('#postModal').modal('refresh');
            $('#editModal').modal('refresh');
            if (this.notifications.indexOf(hour) == -1) {
                var hourArray = {beforeNotif: hour}
                this.notifications.push(hourArray)
            }
            this.showNotif = !this.showNotif
        },
        /**
         * променя известие
         */
        editNotification: function (time, key) {
            var hoursArray = [0, 1, 8, 12, 24]
            if (hoursArray.indexOf(parseInt(time)) == -1) {
                $('#' + this.notifId).val('other')
                $('.default').text(this.other)
                $('.notifOther').show()
                this.notifHourOther = time
            } else {
                $('#' + this.notifId).val(time)
                if (parseInt(time) == 0) {
                    var text = this.atStart
                } else if (parseInt(time) == 1) {
                    var text = "" + time + " " + this.hourBefore
                } else {
                    var text = "" + time + " " + this.hoursBefore
                }
                $('.default').text(text)
            }
            this.showNotif = !this.showNotif;
            this.notifications.splice(key, 1)
        },
        /*
         * изтрива известие
         */
        removeNotification: function (key) {
            this.notifications.splice(key, 1)
        },
        //Проверява дали създава или редактира
        submit: function () {
            if (this.id == "postModal") {
                var url = this.postUrl;
                var modal = "postModal";
            } else {
                var url = this.editUrl;
                var modal = "editModal";
            }

            this.createEvent(url, modal);
        },
        /**
         * Създава или редактира асинхронно събитие
         * @param string url
         * @param string modal
         */
        createEvent: function (url, modal) {
            var vue = this;

            var startDate = $('#calendarStart').getDate()
            var endDate = $('#calendarEnd').getDate()

            var data = {
                name: vue.name,
                startDate: startDate,
                endDate: endDate,
                notifications: vue.notifications,
                event_id: vue.eventId
            };
            axios.post(url, data).then(response => {
                vue.errors = [];
                vue.name = '';
                vue.startHour = null;
                vue.endHour = null;
                vue.startMinutes = null;
                vue.endMinutes = null;
                vue.notifications = [];
                $('#' + modal).modal('hide');
                var event = response.data.event;
                $('#' + event.id).remove();
                eventNew(event);
            }).catch(function (error) {
                navigator.vibrate([100, 100, 200]);
                var errs = error.response.data.errors;
                vue.errors = errs
            })
        },
        /**
         * Зарежда данни в модала за редактиране
         * @param string event_id
         */
        showEditModal: function (event_id) {
            var vue = this
            axios.get('/calendar/getOneEvent', {
                params: {
                    event_id: event_id
                }
            }).then(response => {
                var event = response.data.event;
                vue.name = event.name;
                vue.startHour = event.startHour;
                vue.startMinutes = event.startMinutes;
                vue.endHour = event.endHour;
                vue.endMinutes = event.endMinutes;
                vue.eventId = event.id;
                vue.notifications = event.notifications;
                vue.loadedDate = event.day;
                $('#editModal').modal('show');
                setTimeout(() => {
                    $('#editModal').modal('refresh');
                }, 200);

            })
        },
        /**
         * Прави валидация дали стойностите на минутите/часовете са правилни
         * @param value
         * @param type:string  - 'min'|'hour'
         * @param is_end_hour дали полето е "краен час " (крайния час може да е = 24)
         */

    },
    watch: {
        notifHour: function (value) {
            console.log(value);
            if (value === "other") {
                this.showOther = true
            } else {
                this.showOther = false
            }
        },
        maxNumberReached: function () {
            if (this.maxNumberReached) {
                this.errors.push('Твърде много известия')
            }
        }
    }
    ,
    computed: {
        hasErrors: function () {
            return Boolean(Object.keys(this.errors).length);
        }
        ,
        maxNumberReached: function () {
            return this.notifications.length >= this.maxNumOfNotifications
        }
    }

}
</script>
