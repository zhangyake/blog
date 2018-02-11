
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css';
// Vue.use(ElementUI);
import Vue from 'vue';

import store from './store'
import App from './App.vue';
import router from './router/index.js';

import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});