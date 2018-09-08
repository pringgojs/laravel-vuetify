
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'

Vue.use(Vuetify, VueRouter, {
    iconfont: 'mdi' // 'md' || 'mdi' || 'fa' || 'fa4'
})

import Layout from './components/Layout.vue';


Vue.component('layout', require('./components/Layout.vue'));


const routes = [{
        path: '/layout',
        component: Layout,
        name: 'layout'
    }
]

const router = new VueRouter({
    routes
})

// Add title in header
router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    next()
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});
