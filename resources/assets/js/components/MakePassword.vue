<!--Модал за създаване на парола-->
<!--Защото потребителите влезлис с google акаунт нямат парола -->

<template>
    <div id="makePasswordModal" class=" ui  басиц small  vary modal">
        <i class="close icon"></i>
        <div class=" header ">{{header}}</div>
        <div class="content">
            <div v-bind:class="{'error':hasErrors, 'success':success, 'loading':loading}" class="ui form">
                <div class="ui success message">
                    {{successMessage}}
                </div>
                <div class="ui error message">
                    <ul>
                        <li v-for="err in validationErrors">
                            {{err[0] | capitalize }}
                        </li>
                    </ul>
                </div>
                <div v-bind:class="{'error':validationErrors['newPass']}" class="ui field">
                    <label for=""> {{newPassLabel}}</label>
                    <input v-model="newPass" type="password" v-bind:placeholder="inputTranslated+' '+newPassLabel">
                </div>
                <transition name="slide-fade">
                    <div v-if="newPass" v-bind:class="{'error':confirmationError}" class="ui field">
                        <label for="">потвърди паролата</label>
                        <input v-model="newPassConfirm" type="password" placeholder="потвърди паролата">
                    </div>
                </transition>
            </div>

        </div>
        <div class="ui actions">
            <div v-on:click="changePass" class="ui green button">{{okLabel}}</div>
            <div class="ui red cancel button">{{cancelLabel}}</div>
        </div>
    </div>

</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    },
    props: ['makePassUrl', 'passwordConfirmationError', 'successMessage','header','inputTranslated',"newPassLabel","okLabel","cancelLabel"],
    data: function () {
        return {
            newPass: '',
            newPassConfirm: '',
            confirmationError: false,
            validationErrors: {},
            success: false,
            loading: false,
        }

    },
    watch: {
        newPassConfirm: function () {
            if (this.newPassConfirm == this.newPass) {
                this.confirmationError = false;
                return
            }
            navigator.vibrate([100, 100, 200]);
            this.success = false;
            this.validationErrors['confirmation'] = [this.passwordConfirmationError];
            this.hasError = true;
            this.confirmationError = true;
            return;
        }
    },
    methods: {
        changePass: function () {
            var vue = this;
            vue.loading = true;
            axios.post(this.makePassUrl, {
                newPass: this.newPass,
                newPass_confirmation: this.newPassConfirm
            })
                .then(function (responce) {
                    vue.loading = false;
                    vue.success = true;
                 //   vue.validationErrors = {};
                    vue.newPass = '';
                    vue.newPassConfirm = '';
                })
                .catch(function (error) {
                    vue.loading = false;
                    vue.success = false;
                    navigator.vibrate([100, 100, 200]);
                //    vue.validationErrors = error.response.data.errors;
                })
            ;

        }
    },
    computed: {
        hasErrors: function () {
            return !_.isEmpty(this.validationErrors);
        }
    },
    filters: {
//        за да прави грешките с главна първа буква
        capitalize: function (value) {
            if (!value) return '';
            value = value.toString();
            return value.charAt(0).toUpperCase() + value.slice(1)
        }
    }

}
</script>

<!--за полето за потвърдение на паролата-->
<style>

.slide-fade-enter-active {
    transition: all .25s ease;
}
.slide-fade-leave-active {
    transition: all .8s  cubic-bezier(.04,1.08,1,.47)
    /*cubic-bezier(1.0, 0.5, 0.8, 1.0);*/
}
.slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
}
</style>