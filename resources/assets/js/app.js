
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('chart.js');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('weight-dashboard-component', require('./components/Weight/WeightDashboardComponent.vue'));
Vue.component('weight-input-dialog-component', require('./components/Weight/WeightInputDialogComponent.vue'));
Vue.component('weight-edit-dialog-component', require('./components/Weight/WeightEditDialogComponent.vue'));
Vue.component('weight-delete-dialog-component', require('./components/Weight/WeightDeleteDialogComponent.vue'));
Vue.component('weight-list-component', require('./components/Weight/WeightListComponent.vue'));

Vue.component('eating-dashboard-component', require('./components/Eating/EatingDashboardComponent.vue'));
Vue.component('eating-list-component', require('./components/Eating/EatingListComponent.vue'));
Vue.component('eating-detail-component', require('./components/Eating/EatingDetailComponent.vue'));
Vue.component('eating-input-dialog-component', require('./components/Eating/EatingInputDialogComponent.vue'));
Vue.component('eating-edit-dialog-component', require('./components/Eating/EatingEditDialogComponent.vue'));
Vue.component('eating-delete-dialog-component', require('./components/Eating/EatingDeleteDialogComponent.vue'));
Vue.component('eating-calc-target-calorie-component', require('./components/Eating/EatingCalcTargetCalorieComponent.vue'));

Vue.component('eating-history-component', require('./components/Eating/Maintenance/EatingHistoryComponent.vue'));

const app = new Vue({
    el: '#app'
});
