<template>
    <v-flex sm12>
        
        <h1 class="font-weight-light">Nilai Permodul</h1>
        <div class="subheading">Rincian tugas dikelompokkan permodul</div>
        
        <content-loader v-if="!isLoaded" :height="250"></content-loader>
        <v-flex md5 mt-5 v-if="isLoaded">
            <v-select 
                :items="semesters"
                v-model="filter"
                label="Pilih kelas"
                item-text="tahun"
                item-value="kuliah"
                @change="selectSemester()"
                solo
            >
                <template slot="selection" slot-scope="data">
                    {{ data.item.tahun }} / {{ data.item.semester }} - {{ data.item.matakuliah }} - {{ data.item.jurusan }} ({{data.item.kelas}} {{data.item.pararel}})
                </template>
                <template slot="item" slot-scope="data">
                    {{ data.item.tahun }} / {{ data.item.semester }} - {{ data.item.matakuliah }} - {{ data.item.jurusan }} ({{data.item.kelas}} {{data.item.pararel}})
                </template>
            </v-select>
        </v-flex>
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
                console.log(app.$store.state.obj_etugas)
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
                app.semesters = resp.data.data_semester
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
        selectSemester() {
            if (!this.filter) return false
            var app = this
            axios.get('lecturer/report/nilai-permodul/kuliah/'+app.filter).then(function (resp) {
                app.bodyTable = resp.data.data
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!")
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
  position: fixed
  bottom: 20px
  right: 0
}
</style>
