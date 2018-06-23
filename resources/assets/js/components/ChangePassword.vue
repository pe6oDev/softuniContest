<!--
модал За сменяне на паролата
-->
<template>
    <div id="changePasswordModal" class=" ui  басиц small  vary modal">
        <i class="close icon"></i>
        <div class=" header ">{{header}}</div>
        <div class="content">
            <div v-bind:class="{'error':hasErrors, 'success':success, 'loading':loading}" class="ui form">
                <!--Съобщение за успещно сменяне-->
                <div class="ui success message">
                    {{successMessage}}
                </div>
                <!--Съобщения за грешки-->
                <div class="ui error message">
                    <ul>
                        <li v-for="err in validationErrors">
                            {{err[0] | capitalize }}
                        </li>
                    </ul>
                </div>
                <!--Старата парола-->
                <div v-bind:class="{'error':validationErrors['oldPass']}" class="ui field">
                    <label for="">{{оldPassLabel}}</label>
                    <input v-model="oldPass" type="password" v-bind:placeholder="inputTranslated+' '+оldPassLabel">
                </div>
                <!--Новата парола-->
                <div v-bind:class="{'error':validationErrors['newPass']}" class="ui field">
                    <label for=""> {{newPassLabel}}</label>
                    <input v-model="newPass" type="password" v-bind:placeholder="inputTranslated+' '+newPassLabel">
                </div>
                <!--Потвърждение на паролата-->
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
    props: [
        'changePassUrl',  //адреса към койот се прави post request
        'passwordConfirmationError', //превод на грешката за несъвпадащи пароли
        'successMessage', //превод на съобщението за успех
        'header', //превид на header-a
        'inputTranslated', // 'input'|'поле за въвеждане'
        "оldPassLabel", // превод на "стара парола"
        "newPassLabel", //превод на "нова парола"
        "okLabel", // превод на "готово"
        "cancelLabel"//превод на "отказ"
    ],
    data: function () {
        return {
            oldPass: '',
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
                return;
            }
            this.success = false;
            this.validationErrors['confirmation'] = [this.passwordConfirmationError];
            this.hasError = true;
            this.confirmationError = true;
            navigator.vibrate([100, 100, 200]);
            return;
        }
    },
    methods: {
//        асинхронна заявка към сървъра
        changePass: function () {
            var vue = this;
            vue.loading = true;
            axios.post(this.changePassUrl, {
                oldPass: this.oldPass,
                newPass: this.newPass,
                newPass_confirmation: this.newPassConfirm
            })
                .then(function (responce) {
                    vue.loading = false;
                    vue.success = true;
                    vue.validationErrors = {};
                    vue.oldPass = '';
                    vue.newPass = '';
                    vue.newPassConfirm = '';
                })
                .catch(function (error) {
                    vue.loading = false;
                    vue.success = false;
                    navigator.vibrate([100, 100, 200]);
                    vue.validationErrors = error.response.data.errors;
                });
        }
    },
    computed: {
        hasErrors: function () {
            return !_.isEmpty(this.validationErrors);
        }
    },
    filters: {
        capitalize: function (value) {
            if (!value) return '';
            value = value.toString();
            return value.charAt(0).toUpperCase() + value.slice(1)
        }
    }

}
</script>

<!--За полето за потвърждение на паролата-->
<style>
.slide-fade-enter-active {
    transition: all .25s ease;
}
.slide-fade-leave-active {
    transition: all .8s  cubic-bezier(.04,1.08,1,.47)
}
.slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}
</style>