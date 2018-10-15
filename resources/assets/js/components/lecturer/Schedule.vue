<template>
    <v-flex sm12>
        <h1 class="font-weight-light">Daftar Modul</h1>
        <div class="subheading">Modul untuk perkuliahan</div>
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

        <v-flex sm12 v-if="isLoaded">
            <v-data-table
                :headers="headerTable"
                :items="bodyTable"
                hide-actions
                class="elevation-1"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.modul }}</td>
                    <td class="text-xs-left">{{ props.item.matakuliah }}</td>
                    <td class="text-xs-center">{{ props.item.program }}</td>
                    <td class="text-xs-left">{{ props.item.jurusan }}</td>
                    <td class="text-xs-left">{{ props.item.tahun }}</td>
                    <td class="text-xs-center">{{ props.item.semester }}</td>
                    <td class="text-xs-center">{{ props.item.pararel }}</td>
                </template>
            </v-data-table>
        </v-flex>
        
        <v-snackbar
            v-model="snackbar"
                right
                bottom
                >
                {{snackbarText}}
                <v-btn
                    dark
                    flat
                    @click="snackbar = false"
                >
                    Close
                </v-btn>
        </v-snackbar>
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
                { text: 'Program', value: 'program' },
                { text: 'Jurusan', value: 'jurusan' },
                { text: 'Tahun', value: 'tahun' },
                { text: 'Semester', value: 'semester' },
                { text: 'Paralel', value: 'paralel' },
            ],
            bodyTable: [],
            semesters: [],
            snackbarText: '',
            snackbar: false,
            isLoaded: false,
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
        initData() {
            var app = this
            axios.get('lecturer/schedule').then(function (resp) {
                app.isLoaded = true
                app.bodyTable = resp.data.list_schedule
                app.filter.list_semester = resp.data.list_semester
            })
            .catch(function (resp) {
                showSnackbar("oops, something went wrong. Please try again!")
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
            axios.post('lecturer/schedule/filter', app.filter).then(function (resp) {
                app.loadDetail = false
                app.bodyTable = ''
                app.bodyTable = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
    }
}
</script>
