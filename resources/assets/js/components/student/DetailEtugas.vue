<template>
    <v-layout row justify-center>
        <v-dialog v-model="$store.state.form_dialog_detail_etugas" fullscreen hide-overlay transition="dialog-bottom-transition">
            <v-card>
                <v-toolbar dark color="primary">
                <v-btn icon dark @click="closeFormDialog">
                    <v-icon>close</v-icon>
                </v-btn>
                <v-toolbar-title>{{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas.judul : ''}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn dark flat @click="submit">Save</v-btn>
                </v-toolbar-items>
                </v-toolbar>
                <v-list three-line subheader>
                <v-subheader>Detail Etugas</v-subheader>
                <v-list-tile avatar>
                    <v-list-tile-content>
                    <v-list-tile-title>Dosen</v-list-tile-title>
                    <v-list-tile-sub-title>{{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas_pegawai.nama : ''}}</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile avatar>
                    <v-list-tile-content>
                    <v-list-tile-title>Matakuliah</v-list-tile-title>
                    <v-list-tile-sub-title>{{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas_matakuliah.matakuliah : ''}} <br> {{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas_modul.modul : ''}}</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile avatar>
                    <v-list-tile-content>
                    <v-list-tile-title>Deskripsi Tugas</v-list-tile-title>
                    <v-list-tile-sub-title>{{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas.keterangan : ''}}</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile avatar>
                    <v-list-tile-content>
                    <v-list-tile-title>Batas Pengumpulan</v-list-tile-title>
                    <v-list-tile-sub-title>{{dateView($store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas.due_date : '')}}</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
                </v-list>
                <v-divider></v-divider>
                <v-list three-line subheader>
                    <v-subheader>Upload Tugas</v-subheader>
                    <v-list-tile avatar>
                        <v-list-tile-content>
                            <v-list-tile-sub-title>
                                <v-textarea
                                    box
                                    name="input-7-4"
                                    id="keterangan"
                                    placeholder="Tambah keterangan"
                                    :value="setKeterangan"
                                    >
                                    
                                    </v-textarea>
                            </v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <br>
                    <v-flex xs12 style="padding:15px">
                        <p>Tambahkan File (Optional)</p>
                        <file-pond
                            name="file"
                            ref="pond"
                            label-idle="Drop files here..."
                            allow-multiple="false"
                            v-bind:files="myFiles"/>
                    </v-flex>
                    <v-list-tile avatar v-if="etugas_nilai_mahasiswa">
                        <v-list-tile-content>
                        <v-list-tile-title>File yang sudah diupload</v-list-tile-title>
                        <v-list-tile-sub-title>
                            <template v-if="etugas_nilai_mahasiswa.file_url">
                                <a v-bind:href="etugas_nilai_mahasiswa.file_url"> 
                                    Download file tugas
                                </a>
                            </template>
                        </v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-card>
        </v-dialog>
        <v-snackbar
            v-model="snackbar" right bottom  >
                {{snackbarText}}
                <v-btn dark flat @click="snackbar = false" >
                    Close
                </v-btn>
        </v-snackbar>
    </v-layout>
</template>

<script>
import * as moment from 'moment';
moment.locale('id');

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
            snackbarText: '',
            snackbar: false,
            tugas_id: '',
            myFiles: '',
        }
    },
    components: {
        FilePond
    },
    computed: {
        setKeterangan() {
            return this.$store.state.obj_etugas.etugas_nilai_mahasiswa ? this.$store.state.obj_etugas.etugas_nilai_mahasiswa.keterangan: ''
        },
        etugas_nilai_mahasiswa() {
            return this.$store.state.obj_etugas.etugas_nilai_mahasiswa ? this.$store.state.obj_etugas.etugas_nilai_mahasiswa: ''
        },
        formDialogDetail() {
            return this.$store.state.form_dialog_detail_etugas
        }
    },
    mounted() {
    },
    methods: {
        initData() {
            let app = this
            // axios.get('student/e-tugas/detail').then(function (resp) {
            //     app.isLoaded = true;
            //     app.bodyTable = resp.data.data;
            //     app.semesters = resp.data.data_semester;
            // })
            // .catch(function (resp) {
            //     app.showSnackbar("oops, something went wrong. Please try again!");
            // });
        },
        saveFormDialog() {
            this.$store.state.form_dialog_detail_etugas = false
        },
        closeFormDialog() {
            this.$store.state.form_dialog_detail_etugas = false
        },
        dateView(date) {
            if (date != '0000-00-00 00:00:00') {
                return moment(date).format("dddd, Do MMMM YYYY, h:mm:ss a");
            }
            return '-'
        },
        showSnackbar(text) {
            var app = this;
            app.snackbarText = text;
            app.snackbar = true;
        },
        submit() {
            var app = this;
            if ($('#keterangan').val() == '') {
                app.showSnackbar('keterangan harus diisi');
                return false;
            }
            
            var file = app.$refs.pond.getFiles();
            let form = new FormData();
            
            form.append('file', '');
            if (file.length) {
                form.append('file', file[0].file);
            }
            form.append('keterangan', $('#keterangan').val())
            form.append('tugas_id', app.$store.state.obj_etugas.etugas.id)
            form.append('kelas_id', app.$store.state.obj_etugas.etugas.kelas)
            axios.post( 'student/e-tugas/store', form, { headers: {'Content-Type': 'multipart/form-data'}}).then(function (resp) {
                if (resp.data.code == 200) {
                    app.keterangan = '';
                    app.myFiles = [];
                    app.showSnackbar('Tugas berhasil diunggah');
                    app.$store.state.form_dialog_detail_etugas = false;
                    app.$store.state.obj_list_etugas =  resp.data.data_tugas;
                }
            })
            .catch(function(e) {
                app.showSnackbar('Tugas gagal diunggah');
            });
        }
    }
}
</script>
