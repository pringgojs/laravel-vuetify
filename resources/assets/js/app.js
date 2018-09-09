
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';

import Layout from './components/Layout.vue';
import Home from './components/Home.vue';
import ETugas from './components/ETugas.vue';
import Schedule from './components/Schedule.vue';
import Materi from './components/Materi.vue';
import Report from './components/Report.vue';
import Login from './components/Login.vue';

Vue.use(Vuetify);
Vue.use(VueRouter);

Vue.component('example', require('./components/Example.vue'));
Vue.component('layout', require('./components/Layout.vue'));
Vue.component('home', require('./components/Home.vue'));
Vue.component('e-tugas', require('./components/ETugas.vue'));
Vue.component('schedule', require('./components/Schedule.vue'));
Vue.component('report', require('./components/Report.vue'));
Vue.component('materi', require('./components/Materi.vue'));
Vue.component('login', require('./components/Login.vue'));


const routes = [
    {
        path: '/layout',
        component: Layout,
        name: 'layout',
        meta: { title: 'Beranda - Dosen Jaga'}

    },
    {
        path: '/home',
        component: Home,
        name: 'home',
        meta: { title: 'Beranda - Dosen Jaga'}
    },
    {
        path: '/e-tugas',
        component: ETugas,
        name: 'e-tugas',
        meta: { title: 'E Tugas - Dosen Jaga'}

    },
    {
        path: '/materi',
        component: Materi,
        name: 'materi',
        meta: { title: 'Materi - Dosen Jaga'}
    },
    {
        path: '/report',
        component: Report,
        name: 'report',
        meta: {
            title: 'Laporan - Dosen Jaga'
        }

    },
    {
        path: '/schedule',
        component: Schedule,
        name: 'schedule',
        meta: {
            title: 'Jadwal - Dosen Jaga'
        }

    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            title: 'Login - Dosen Jaga'
        }

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


new Vue({
    el: "#app",
    router: router
})