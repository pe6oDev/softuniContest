<template>
    <div class="ui grid">
        <div class="ui fourteen wide column">
            <div v-show="success" class="ui success message">
                Успешно променихте информацията
            </div>
            <div class="ui form">
                <div class="field">
                    <label> <h4 style="display: inline">Допълнителна информация </h4><span>(вижда се от потребителите, с които сте заедно в общност) </span>
                    </label>
                    <textarea v-model="info"></textarea>
                </div>

            </div>
        </div>
        <div class="ui two wide column">
            <br><br><br>
            <div v-on:click="update" class="ui circular orange icon button">
                <i class="ui check icon icon"></i>
            </div>
        </div>
    </div>

</template>


<script>
export default {
    mounted() {
        console.log('Component mounted.')
    },
    props:['propInfo'],
    data:function () {
        var info = this.propInfo;
        return {
            'info':info,
            'success':null
        }
    },
    methods:{
      update(){
          console.log('upd');
          var vue = this;
        axios.post('/user/more/info',{
            'info':vue.info
        }).then(function(){
            vue.success=true;
          })
      }
    }
}
</script>
