<template>
    <v-flex sm12>
        
        <h1 class="font-weight-light">Nilai Permodul</h1>
        <div class="subheading">Rincian tugas dikelompokkan permodul</div>
        
        <content-loader v-if="!isLoaded" :height="250"></content-loader>
        <template>
            <v-container fluid grid-list-xl v-if="isLoaded">
                <v-layout wrap align-center>
                    <v-flex md4 d-flex>
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
                    <v-flex md4 d-flex>
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

        <v-flex sm12 v-if="filter && isLoaded">
            <v-data-table
                :headers="headerTable"
                :items="bodyTable"
                hide-actions
                class="elevation-1"
            >
                <template slot="items" slot-scope="props">
                    <tr :id="'tr-'+props.item.id">
                        <td>{{ props.item.modul }}</td>
                        <td class="text-xs-left" :id="'matakuliah-'+props.item.id">{{ props.item.matakuliah }}</td>
                        <td class="text-xs-left" :id="'kelas-'+props.item.id">{{ props.item.tahun }} / {{ props.item.semester }} - {{ props.item.program }} {{ props.item.jurusan }} ({{props.item.kelas}} {{props.item.pararel}})</td>
                        <td class="text-xs-left" :id="'judul-'+props.item.id">{{ props.item.total_tugas }} </td>
                        <td class="text-xs-center">
                            <v-layout justify-space-around>
                                <v-btn flat icon color="info" slot="activator"  @click="detail(props.item.nomor_nilai_master_modul)">
                                    <v-icon dark>list_alt</v-icon>
                                </v-btn>
                            </v-layout>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-flex>

        <!-- detail -->
        <nilai-permodul-detail></nilai-permodul-detail>
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
                { text: 'Total Tugas', value: 'total_tugas' },
                { text: 'Aksi', value: 'id' },
            ],
            bodyTable: [],
            descriptionSemester: '',
            snackbarText: '',
            snackbar: false,
            isLoaded: false,
            dialog: false,
            loadDetail: false,
            filter: {
                list_semester: [],
                list_kelas: [],
                list_matakuliah: [],
                semester: '',
                kelas: '',
                matakuliah: '',
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
        detail(nomor_nilai_master_modul) {
            var app = this
            app.loadDetail = true
            axios.get('lecturer/report/nilai-permodul/detail/'+nomor_nilai_master_modul).then(function (resp) {
                app.loadDetail = false
                app.$store.state.obj_etugas = resp.data
                app.$store.state.form_dialog_detail_etugas = true
                app.$store.state.obj_list_etugas = resp.data.kelas_mahasiswa
                // initialize table header data
                app.$store.state.table_headers = []
                resp.data.table_headers.forEach(item => {
                   app.$store.state.table_headers.push({ text: item, value: item.toLowerCase() })
                })
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!")
            })
        },
        initData() {
            var app = this
            axios.get('lecturer/report/nilai-permodul').then(function (resp) {
                app.isLoaded = true
                app.filter.list_semester = resp.data.list_semester
                app.bodyTable = resp.data.list_tugas
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
            axios.post('lecturer/report/nilai-permodul/filter', app.filter).then(function (resp) {
                app.loadDetail = false
                app.bodyTable = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
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
