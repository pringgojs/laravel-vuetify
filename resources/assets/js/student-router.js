import Vue from 'vue'
import Router from 'vue-router'
import Home from './components/student/Home.vue'
import ETugas from './components/student/ETugas.vue'
import Schedule from './components/student/Schedule.vue'
import Materi from './components/student/Materi.vue'
import Report from './components/student/Report.vue'

Vue.use(Router)

Vue.component('layout-student', require('./components/student/Layout.vue'))
Vue.component('beranda', require('./components/student/Home.vue'))
Vue.component('etugas', require('./components/student/ETugas.vue'))
Vue.component('jadwal', require('./components/student/Schedule.vue'))
Vue.component('laporan-tugas', require('./components/student/Report.vue'))
Vue.component('materi-kuliah', require('./components/student/Materi.vue'))


const routes = [{
        path: '/beranda',
        component: Home,
        name: 'beranda',
        meta: {
            title: 'Beranda - Dosen Jaga'
        }
    },
    {
        path: '/etugas',
        component: ETugas,
        name: 'etugas',
        meta: {
            title: 'Etugas - Dosen Jaga'
        }
    },
    {
        path: '/materi-kuliah',
        component: Materi,
        name: 'materi-kuliah',
        meta: {
            title: 'Materi - Dosen Jaga'
        }
    },
    {
        path: '/laporan',
        component: Report,
        name: 'laporan-tugas',
        meta: {
            title: 'Laporan - Dosen Jaga'
        }
    },
    {
        path: '/jadwal',
        component: Schedule,
        name: 'laporan',
        meta: {
            title: 'Jadwal - Dosen Jaga'
        }
    },
]

export default new Router({
    routes
})