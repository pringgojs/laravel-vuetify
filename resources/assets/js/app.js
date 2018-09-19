
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import Vuetify from 'vuetify'
import LecturerRouter from './lecturer-router'
import StudentRouter from './student-router'
import 'es6-promise/auto'

Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(Vuex)

// Add title in header
LecturerRouter.beforeEach((to, from, next) => {
    if (!to.matched.length) {
        next('/not-found')
    } else {
        document.title = to.meta.title
        next()
    }
})


// Vuex store
const store = new Vuex.Store({
    state: {
        count: 1
    },
    mutations: {
        increment(state) {
            state.count++
        }
    }
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


new Vue({
    el: "#app",
    router: LecturerRouter, StudentRouter,
    store
})