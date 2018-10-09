import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

// lecturer
import Layout from './components/lecturer/Layout.vue'
import Home from './components/lecturer/Home.vue'
import ETugas from './components/lecturer/ETugas.vue'
import ETugasAdd from './components/lecturer/ETugasAdd.vue'
import ETugasEdit from './components/lecturer/ETugasEdit.vue'
import Schedule from './components/lecturer/Schedule.vue'
import Materi from './components/lecturer/Materi.vue'
import MateriAdd from './components/lecturer/MateriAdd.vue'
import NilaiPermodul from './components/lecturer/NilaiPermodul.vue'
import NilaiPermodulDetail from './components/lecturer/NilaiPermodulDetail.vue'
import Report from './components/lecturer/Report.vue'
import Login from './components/Login.vue'
import NotFound from './components/NotFound.vue'
import Redirect from './components/Redirect.vue'

// student
import StudentHome from './components/student/Home.vue'
import StudentETugas from './components/student/ETugas.vue'
import StudentSchedule from './components/student/Schedule.vue'
import StudentMateri from './components/student/Materi.vue'
import StudentReport from './components/student/Report.vue'
import StudentDetailEtugas from './components/student/DetailEtugas.vue'

// lecturer
Vue.component('layout', require('./components/lecturer/Layout.vue'))
Vue.component('home', require('./components/lecturer/Home.vue'))
Vue.component('e-tugas', require('./components/lecturer/ETugas.vue'))
Vue.component('e-tugas-add', require('./components/lecturer/ETugasAdd.vue'))
Vue.component('e-tugas-edit', require('./components/lecturer/ETugasEdit.vue'))
Vue.component('e-tugas-detail', require('./components/lecturer/EtugasDetail.vue'))
Vue.component('schedule', require('./components/lecturer/Schedule.vue'))
Vue.component('report', require('./components/lecturer/Report.vue'))
Vue.component('materi', require('./components/lecturer/Materi.vue'))
Vue.component('materi-add', require('./components/lecturer/MateriAdd.vue'))
Vue.component('nilai-permodul', require('./components/lecturer/NilaiPermodul.vue'))
Vue.component('nilai-permodul-detail', require('./components/lecturer/NilaiPermodulDetail.vue'))
Vue.component('login', require('./components/Login.vue'))
Vue.component('not-found', require('./components/NotFound.vue'))
Vue.component('redirect', require('./components/Redirect.vue'))

// // student
Vue.component('layout-student', require('./components/student/Layout.vue'))
Vue.component('beranda', require('./components/student/Home.vue'))
Vue.component('etugas', require('./components/student/ETugas.vue'))
Vue.component('jadwal', require('./components/student/Schedule.vue'))
Vue.component('laporan-tugas', require('./components/student/Report.vue'))
Vue.component('materi-kuliah', require('./components/student/Materi.vue'))
Vue.component('detail-etugas', require('./components/student/DetailEtugas.vue'))

const routes = [
    {
        path: '/',
        component: Redirect,
        name: 'redirect',
        meta: {
            title: 'redirect - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/layout',
        component: Layout,
        name: 'lecturerLayout',
        meta: {
            title: 'Beranda - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/home',
        component: Home,
        name: 'lecturerHome',
        meta: {
            title: 'Beranda - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/e-tugas',
        component: ETugas,
        name: 'lecturerEtugas',
        meta: {
            title: 'E Tugas - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/e-tugas/add',
        component: ETugasAdd,
        name: 'lecturerEtugasAdd',
        meta: {
            title: 'E Tugas Baru - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/e-tugas/edit/:id',
        component: ETugasEdit,
        name: 'lecturerEtugasEdit',
        meta: {
            title: 'E Tugas Edit - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/materi',
        component: Materi,
        name: 'lecturerMateri',
        meta: {
            title: 'Materi - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/materi/add',
        component: MateriAdd,
        name: 'lecturerMateriAdd',
        meta: {
            title: 'Materi Baru - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/report',
        component: Report,
        name: 'lecturerReport',
        meta: {
            title: 'Laporan - Dosen Jaga',
            type: 'lecturer'
        }
    },
    {
        path: '/schedule',
        component: Schedule,
        name: 'lecturerSchedule',
        meta: {
            title: 'Jadwal - Dosen Jaga',
            type: 'lecturer'
        }
    }, 
    {
        path: '/nilai-permodul',
        component: NilaiPermodul,
        name: 'nilaiPermodul',
        meta: {
            title: 'Nilai Permodul - Dosen Jaga',
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
        name: 'notFound',
        meta: {
            title: '404 - Dosen Jaga',
            type: 'lecturer'
        }
    },

    // student
    {
        path: '/beranda',
        component: StudentHome,
        name: 'studentBeranda',
        meta: {
            title: 'Beranda - Dosen Jaga'
        }
    }, {
        path: '/etugas',
        component: StudentETugas,
        name: 'studentEtugas',
        meta: {
            title: 'Etugas - Dosen Jaga'
        }
    }, {
        path: '/materi-kuliah',
        component: StudentMateri,
        name: 'studentMateri',
        meta: {
            title: 'Materi - Dosen Jaga'
        }
    }, {
        path: '/laporan',
        component: StudentReport,
        name: 'studentLaporan',
        meta: {
            title: 'Laporan - Dosen Jaga'
        }
    }, {
        path: '/jadwal',
        component: StudentSchedule,
        name: 'studentJadwal',
        meta: {
            title: 'Jadwal - Dosen Jaga'
        }
    },
]


export default new Router({
    routes
})