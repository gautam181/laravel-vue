/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');


//import configuration
import settings from "./config/Settings";
import titleComponent from './components/head/Title';

import Vue from 'vue';

Vue.component('vue-title', titleComponent);
//plugins
import VueRouter from 'vue-router'
import Datatable from 'vue2-datatable-component'
import { Plugin } from 'vue-fragment'
import BootstrapVue from 'bootstrap-vue'
import VueBreadcrumbs from 'vue-breadcrumbs'


window.Vue = require('vue');
Vue.prototype.$user = window.user;
Vue.prototype.$app = window.application;
Vue.prototype.$settings = settings;
Vue.use(Datatable);
Vue.use(Plugin);
Vue.use(require('vue-moment'));
Vue.use(BootstrapVue);
Vue.use(VueBreadcrumbs, {
    template: '<ol class="hbreadcrumb breadcrumb" v-if="$breadcrumbs.length"> ' +
        '<router-link class="breadcrumb-item" v-for="(crumb, key) in $breadcrumbs" :to="linkProp(crumb)" :key="key">{{ crumb | crumbText }}</router-link> ' +
        '</ol>'
});
/**
 * Router
 */
import routes from './config/Routes'

Vue.use(VueRouter);
const router = new VueRouter({
    //mode: 'history',
    routes // short for `routes: routes`
});

router.beforeEach((to, from, next) => {
    const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);
    if(nearestWithTitle) document.title = nearestWithTitle.meta.title;
    return next();
});

//Global variables
import App from './App.vue'

new Vue({
    render: h => h(App),
    router
}).$mount('#app');
