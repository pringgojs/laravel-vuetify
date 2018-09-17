<template>
    <v-flex sm12>
        <h1>Materi Baru</h1>
        <div class="subheading">Tambahkan materi sebagai penunjang belajar mahasiswa</div>
        <content-loader v-if="!isLoaded" height="250"></content-loader>

        <v-flex xs3 offset-xs9 align-end v-if="isLoaded">
            <router-link to="/materi"><v-btn color="success">Kembali</v-btn></router-link>
        </v-flex>
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
            <v-flex md12 mt-5>
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
                    label="Judul Materi"
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
            <v-flex xs12>
                <file-pond
                    name="file"
                    ref="pond"
                    label-idle="Drop files here..."
                    allow-multiple="false"
                    v-bind:files="myFiles"/>
            </v-flex>
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
            keterangan: ''
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
                showSnackbar("oops, something went wrong. Please try again!");
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
                app.showSnackbar('Judul harus diisi');
                return false;
            }

            if (app.nilai_master_modul == '') {
                app.showSnackbar('Modul harus diisi');
                return false;
            }
            
            var file = app.$refs.pond.getFiles();
            let form = new FormData();
            if (file.length) {
                form.append('file', file[0].file);
            } else {
                form.append('file', '');
            }
            form.append('judul', app.judul)
            form.append('keterangan', app.keterangan)
            form.append('nilai_master_modul', app.nilai_master_modul)
            axios.post( 'lecturer/materi/store', form, { headers: {'Content-Type': 'multipart/form-data'}}).then(function (resp) {
                if (resp.data.code == 200) {
                    app.judul = '';
                    app.keterangan = '';
                    app.myFiles = [];
                    app.showSnackbar('Materi berhasil ditambahkan');
                }
            })
            .catch(function(e) {
                console.log(e);
                app.showSnackbar('Materi gagal ditambahkan');
            });
        }
    },
    components: {
        ContentLoader,
        FilePond
    },
}
</script>
