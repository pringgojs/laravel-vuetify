<template>
    <v-flex sm12>
        <h1 class="font-weight-light">Tugas Baru</h1>
        <div class="subheading">Tambahkan tugas sebagai bahan evaluasi belajar mahasiswa</div>
        <content-loader v-if="!isLoaded" :height="250"></content-loader>

        <v-container fluid grid-list-xl v-if="isLoaded">
            <v-layout wrap align-center>
                <template>
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
                            @change="selectModul()"
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
                </template>
                <v-flex md12>
                    <v-select 
                        :items="list_modul"
                        v-model="nilai_master_modul"
                        label="Pilih Modul"
                        item-text="modul"
                        item-value="nomor"
                        solo
                    >
                        <template slot="selection" slot-scope="data">
                            {{ data.item.modul }}
                        </template>
                        <template slot="item" slot-scope="data">
                            {{ data.item.modul }}
                        </template>
                    </v-select>
                </v-flex>
                <v-flex xs12 sm12 md12>
                    <v-text-field
                        label="Judul Tugas"
                        v-model="judul"
                        solo
                    ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-textarea
                    solo
                    name="input-7-4"
                    label="Keterangan"
                    v-model="keterangan"
                    ></v-textarea>
                </v-flex>
                <!-- time picker -->
                <v-layout row wrap pa-2>
                    <v-flex xs12>
                    <p>Tetapkan batas waktu pengumpulan</p>
                    </v-flex>
                    <!-- date -->
                    <v-flex xs12 sm6 md6>
                        <v-menu
                            ref="menu_date"
                            :close-on-content-click="false"
                            v-model="menu"
                            :nudge-right="40"
                            :return-value.sync="date"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="date"
                            placeholder="Tanggal"
                            readonly
                            solo
                            append-icon="event"
                            ></v-text-field>
                            <v-date-picker v-model="date" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                                <v-btn flat color="primary" @click="$refs.menu_date.save(date)">OK</v-btn>
                            </v-date-picker>
                        </v-menu>
                    </v-flex>
                    <!-- time -->
                    <v-flex xs12 sm6 md6>
                        <v-menu
                            ref="menu_time"
                            :close-on-content-click="false"
                            v-model="menu2"
                            :nudge-right="40"
                            :return-value.sync="time"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="time"
                            placeholder="Jam"
                            readonly
                            solo
                            append-icon="schedule"
                            ></v-text-field>
                            <v-time-picker
                            v-if="menu2"
                            v-model="time"
                            @change="$refs.menu_time.save(time)"
                            ></v-time-picker>
                        </v-menu>
                    </v-flex>
                </v-layout>
                
                <v-flex xs12>
                    <p>Tambahkan File (Optional)</p>
                    <file-pond
                        name="file"
                        ref="pond"
                        label-idle="Drop files here..."
                        allow-multiple="false"
                        v-bind:files="myFiles"/>
                </v-flex>
                <router-link to="/e-tugas"><v-btn flat >Kembali</v-btn></router-link>
                <v-btn color="info" @click="submit">Simpan</v-btn>
            </v-layout>
        </v-container>

        <v-snackbar v-model="snackbar" right bottom >
            {{snackbarText}}
            <v-btn dark flat @click="snackbar = false" >
                Close
            </v-btn>
        </v-snackbar>
    </v-flex>
</template>

<script>
import { ContentLoader } from 'vue-content-loader'

// Import Vue FilePond
import vueFilePond from 'vue-filepond'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginFileEncode from 'filepond-plugin-file-encode'
// Import FilePond styles
import 'filepond/dist/filepond.min.css'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css'
const FilePond = vueFilePond( 
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType,
    FilePondPluginFileEncode
)

export default {
    data () {
        return {
            isLoaded: false,
            snackbarText: '',
            snackbar: false,
            list_modul: [],
            myFiles: '',
            judul: '',
            keterangan: '',
            date: null, 
            menu: false,
            time: null,
            menu2: false,
            nilai_master_modul: '',
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
    mounted() {
        this.initData()
    },
    methods: {
        initData() {
            var app = this
            app.isLoaded = true
            axios.get('filter/get-semester').then(function (resp) {
                app.isLoaded = true
                app.filter.list_semester = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
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
            axios.get('filter/lecturer/get-kelas/'+app.filter.semester).then(function (resp) {
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
            axios.post('filter/lecturer/get-matakuliah', app.filter).then(function (resp) {
                app.filter.list_matakuliah = ''
                app.filter.list_matakuliah = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        selectModul() {
            if (!this.filter.matakuliah) return false
            var app = this
            axios.post('filter/lecturer/get-modul', app.filter).then(function (resp) {
                app.list_modul = ''
                app.list_modul = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        submit() {
            var app = this
            if (!app.filter.matakuliah) {
                app.showSnackbar('Silahkan memilih kelas terlebih dahulu.')
                return false
            }

            if (!app.nilai_master_modul) {
                app.showSnackbar('Anda belum memilih modul.')
                return false
            }

            if (!app.judul) {
                app.showSnackbar('Judul tugas harus diisi')
                return false
            }

            if (!app.keterangan) {
                app.showSnackbar('Keterangan tugas harus diisi')
                return false
            }

            if (!app.date) {
                app.showSnackbar('Tanggal harus diisi')
                return false
            }

            if (!app.time) {
                app.showSnackbar('Batas waktu harus diisi')
                return false
            }
            
            var file = app.$refs.pond.getFiles()
            let form = new FormData()
            form.append('file', '')
            if (file.length) {
                form.append('file', file[0].file)
            }
            
            form.append('judul', app.judul)
            form.append('tanggal', app.date)
            form.append('waktu', app.time)
            form.append('keterangan', app.keterangan)
            form.append('nilai_master_modul', app.nilai_master_modul)
            axios.post( 'lecturer/e-tugas/store', form, { headers: {'Content-Type': 'multipart/form-data'}}).then(function (resp) {
                if (resp.data.code == 200) {
                    app.judul = ''
                    app.keterangan = ''
                    app.myFiles = []
                    app.showSnackbar('E-Tugas berhasil ditambahkan')
                }
            })
            .catch(function(e) {
                app.showSnackbar('E-Tugas gagal ditambahkan')
            })
        }
    },
    components: {
        ContentLoader,
        FilePond
    },
}
</script>
