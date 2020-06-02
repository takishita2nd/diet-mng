
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
Vue.component('weight-dashboard-component', require('./components/WeightDashboardComponent.vue'));
Vue.component('weight-input-dialog-component', require('./components/WeightInputDialogComponent.vue'));
Vue.component('weight-edit-dialog-component', require('./components/WeightEditDialogComponent.vue'));
Vue.component('weight-delete-dialog-component', require('./components/WeightDeleteDialogComponent.vue'));
Vue.component('weight-list-component', require('./components/WeightListComponent.vue'));

const app = new Vue({
    el: '#app'
});
