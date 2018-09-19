import Vue from 'vue'
import Router from 'vue-router'
import Layout from './components/lecturer/Layout.vue'
import Home from './components/lecturer/Home.vue'
import ETugas from './components/lecturer/ETugas.vue'
import ETugasAdd from './components/lecturer/ETugasAdd.vue'
import ETugasEdit from './components/lecturer/ETugasEdit.vue'
import Schedule from './components/lecturer/Schedule.vue'
import Materi from './components/lecturer/Materi.vue'
import MateriAdd from './components/lecturer/MateriAdd.vue'
import Report from './components/lecturer/Report.vue'
import Login from './components/Login.vue'
import NotFound from './components/NotFound.vue'

Vue.use(Router)

Vue.component('layout', require('./components/lecturer/Layout.vue'))
Vue.component('home', require('./components/lecturer/Home.vue'))
Vue.component('e-tugas', require('./components/lecturer/ETugas.vue'))
Vue.component('e-tugas-add', require('./components/lecturer/ETugasAdd.vue'))
Vue.component('e-tugas-edit', require('./components/lecturer/ETugasEdit.vue'))
Vue.component('schedule', require('./components/lecturer/Schedule.vue'))
Vue.component('report', require('./components/lecturer/Report.vue'))
Vue.component('materi', require('./components/lecturer/Materi.vue'))
Vue.component('materi-add', require('./components/lecturer/MateriAdd.vue'))
Vue.component('login', require('./components/Login.vue'))
Vue.component('not-found', require('./components/NotFound.vue'))


const routes = [
    {
        path: '/',
        component: Layout,
        name: 'layout',
        meta: {
            title: 'Beranda - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/layout',
        component: Layout,
        name: 'layout',
        meta: {
            title: 'Beranda - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/home',
        component: Home,
        name: 'home',
        meta: {
            title: 'Beranda - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/e-tugas',
        component: ETugas,
        name: 'e-tugas',
        meta: {
            title: 'E Tugas - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/e-tugas/add',
        component: ETugasAdd,
        name: 'e-tugas-add',
        meta: {
            title: 'E Tugas Baru - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/e-tugas/edit/:id',
        component: ETugasEdit,
        name: 'e-tugas-edit',
        meta: {
            title: 'E Tugas Edit - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/materi',
        component: Materi,
        name: 'materi',
        meta: {
            title: 'Materi - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/materi/add',
        component: MateriAdd,
        name: 'materi-add',
        meta: {
            title: 'Materi Baru - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/report',
        component: Report,
        name: 'report',
        meta: {
            title: 'Laporan - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/schedule',
        component: Schedule,
        name: 'schedule',
        meta: {
            title: 'Jadwal - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            title: 'Login - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/not-found',
        component: NotFound,
        name: 'not-found',
        meta: {
            title: '404 - Dosen Jaga',
            type: 'lecturer'
        }
    }
]

export default new Router({
    routes
})