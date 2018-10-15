<template>
    <v-flex sm12>
        <h1 class="font-weight-light">E Tugas</h1>
        <div class="subheading">Daftar tugas kuliah. Selesaikan tugas secara cepat dan tepat waktu</div>
        <content-loader v-if="!isLoaded" :height="250"></content-loader>
        <template>
            <v-container fluid grid-list-xl v-if="isLoaded">
                <v-layout wrap align-center>
                    <v-flex md4 mt-5 d-flex>
                        <v-select 
                            :items="filter.list_semester"
                            v-model="filter.semester"
                            label="Pilih semester"
                            item-text="tahun"
                            item-value="semester"
                            @change="selectKelas()"
                            solo
                        >
                            <template slot="selection" slot-scope="data">
                                {{ data.item.semester }}
                            </template>
                            <template slot="item" slot-scope="data">
                                {{ data.item.semester }}
                            </template>
                        </v-select>
                    </v-flex>
                    <v-flex md4 mt-5 d-flex>
                        <v-select 
                            :items="filter.list_kelas"
                            v-model="filter.kelas"
                            label="Pilih kelas"
                            item-text="kode"
                            item-value="nomor"
                            @change="selectMatakuliah()"
                            solo
                        >
                            <template slot="selection" slot-scope="data">
                                {{ data.item.kode }}
                            </template>
                            <template slot="item" slot-scope="data">
                                {{ data.item.kode }}
                            </template>
                        </v-select>
                    </v-flex>
                    <v-flex md4 mt-5 d-flex>
                        <v-select 
                            :items="filter.list_matakuliah"
                            v-model="filter.matakuliah"
                            label="Pilih matakuliah"
                            item-text="matakuliah"
                            item-value="nomor"
                            @change="selectData()"
                            solo
                        >
                            <template slot="selection" slot-scope="data">
                                {{ data.item.matakuliah }}
                            </template>
                            <template slot="item" slot-scope="data">
                                {{ data.item.matakuliah }}
                            </template>
                        </v-select>
                    </v-flex>
                </v-layout>
            </v-container>
        </template>
            
        <v-flex sm12 v-if="isLoaded">
            <v-data-table
                :headers="headerTable"
                :items="$store.state.obj_list_etugas"
                hide-actions
                class="elevation-1"
            >
                <template slot="items" slot-scope="props">
                    <tr :id="'tr-'+props.item.id">
                        <td style="min-width:250px">{{ props.item.modul }}</td>
                        <td class="text-xs-left" :id="'matakuliah-'+props.item.id">{{ props.item.matakuliah }}</td>
                        <td class="text-xs-left" :id="'kelas-'+props.item.id">{{ props.item.tahun }} / {{ props.item.semester }} - {{ props.item.program }} {{ props.item.jurusan }} ({{props.item.kelas}} {{props.item.pararel}})</td>
                        <td class="text-xs-left" :id="'dosen-'+props.item.id">{{ props.item.nama }}</td>
                        <td class="text-xs-left" :id="'judul-'+props.item.id">
                            <a slot="activator"  @click="detail(props.item.id)"> 
                                {{ props.item.judul }}
                            </a>
                        </td>
                        <td class="text-xs-center" :id="'keterangan-'+props.item.id">{{ props.item.keterangan }}</td>
                        <td class="text-xs-center" :id="'due-date-'+props.item.id">{{ dateView(props.item.due_date) }}</td>
                        <td class="text-xs-center">
                            <template v-if="props.item.file_url">
                                <a v-bind:href="props.item.file_url"> 
                                    Download file tugas
                                </a>
                            </template>
                        </td>
                        <td class="text-xs-center" :style="statusLate(props.item.due_date, props.item.nilai_mahasiswa)" :id="'due-date-'+props.item.id">{{ props.item.nilai_mahasiswa ? dateView(props.item.nilai_mahasiswa.updated_at) : '-'}}</td>
                        <td class="text-xs-center">{{ props.item.nilai_mahasiswa ? props.item.nilai_mahasiswa.nilai : ''}}</td>

                        <td class="text-xs-center">
                            <template v-if="!props.item.nilai_mahasiswa">
                                <v-btn flat icon color="pink">
                                    <v-icon>close</v-icon>
                                </v-btn>
                            </template>
                            <template v-if="props.item.nilai_mahasiswa">
                                <v-btn flat icon color="info">
                                    <v-icon>check</v-icon>
                                </v-btn>
                            </template>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-flex>

        <!-- modal -->
        <detail-etugas></detail-etugas>
    </v-flex>
</template>

<script>
import { ContentLoader } from 'vue-content-loader'
import * as moment from 'moment'
moment.locale('id')

export default {
    data () {
        return {
            headerTable: [
                { text: 'Modul', value: 'modul' },
                { text: 'Matakuliah', value: 'matakuliah' },
                { text: 'Kelas', value: 'kelas' },
                { text: 'Dosen', value: 'nama' },
                { text: 'Judul Tugas', value: 'judul' },
                { text: 'Keterangan', value: 'keterangan' },
                { text: 'Due Date', value: 'due_date' },
                { text: 'File Lampiran Tugas', value: 'file_url' },
                { text: 'Tanggal Upload', value: 'id' },
                { text: 'Nilai', value: 'nilai' },
                { text: 'Status', value: 'id' },
            ],
            
            filter: {
                list_semester: [],
                list_kelas: [],
                list_matakuliah: [],
                semester: '',
                kelas: '',
                matakuliah: '',
            },
            snackbarText: '',
            snackbar: false,
            isLoaded: false,
            dialog: false,
            title_confirm: '',
            desc_confirm: '',
            detail_id: ''
        }
    },
    components: {
        ContentLoader
    },
    mounted() {
        this.initData()
        let count = this.$store.state.count
    },
    methods: {
        initData() {
            var app = this
            axios.get('student/e-tugas').then(function (resp) {
                app.isLoaded = true
                app.$store.state.obj_list_etugas = null
                app.$store.state.obj_list_etugas =  resp.data.list_tugas
                app.filter.list_semester = resp.data.list_semester
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!")
            })
        },
        showSnackbar(text) {
            var app = this
            app.snackbarText = text
            app.snackbar = true
        },
        selectKelas() {
            if (!this.filter.semester) return false
            var app = this
            axios.get('filter/get-kelas/'+app.filter.semester).then(function (resp) {
                app.filter.list_kelas = ''
                app.filter.list_kelas = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        selectMatakuliah() {
            if (!this.filter.kelas) return false
            var app = this
            axios.post('filter/get-matakuliah', app.filter).then(function (resp) {
                app.filter.list_matakuliah = ''
                app.filter.list_matakuliah = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        selectData() {
            if (!this.filter.matakuliah) return false
            var app = this
            app.loadDetail = true
            axios.post('student/e-tugas/filter', app.filter).then(function (resp) {
                app.loadDetail = false
                app.bodyTable = ''
                app.$store.state.obj_list_etugas = null
                app.$store.state.obj_list_etugas =  resp.data
                console.log(resp.data)

            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        detail(id) {
            var app = this

            axios.get('student/e-tugas/detail/'+id).then(function (resp) {
                app.$store.state.obj_etugas = resp.data
                app.$store.state.form_dialog_detail_etugas = true
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!")
            })
        },
        dateView(date) {
            if (date != '0000-00-00 00:00:00') {
                return moment(date).format("dddd, Do MMMM YYYY, h:mm:ss a")
            }
            return '-'
        },
        statusLate(due_date, obj_nilai) {
            if (!obj_nilai) {
                return "color: red"
            }

            if (obj_nilai.updated_at > due_date) {
                return "color: red"
            }

            return ""
        }
    }
}
</script>

<style>
.fab-container {
  position: fixed;
  bottom: 20px;
  right: 0;
}
</style>
