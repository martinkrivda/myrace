
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
Vue.component(
    'example-component',
    require('./components/ExampleComponent.vue').default
);
Vue.component(
    'assign-tag',
    require('./components/assignTag/assignTag.vue').default
);
Vue.component(
    'store-tag',
    require('./components/assignTag/storeTag.vue').default
);
Vue.component(
    'user-profile',
    require('./components/Profile.vue').default
);
Vue.component(
    'user-detail',
    require('./components/ProfileSettings.vue').default
);
Vue.component(
    'user-organiser',
    require('./components/ProfileOrganiser.vue').default
);
Vue.component(
    'battery-level',
    require('./components/util/BatteryLevel.vue').default
);
Vue.component(
    'clock',
    require('./components/util/Clock.vue').default
);

const app = new Vue({
    el: '#app'
});
