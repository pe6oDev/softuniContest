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
                <!--Полета за дата-->
                <div v-show="date === ''" class="ui row">
                    <div class="ui column seven wide">
                        <select v-model="selectedDay" v-bind:id="dayId" class="ui fluid dropdown">
                            <option value="">Ден</option>
                            <option v-for="n in 31" v-bind:value="n">{{n}}</option>
                        </select>
                    </div>
                    <div class="ui column seven wide">
                        <select v-model="selectedMonth" v-bind:id="monthId" class="ui fluid dropdown">
                            <option value="">Месец</option>
                            <option v-for="n in 12" v-bind:value="n">{{months[n]}}</option>
                        </select>
                    </div>
                </div>
                <!--Полета за начало, край и продължителност-->
                <div class="ui row">
                    <div class="ui eight wide column one column grid ">
                        <div class="column">
                            <h4 class="subheader" style="text-align: center">{{beginning}}</h4>
                        </div>
                        <div class="ui column">
                            <div class="ui fluid   input">
                                <input v-model="startHour" type="number" name="startHour" min="0" max="24"
                                       v-bind:placeholder="hour">
                                <span style="font-size: 25px"><b>&nbsp;:&nbsp;</b></span>
                                <input v-model="startMinutes" type="number" name="startMinutes" min="0" step="5"
                                       max="59" v-bind:placeholder="minutes">
                            </div>
                        </div>
                    </div>

                    <div class="ui eight wide column one column grid">
                        <div class="column">
                            <h4 class="subheader">{{end}}</h4>
                        </div>
                        <div class="ui column">
                            <div class="ui fluid   input">
                                <input v-model="endHour" type="number" name="endHour" min="0" max="24"
                                       v-bind:placeholder="hour">
                                <span style="font-size: 25px"><b>&nbsp;:&nbsp;</b></span>
                                <input v-model="endMinutes" type="number" name="endMinutes" min="0" step="5" max="59"
                                       v-bind:placeholder="minutes">
                                <input v-model="eventId" type="hidden">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui row">
                    <div class="ui fifteen wide column one column grid">
                        <div class="column">
                            <h4 class="subheader" style="text-align: center">{{duration}}</h4>
                        </div>
                        <div class="ui column">
                            <div class="ui fluid   input">
                                <input v-model="durationHour" type="number" name="durationHour" min="0" max="24"
                                       v-bind:placeholder="hour">
                                <span style="font-size: 25px"><b>&nbsp;:&nbsp;</b></span>
                                <input v-model="durationMin" type="number" name="durationMin" min="0" step="5"
                                       max="59" v-bind:placeholder="minutes">
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
            <div v-on:click="submit" class="ui green button">{{save}}</div>
            <div class="ui negative button">{{no}}..</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id',
            'dayMonth',
            'header',
            'question',
            'beginning',
            'hour',
            'minutes',
            'end',
            'duration',
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
                errors: {},
                name: '',
                endHour: "",
                startHour: "",
                startMinutes: "",
                endMinutes: "",
                eventId: "",
                oldDuration: '',
                oldDurMin: '',
                durPlusHour: 0,
                currentTyping: '', //кое поле се попълва в момента
                lastEmpty: '', //кое поле е било празно последно
                notifications: [],
                notifHour: '',
                notifHourOther: '',
                showNotif: false,
                notifId: '',
                loadedDate: '',
                selectedDay: '',
                selectedMonth: ''
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

                if (vue.id === "postModal") {
                    var date = vue.dayMonth
                } else {
                    var date = vue.loadedDate
                }

                var data = {
                    name: vue.name,
                    startHour: parseInt(vue.startHour),
                    startMinutes: parseInt(vue.startMinutes),
                    endHour: parseInt(vue.endHour),
                    endMinutes: parseInt(vue.endMinutes),
                    dayMonth: date,
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
            validate: function (value, type, index) {
                var vue = this;
                //Задава в кое поле се попълва в момента
                this.currentTyping = $('#' + this.id + ' :focus').attr('name');
                //задава, кое поле е отанало не попълнено от потребителя
                let lastEmpty = $('#' + this.id + ' input').filter(function () {
                    return $(this).val() == "" && $(this).attr('type') == 'number';
                })[0];
                if (lastEmpty) {
                    this.lastEmpty = $(lastEmpty).attr('name');
                }

                value = Number(value);
                let min = 0;
                let max = 23;
                let dict = {
                    'min': vue.theMinutes,
                    'hour': vue.theHours
                };
                if (type == 'min') {
                    max = 59;
                }
                if (value < min || max < value) {
                    this.errors[index] = dict[type] + vue.notValid;
                } else {
                    let oldErrs = this.errors;
                    delete oldErrs[index];
                    this.errors = oldErrs;
                }

            }
        },
        watch: {
            //При промяна валидират дали стойностите са правилни
            endMinutes: function (m) {
                this.validate(m, 'min', 'endMinutes')
            }
            ,
            startMinutes: function (m) {
                this.validate(m, 'min', 'startMinutes')
            }
            ,
            endHour: function (h) {
                this.validate(h, 'hour', 'endHour')
            }
            ,
            startHour: function (h) {
                this.validate(h, 'hour', 'startHour')
            }
            ,
            durationHour: function (h) {
                this.validate(h, 'hour', 'durationHour')
            }
            ,
            durationMin: function (m) {
                this.validate(m, 'min', 'durationMin')
            }
            ,
            notifHour: function (value) {
                console.log(value)
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
            ,
            //Изчислява празните полета за часове и минути
            durationHour: {
                // getter
                get: function () {

                    if (this.endHour !== ''
                        && this.endMinutes !== ''
                        && this.startHour !== ''
                        && this.startMinutes !== ''
                        && this.currentTyping !== 'durationHour'
                        && this.currentTyping !== 'durationMin') {

                        let d = this.endHour - this.startHour;
                        if (d < 0) {
                            this.oldDuration = 24 + d - this.durPlusHour;
                            return 24 + d - this.durPlusHour;
                        }
                        this.oldDuration = d - this.durPlusHour;
                        return d - this.durPlusHour;
                    } else if ((this.currentTyping == 'durationHour' || this.currentTyping == 'durationMin')) {
                        //задава край
                        if (this.lastEmpty == 'endMinutes' || this.lastEmpty == 'endHour') {
                            var e = Number(this.oldDuration) + Number(this.startHour) + this.durPlusHour;
                            var end = e < 24 ? e : e - 24;
                            if (this.endHour === '' && this.startHour !== '') {
                                this.endHour = end
                            } else if (Number(this.endHour) != Number(end) && this.startHour !== '') {
                                this.endHour = end
                            }
                        } else {
                            //задава начало
                            var s = Number(this.endHour) - Number(this.oldDuration) - this.durPlusHour;
                            var start = s < 0 ? s + 24 : s;
                            if (this.startHour === '' && this.endHour !== '') {
                                this.startHour = start
                            } else if (Number(this.startHour) != Number(start) && this.endHour !== '') {
                                this.startHour = start
                            }
                        }


                    }
                    return this.oldDuration
                }
                ,
                // setter
                set: function (v) {
                    this.oldDuration = v;
                    if (!v) {
                        return;
                    }
                    let dur = Number(v);
                    if (this.startHour !== '' && this.startMinutes !== '' && this.endMinutes !== '') {//ако е зададен начален час

                        let start = Number(this.startHour);
                        if (start + dur >= 24) {
                            this.endHour = start + dur - 24 + this.durPlusHour;
                        } else {
                            this.endHour = start + dur + this.durPlusHour
                        }
                    } else if (this.endHour !== '' && this.endMinutes !== '' && this.startMinutes !== '') {//ако е зададен САМО краен час
                        let end = Number(this.endHour);
                        if (end - dur < 0) {
                            this.startHour = 24 + (end - dur) + this.durPlusHour;
                        } else {
                            this.startHour = end - dur + this.durPlusHour
                        }
                    }


                }
            }
            ,
            durationMin: {
                // getter
                get: function () {
                    console.log('duration min getter');

                    if (this.endMinutes === '' || this.startMinutes === '') {
                        return this.oldDurMin
                    }
                    if (Number(this.endMinutes) >= Number(this.startMinutes)) {
                        this.oldDurMin = this.endMinutes - this.startMinutes;
                        this.durPlusHour = 0;
                        return this.endMinutes - this.startMinutes;
                    }
                    this.oldDurMin = 60 - Math.abs(this.endMinutes - this.startMinutes);
                    this.durPlusHour = 1;
                    return 60 - Math.abs(this.endMinutes - this.startMinutes); //има добавен час
                }
                ,
                // setter
                set: function (v) {
                    if (!v) {
                        return;
                    }
                    this.oldDurMin = v;
                    if (this.startMinutes !== '' && this.lastEmpty != 'startMinutes' && this.lastEmpty != 'startHour') {
                        let d = Number(v);//duration
                        let s = Number(this.startMinutes);//start
                        if ((d + s) < 60) {
                            this.endMinutes = d + s;
                            this.durPlusHour = 0;
                        }
                        else {
                            let end = (d + s) - 60;
                            this.durPlusHour = 1;
                            this.endMinutes = end;//има добавен час
                        }
                    } else if (this.endMinutes !== '') {
                        let d = Number(v);//duration
                        let e = Number(this.endMinutes);//end
                        if ((e - d ) >= 0) {
                            this.startMinutes = e - d;
                            this.durPlusHour = 0;
                        }
                        else {
                            let start = e - d + 60;
                            this.durPlusHour = 1;
                            this.startMinutes = start;//има добавен час
                        }
                    }
                }
            }

        }

    }
</script>
