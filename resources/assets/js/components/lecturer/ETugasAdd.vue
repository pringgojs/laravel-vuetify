<template>
    <v-flex sm12>
        <h1 class="font-weight-light">Tugas Baru</h1>
        <div class="subheading">Tambahkan tugas sebagai bahan evaluasi belajar mahasiswa</div>
        <content-loader v-if="!isLoaded" height="250"></content-loader>

        <v-flex sm12 md6  v-if="isLoaded">
            <v-flex md12 mt-5>
                <v-select 
                    :items="semesters"
                    v-model="filter"
                    label="Pilih Kelas"
                    item-text="tahun"
                    item-value="kuliah"
                    @change="selectSemester()"
                    solo
                >
                    <template slot="selection" slot-scope="data">
                        {{ data.item.tahun }} / {{ data.item.semester }} - {{ data.item.jurusan }} ({{data.item.kelas}} {{data.item.pararel}})
                    </template>
                    <template slot="item" slot-scope="data">
                        {{ data.item.tahun }} / {{ data.item.semester }} - {{ data.item.jurusan }} ({{data.item.kelas}} {{data.item.pararel}})
                    </template>
                </v-select>
            </v-flex>
            <v-flex md12>
                <v-select 
                    :items="moduls"
                    v-model="nilai_master_modul"
                    label="Modul"
                    item-text="modul"
                    item-value="nomor_nilai_master_modul"
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

// Import Vue FilePond
import vueFilePond from 'vue-filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileEncode from 'filepond-plugin-file-encode';
// Import FilePond styles
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
const FilePond = vueFilePond( 
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType,
    FilePondPluginFileEncode
);

export default {
    data () {
        return {
            isLoaded: false,
            snackbarText: '',
            snackbar: false,
            nilai_master_modul: '',
            semesters: [],
            moduls: [],
            filter: '',
            myFiles: '',
            judul: '',
            keterangan: '',
            date: null, 
            menu: false,
            time: null,
            menu2: false,
        }
    },
    mounted() {
        this.initData();
    },
    methods: {
        initData() {
            var app = this;
            axios.get('lecturer/schedule').then(function (resp) {
                app.isLoaded = true;
                app.descriptionSemester = resp.data.keterangan;
                app.bodyTable = resp.data.data;
                app.semesters = resp.data.data_semester;
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!");
            });
        },
        showSnackbar(text) {
            var app = this;
            app.snackbarText = text;
            app.snackbar = true;
        },
        selectSemester() {
            if (!this.filter) return false;
            var app = this;
            axios.get('lecturer/schedule/get-by-semester/'+app.filter).then(function (resp) {
                app.descriptionSemester = resp.data.keterangan;
                app.moduls = resp.data.data;
            })
            .catch(function (resp) {
                showSnackbar("oops, something went wrong. Please try again!");
            });
        },
        submit() {
            var app = this;
            if (app.judul == '') {
                app.showSnackbar('Judul tugas harus diisi');
                return false;
            }

            if (app.nilai_master_modul == '') {
                app.showSnackbar('Modul harus diisi');
                return false;
            }

            if (app.date == '') {
                app.showSnackbar('Tanggal harus diisi');
                return false;
            }

            if (app.time == '') {
                app.showSnackbar('Waktu harus diisi');
                return false;
            }
            
            var file = app.$refs.pond.getFiles();
            let form = new FormData();
            form.append('file', '');
            if (file.length) {
                form.append('file', file[0].file);
            }
            
            form.append('judul', app.judul)
            form.append('tanggal', app.date)
            form.append('waktu', app.time)
            form.append('keterangan', app.keterangan)
            form.append('nilai_master_modul', app.nilai_master_modul)
            axios.post( 'lecturer/e-tugas/store', form, { headers: {'Content-Type': 'multipart/form-data'}}).then(function (resp) {
                if (resp.data.code == 200) {
                    app.judul = '';
                    app.keterangan = '';
                    app.myFiles = [];
                    app.showSnackbar('E-Tugas berhasil ditambahkan');
                }
            })
            .catch(function(e) {
                console.log(e);
                app.showSnackbar('E-Tugas gagal ditambahkan');
            });
        }
    },
    components: {
        ContentLoader,
        FilePond
    },
}
</script>
