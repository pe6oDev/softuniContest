<template>
    <div class="ui row">
        <div class="six wide column">
            <div class="ui form">
                <div class="ui field">
                    <div class="ui calendar" id="calendar">
                        <div class="ui input fluid left icon">
                            <i class="calendar icon"></i>
                            <input type="text"  placeholder="именн ден "/>
                        </div>
                    </div>
                </div>
                <div class="ui field">
                    <input v-model="nameDay" placeholder="именн ден" type="text"/>
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



        <div class="ui eight wide center aligned column" v-for="(day,i) in nameDays">
            <div class="ui segment" style="padding: 10px 10px 10px 10px">
                {{day.normalDate}} - {{day.name}}
                &nbsp;&nbsp;
                <div v-on:click="deleteDate(day._id, i)" class="ui icon  small circular red button">
                    <i class="icon trash"></i>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        var vue = this
        console.log('Component mounted.')
        axios.get(this.getUrl).then(response => {
            vue.nameDays = response.data.nameDays
        })
    },
    props: [
        'saveUrl',
        'getUrl',
        'deleteUrl'
    ],
    data: function () {
        return {
            nameDays: [],
            nameDay: '',
            description: 'описание'
        }
    },
    methods: {
        addDay: function () {
            if ($('#calendar').calendar('get date') && this.nameDay && this.description) {
                var data = {
                    'date': $('#calendar').calendar('get date'),
                    'name':this.nameDay,
                    'description': this.description
                };
                axios.post(this.saveUrl, data).then(response => {
                    this.nameDays.push(response.data.newName)
                    $('#calendar').calendar('clear');
                    this.nameDay = '';
                    this.description = '';
                })
            }

        },
        deleteDate: function (id, i) {
            this.nameDays.splice(i, 1);
            var data = {id: id}
            axios.post(this.deleteUrl, data).then(response => {

            })
        }
    },
//    filters: {
//        humandate: function (value) {
//            let date = new Date(value);
//            return date.getUTCDate() + '.' + (date.getUTCMonth() + 1) + '.' + date.getFullYear();
//        }
//    },
//    watch: {
//        //За промяна на датите (заявка отзад)
//        dates: function () {
//            axios.post(this.saveUrl, {
//                dates: this.nameDays
//            })
//        }
//    }
}
</script>
