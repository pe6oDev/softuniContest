<template>
    <div class="ui row">
        <div class="six wide column">
            <div class="ui form">
                <div class="ui two fields">
                    <div class="ui field">
                        <div class="ui calendar" id="calendarStart">
                            <div class="ui input fluid left icon">
                                <i class="calendar icon"></i>
                                <input type="text"  placeholder="начало на промоцията"/>
                            </div>
                        </div>
                    </div>
                    <div class="ui field">
                        <div class="ui calendar" id="calendarEnd">
                            <div class="ui input fluid left icon">
                                <i class="calendar icon"></i>
                                <input type="text"  placeholder="край  на промоцията"/>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="ui field">
                    <input v-model="name" placeholder="заглавие на промоцията" type="text"/>
                </div>
                <div class="field">
                    <textarea v-model="description">Информация</textarea>
                </div>

            </div>

            <br><br><br>
        </div>
        <div class="three wide column">
            <i v-on:click="addDay"
               class="inverted circular add  link blue icon"></i>


        </div>



        <div class="ui eight wide center aligned column" v-for="(day,i) in promotions">
            <div class="ui segment" style="padding: 10px 10px 10px 10px">
                {{day.start | humandate }} -  {{day.end | humandate }}:  {{day.name}}
                &nbsp;&nbsp;
                <div v-on:click="deleteDate(i)" class="ui icon  small circular red button">
                    <i class="icon trash"></i>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    props: ['saveUrl'],
    data: function () {
        return {
            promotions: [],
            name: '',
            description: 'описание'
        }
    },
    methods: {
        addDay: function () {
            if ($('#calendarStart').calendar('get date') && $('#calendarEnd').calendar('get date') && this.name && this.description) {
                this.promotions.push({
                    'start': $('#calendarStart').calendar('get date'),
                    'end': $('#calendarEnd').calendar('get date'),
                    'name':this.name,
                    'description': this.description,
                });
                $('#calendarStart').calendar('clear');
                $('#calendarEnd').calendar('clear');
                this.name = '';
                this.description = '';
            }

        },
        deleteDate: function (i) {
            this.promotions.splice(i, 1);
        }
    },
    filters: {
        humandate: function (value) {
            let date = new Date(value);
            return date.getUTCDate() + '.' + (date.getUTCMonth() + 1) + '.' + date.getFullYear();
        }
    },
    watch: {
        //За промяна на датите (заявка отзад)
        dates: function () {
            axios.post(this.saveUrl, {
                dates: this.promotions
            })
        }
    }
}
</script>
