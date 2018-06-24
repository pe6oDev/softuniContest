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
        <div class="ui sixteen wide center aligned column" v-for="(date,i) in dates">
            <div class="ui segment" style="padding: 10px 10px 10px 10px">
                {{date}}
                <div v-on:click="delete(i)" class="ui icon  small circular red button">
                    <i class="icon trash"></i>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data: function(){
            return {
                dates:[]
            }
        },
        methods: {
            addDay: function(){
                this.dates.push ( $('#calendar').calendar('get date')) ;
                $('#calendar').calendar('clear');
                this.date=null;
            },
            delete:function(i){
                delete this.dates[0]
            }
        }
    }
</script>
