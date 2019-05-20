/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

//plugins
import VueRouter from 'vue-router'
import Datatable from 'vue2-datatable-component'
import { Plugin } from 'vue-fragment'

window.Vue = require('vue');
Vue.prototype.$user = window.user;
Vue.prototype.$app = window.application;
Vue.use(Datatable)
Vue.use(Plugin)
/**
 * Router
 */
import routes from './config/Routes'

Vue.use(VueRouter)
const router = new VueRouter({
    //mode: 'history',
    routes // short for `routes: routes`
})

//Global variables
import App from './App.vue'

new Vue({
    render: h => h(App),
    router
}).$mount('#app')
