
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('change-password', require('./components/ChangePassword.vue'));
Vue.component('make-password', require('./components/MakePassword.vue'));
Vue.component('user-info', require('./components/UserMoreInfo.vue'));
Vue.component('event-modal', require('./components/EventModal.vue'));
Vue.component('admin-table', require('./components/AdminTable.vue'));
Vue.component('day-settings', require('./components/DaySettings.vue'));
Vue.component('name-days-settings', require('./components/NameDays.vue'));
Vue.component('promotions-settings', require('./components/Promotions.vue'));

const app = new Vue({
    el: '#app'
});
