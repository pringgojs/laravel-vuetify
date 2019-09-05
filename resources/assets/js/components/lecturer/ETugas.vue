<template>
    <v-flex sm12>
        
        <h1 class="font-weight-light">E Tugas</h1>
        <div class="subheading">Tambahkan tugas sebagai bahan evaluasi mahasiswa dalam memahami pelajaran</div>
        
        <content-loader v-if="!isLoaded" :height="250"></content-loader>
        <template>
            <v-container row grid-list-xl v-if="isLoaded">
                <v-layout wrap align-center>
                    <v-flex md4 d-flex>
                        <v-select 
                            :items="filter.list_semester"
                            v-model="filter.semester"
                            label="Semester"
                            item-text="tahun"
                            item-value="semester"
                            @change="selectMatakuliah()"
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
                    <v-flex md4 d-flex>
                        <v-select 
                            :items="filter.list_program"
                            v-model="filter.program"
                            label="Program"
                            item-text="program"
                            item-value="nomor"
                            solo
                            @change="selectMatakuliah()"
                        >
                        </v-select>
                    </v-flex>
                    <v-flex md4 d-flex>
                        <v-select 
                            :items="filter.list_jurusan"
                            v-model="filter.jurusan"
                            label="Jurusan"
                            item-text="jurusan"
                            item-value="nomor"
                            solo
                            @change="selectMatakuliah()"
                        >
                        </v-select>
                    </v-flex>
                    <v-flex md4 d-flex>
                        <v-select 
                            :items="filter.list_semester_tempuh"
                            v-model="filter.semester_tempuh"
                            label="Semester Tempuh"
                            solo
                            @change="selectMatakuliah()"
                        >
                        </v-select>
                    </v-flex>
                    <v-flex md4 d-flex>
                        <v-select 
                            :items="filter.list_pararel"
                            v-model="filter.pararel"
                            label="Pararel"
                            solo
                            @change="selectMatakuliah()"
                        >
                        </v-select>
                    </v-flex>
                    <v-flex md4 d-flex>
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
        
        <template v-if="loadDetail">
            <v-progress-linear :indeterminate="true" style="margin-bottom:0px"></v-progress-linear>
        </template>
        <v-flex sm12 v-if="isLoaded">
            <v-data-table
                :headers="headerTable"
                :items="bodyTable"
                hide-actions
                class="elevation-1"
            >
                <template slot="items" slot-scope="props">
                    <tr :id="'tr-'+props.item.id">
                        <td>{{ props.item.nilai_master_modul.modul }}</td>
                        <td class="text-xs-left" :id="'matakuliah-'+props.item.id">{{ props.item.to_matakuliah.matakuliah }}</td>
                        <td class="text-xs-left" :id="'kelas-'+props.item.id">{{ props.item.to_kuliah.tahun }} / {{ props.item.to_kuliah.semester }} - {{ props.item.to_program.program }} {{ props.item.to_jurusan.jurusan }} ({{props.item.to_kelas.kelas}} {{props.item.to_kelas.pararel}})</td>
                        <td class="text-xs-left" :id="'judul-'+props.item.id">{{ props.item.judul }} </td>
                        <td class="text-xs-center" :id="'keterangan-'+props.item.id">{{ props.item.keterangan }}</td>
                        <td class="text-xs-center" :id="'due-date-'+props.item.id">{{ dateView(props.item.due_date) }}</td>
                        <td class="text-xs-center"><template v-if="props.item.file_url"><a slot="activator" v-bind:href="props.item.file_url"> Download File </a></template></td>
                        <td class="text-xs-center">
                            <v-layout justify-space-around>
                                <v-btn flat icon color="info" slot="activator"  @click="detail(props.item.id)">
                                    <v-icon dark>list_alt</v-icon>
                                </v-btn>
                                <router-link :to="'/e-tugas/edit/'+props.item.id">
                                    <v-btn flat icon color="green">
                                        <v-icon dark>create</v-icon>
                                    </v-btn>
                                </router-link>
                                <v-btn flat icon color="pink" @click="remove(props.item.id)">
                                    <v-icon dark>delete</v-icon>
                                </v-btn>
                            </v-layout>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-flex>

        <!-- floating button -->
        <v-layout column class="fab-container">
            <router-link to="e-tugas/add">
                <v-btn fab dark color="pink" >
                    <v-icon>add</v-icon>
                </v-btn>
            </router-link>
        </v-layout>

        <!-- modal -->
        <template>
            <v-layout row justify-center>
                <v-dialog v-model="dialog" persistent max-width="400">
                <v-card>
                    <v-card-title class="headline">{{title_confirm}}</v-card-title>
                    <v-card-text>{{desc_confirm}}</v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary darken-1" flat @click="sureRemoveMe">Ya, Setuju hapus</v-btn>
                    <v-btn color="warning darken-1" flat @click.native="dialog = false">Batalkan</v-btn>
                    </v-card-actions>
                </v-card>
                </v-dialog>
            </v-layout>
        </template>

        <!-- detail etugas -->
        <e-tugas-detail></e-tugas-detail>
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
                { text: 'Judul Tugas', value: 'judul' },
                { text: 'Keterangan', value: 'keterangan' },
                { text: 'Due Date', value: 'due_date' },
                { text: 'File Tugas', value: 'file_url' },
                { text: 'Aksi', value: 'id' },
            ],
            bodyTable: [],
            semesters: [],
            descriptionSemester: '',
            filter: '',
            snackbarText: '',
            snackbar: false,
            isLoaded: false,
            dialog: false,
            loadDetail: false,
            title_confirm: '',
            desc_confirm: '',
            remove_id: '',
            filter: {
                list_semester: [],
                list_program: [],
                list_jurusan: [],
                list_semester_tempuh: [1,2,3,4,5,6,7,8],
                list_pararel: ['A', 'B'],

                list_kelas: [],
                list_matakuliah: [],
                semester: '',
                kelas: '',
                matakuliah: '',
                program: '',
                jurusan: '',
                semester_tempuh: '',
                pararel: '',
            }
        }
    },
    components: {
        ContentLoader
    },
    mounted() {
        this.initData()
    },
    methods: {
        initData() {
            var app = this
            axios.get('lecturer/e-tugas').then(function (resp) {
                app.isLoaded = true
                app.bodyTable = resp.data.list_tugas
                app.filter.list_semester = resp.data.list_semester
                app.filter.list_jurusan = resp.data.list_jurusan
                app.filter.list_program = resp.data.list_program
                console.log(resp)
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!")
            })
        },
        detail(id) {
            var app = this
            app.loadDetail = true
            axios.get('lecturer/e-tugas/detail/'+id).then(function (resp) {
                app.loadDetail = false
                app.$store.state.obj_etugas = resp.data
                app.$store.state.form_dialog_detail_etugas = true
                app.$store.state.obj_list_etugas = resp.data.etugas_kelas_mahasiswa
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
        // selectKelas() {
        //     if (!this.filter.semester) return false
        //     var app = this
        //     axios.get('filter/lecturer/get-kelas/'+app.filter.semester).then(function (resp) {
        //         app.filter.list_kelas = []
        //         app.filter.list_kelas = resp.data
        //     })
        //     .catch(function (resp) {
        //         app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
        //     })
        // },
        selectMatakuliah() {
            if (!this.filter.semester) return false
            if (!this.filter.program) return false
            if (!this.filter.jurusan) return false
            if (!this.filter.semester_tempuh) return false
            if (!this.filter.pararel) return false
            this.filter.matakuliah = ""
            var app = this
            axios.post('filter/lecturer/get-matakuliah', app.filter).then(function (resp) {
                console.log(resp)
                app.filter.list_matakuliah = []
                app.filter.list_matakuliah = resp.data.list_matakuliah
                app.filter.kelas = resp.data.kelas
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        selectData() {
            if (!this.filter.matakuliah) return false
            var app = this
            app.loadDetail = true
            axios.post('lecturer/e-tugas/filter', app.filter).then(function (resp) {
                app.loadDetail = false
                app.bodyTable = []
                app.bodyTable = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        remove(id) {
            this.dialog = true

            let matakuliah = $('#matakuliah-'+id).html()
            let kelas = $('#kelas-'+id).html()
            let judul = $('#judul-'+id).html()
            let keterangan = $('#keterangan-'+id).html()
            let app = this
            app.title_confirm = 'Yakin ingin menghapus tugas ?'
            app.desc_confirm = 'Tugas dengan judul "'+judul+' kelas ' +kelas+ '" yang dihapus tidak bisa dikembalikan.'
            app.remove_id = id
        },
        sureRemoveMe() {
            let app = this
            axios.get('lecturer/e-tugas/remove/'+app.remove_id).then(function (resp) {
                app.dialog = false
                app.showSnackbar("Berhasil menghapus data")
                $('#tr-'+app.remove_id).fadeOut()
            })
            .catch(function (resp) {
                app.dialog = false
                app.showSnackbar("oops, something went wrong. Please try again!")
            })
        },
        dateView(date) {
            if (date != '0000-00-00 00:00:00') {
                return moment(date).format("dddd, MMMM Do YYYY, h:mm:ss a")
            }

            return '-'
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
