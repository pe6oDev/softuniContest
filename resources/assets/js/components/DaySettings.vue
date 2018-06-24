<template>
    <div class="ui row">
        <div class="six wide column">
            <div class="ui calendar" id="calendar">
                <div class="ui input fluid left icon">
                    <i class="calendar icon"></i>
                    <input type="text"  placeholder="неработен ден "/>
                </div>
            </div>
        </div>
        <div class="three wide column">
            <i v-on:click="addDay"
               class="inverted circular add  link blue icon"></i>
        </div>
        <div class="ui divider"></div>
        <div class="ui eight wide center aligned column" v-for="(date,i) in dates">
            <div class="ui segment" style="padding: 10px 10px 10px 10px">
                {{date.normalDate}}
                <div v-on:click="deleteDate(date._id, i)" class="ui icon  small circular red button">
                    <i class="icon trash"></i>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props:[
            'saveUrl',
            'getUrl',
            'deleteUrl'
        ],
        mounted() {
            console.log('Component mounted.')
            axios.get(this.getUrl).then(response => {
                this.dates = response.data.restDays
            })
        },
        data: function(){
            return {
                dates:[]
            }
        },
        methods: {
            addDay: function(){
                if($('#calendar').calendar('get date')){
                    var restDay =  $('#calendar').calendar('get date')
                    var data = {restDay: restDay}
                    axios.post(this.saveUrl, data).then(response => {
                        this.dates.push(response.data.newRest);
                        $('#calendar').calendar('clear');
                        this.date = null;
                    })
                }

            },
            deleteDate:function(id, i){
                this.dates.splice(i);
                var data = {id: id}
                axios.post(deleteUrl, data).then(response => {

                })
            }
        },
//        filters: {
//            humandate: function (value) {
//                let date = new Date(value);
//                return  date.getUTCDate()+' . '+(date.getUTCMonth()+1) +' . '+date.getFullYear();
//            }
//        },
//        watch:{
//            //За промяна на датите (заявка отзад)
//            dates:function(){
//                axios.post(this.saveUrl,{
//                    dates:this.dates
//                })
//            }
//        }
    }
</script>
