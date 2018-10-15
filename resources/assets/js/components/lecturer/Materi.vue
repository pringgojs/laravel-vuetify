<template>
    <v-flex sm12>
        <h1 class="font-weight-light">Materi</h1>
        <div class="subheading">Tambahkan materi sebagai penunjang belajar mahasiswa</div>
        
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
                :items="bodyTable"
                hide-actions
                light
                class="elevation-1"
            >
                <template slot="items" slot-scope="props">
                    <tr :id="'tr-'+props.item.id">
                        <td>{{ props.item.modul }}</td>
                        <td class="text-xs-left" :id="'matakuliah-'+props.item.id">{{ props.item.matakuliah }}</td>
                        <td class="text-xs-left" :id="'kelas-'+props.item.id">{{ props.item.tahun }} / {{ props.item.semester }} - {{ props.item.program }} {{ props.item.jurusan }} ({{props.item.kelas}} {{props.item.pararel}})</td>
                        <td class="text-xs-left" :id="'judul-'+props.item.id">{{ props.item.judul }}</td>
                        <td class="text-xs-center" :id="'keterangan'+props.item.id">{{ props.item.keterangan }}</td>
                        <td class="text-xs-center"><template v-if="props.item.file_url"><a slot="activator" v-bind:href="props.item.file_url"> Download File </a></template></td>
                        <td class="text-xs-center">
                            <v-layout justify-space-around>
                                <router-link :to="'/materi/edit/'+props.item.id">
                                    <v-btn flat icon color="green">
                                        <v-icon dark>create</v-icon>
                                    </v-btn>
                                </router-link>
                                <div class="text-xs-center">
                                    <v-btn flat icon color="pink" @click="remove(props.item.id)">
                                    <v-icon>delete</v-icon>
                                    </v-btn>
                                </div>
                            </v-layout>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-flex>

        <!-- floating button -->
        <v-layout column class="fab-container">
            <router-link to="materi/add">
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

        
    </v-flex>

</template>

<script>
import { ContentLoader } from 'vue-content-loader'
export default {
    data () {
        return {
            headerTable: [
                { text: 'Modul', value: 'modul' },
                { text: 'Matakuliah', value: 'matakuliah' },
                { text: 'Kelas', value: 'kelas' },
                { text: 'Judul Materi', value: 'judul' },
                { text: 'Keterangan', value: 'keterangan' },
                { text: 'File Materi', value: 'file_url' },
                { text: 'Aksi', value: 'id' },
            ],
            bodyTable: [],
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
            remove_id: ''
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
            axios.get('lecturer/materi').then(function (resp) {
                app.isLoaded = true
                app.bodyTable = resp.data.list_materi
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
            axios.post('lecturer/materi/filter', app.filter).then(function (resp) {
                app.loadDetail = false
                app.bodyTable = ''
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
            app.title_confirm = 'Yakin ingin menghapus materi ?'
            app.desc_confirm = 'Materi dengan judul "'+judul+' kelas ' +kelas+ '" yang dihapus tidak bisa dikembalikan.'
            app.remove_id = id
        },
        sureRemoveMe() {
            let app = this
            axios.get('lecturer/materi/remove/'+app.remove_id).then(function (resp) {
                app.dialog = false
                app.showSnackbar("Berhasil menghapus data")
                $('#tr-'+app.remove_id).fadeOut()
            })
            .catch(function (resp) {
                app.dialog = false
                app.showSnackbar("oops, something went wrong. Please try again!")
            })
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
