<template>
    <div class="ui row">
        <div class="three wide column">
            <div class="ui calendar" id="calendar">
                <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input type="text" v-model="date" placeholder="Начало"/>
                </div>
            </div>
        </div>
        <div class="two wide column">
            <i v-on:click="addDay"
               class="inverted circular add  link red icon"></i>
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
                date: ''
            }
        },
        methods: {
            addDay: function(){

            }
        }
    }
</script>
