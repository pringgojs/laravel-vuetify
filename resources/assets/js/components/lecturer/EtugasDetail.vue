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
                    <template>
                        <div class="text-xs-center" v-if="is_download">
                            <v-progress-circular
                            indeterminate
                            color="white"
                            ></v-progress-circular>
                        </div>
                    </template>
                    <v-toolbar-items>
                        <v-icon @click="downloadFile" v-if="file_is_ready" large color="white darken-2">get_app</v-icon>

                        <v-btn dark flat @click="download">Download Excel</v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <v-list three-line subheader>
                    <v-subheader>Detail Etugas</v-subheader>
                    
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
                    <v-list-tile avatar>
                        <v-list-tile-content>
                            <v-list-tile-title>Rekapitulasi</v-list-tile-title>
                            <v-list-tile-sub-title>
                                {{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas_kelas_mahasiswa.length  : 0}} Total mahasiswa <br>
                                {{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas_nilai_mahasiswa.length  : 0}} Orang sudah upload <br>
                                {{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas_kelas_mahasiswa.length - $store.state.obj_etugas.etugas_nilai_mahasiswa.length  : 0}} Orang belum upload <br>
                                
                            </v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
                <v-divider></v-divider>
                <v-list three-line subheader>
                    <v-subheader>Upload Tugas</v-subheader>
                    <v-flex sm12>
                        <v-data-table
                            :headers="headerTable"
                            :items="$store.state.obj_list_etugas"
                            hide-actions
                            class="elevation-1"
                        >
                            <template slot="items" slot-scope="props">
                                <tr :id="'tr-'+props.item.id">
                                    <td>{{ props.item.nrp }}</td>
                                    <td class="text-xs-left" :id="'nama-'+props.item.nomor">{{ props.item.nama }}</td>
                                    <td class="text-xs-left" :id="'keterangan-'+props.item.nomor">{{ props.item.nilai ? props.item.nilai.keterangan : ''}}</td>
                                    <td class="text-xs-center" :style="statusLate($store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.etugas.due_date : '', props.item.nilai)" :id="'due-date-'+props.item.nomor">{{ props.item.nilai ? dateView(props.item.nilai.updated_at) : '' }}</td>
                                    <td class="text-xs-center">
                                        <template v-if="props.item.nilai">
                                            <a slot="activator" v-if="props.item.nilai.file_url" v-bind:href="props.item.nilai.file_url"> Download File </a>
                                        </template>
                                    </td>
                                    <td class="text-xs-center">{{ props.item.nilai ? props.item.nilai.nilai : ''}}</td>
                                    <td class="text-xs-center">
                                        <v-layout justify-space-around v-if="props.item.nilai">
                                            <v-btn flat icon color="info" slot="activator"  @click="setNilai(props.item.nilai.id, props.item.nomor)">
                                                <v-icon dark>edit</v-icon>
                                            </v-btn>
                                        </v-layout>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-flex>
                </v-list>
            </v-card>
        </v-dialog>

        <!-- input nilai -->
        <template>
        <v-layout row justify-center>
            <v-dialog v-model="dialog" persistent max-width="390">
            <v-card>
                <v-card-title class="headline">{{nama_mahasiswa}}</v-card-title>
                <v-text-field
                    label="Masukkan nilai tugas"
                    style="margin:10px"
                    v-model="data.nilai"
                ></v-text-field>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn flat @click.native="dialog = false">Batalkan</v-btn>
                <v-btn color="info" @click="storeNilai" v-if="!is_save">
                    Simpan
                </v-btn>
                <v-btn flat v-if="is_save">
                    <v-progress-circular
                        indeterminate
                        color="primary"
                    ></v-progress-circular>
                </v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
        </v-layout>
        </template>

        <!-- snackbar -->
        <v-snackbar v-model="snackbar" right bottom >
            {{snackbarText}}
            <v-btn dark flat @click="snackbar = false" >
                Close
            </v-btn>
        </v-snackbar>
    </v-layout>
</template>

<script>
import * as moment from 'moment'
moment.locale('id')

export default {
    data () {
        return {
            nama_mahasiswa: '',
            dialog: false,
            is_save: false,
            is_download: false,
            snackbarText: '',
            snackbar: false,
            file_is_ready: false,
            link_file_download: '',
            headerTable: [
                { text: 'NIM', value: 'nrp' },
                { text: 'Nama', value: 'nama' },
                { text: 'Keterangan Tugas', value: 'nilai.keterangan' },
                { text: 'Tanggal Unggah', value: 'nilai.updated_at' },
                { text: 'File Tugas', value: 'nilai.file_url' },
                { text: 'Nilai', value: 'nilai.nilai' },
                { text: 'Aksi', value: 'nilai.id' },
            ],
            data: {
                nilai: '',
                tugas_id: '',
            },
        }
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
        setNilai(tugas_id, mahasiswa_id) {
            this.dialog = true
            this.data.tugas_id = tugas_id
            this.nama_mahasiswa = $('#nama-'+mahasiswa_id).html()
        },
        saveFormDialog() {
            this.$store.state.form_dialog_detail_etugas = false
        },
        closeFormDialog() {
            this.$store.state.form_dialog_detail_etugas = false
        },
        dateView(date) {
            if (date != '0000-00-00 00:00:00') {
                return moment(date).format("dddd, Do MMMM YYYY, h:mm:ss a")
            }
            return '-'
        },
        download() {
            var app = this
            var id = this.$store.state.obj_etugas.etugas.id
            app.is_download = true
            app.file_is_ready = false
            axios.get('lecturer/e-tugas/download/'+ id)
                .then(function (resp) {
                    app.link_file_download = resp.data.link
                    app.file_is_ready = true
                    app.is_download = false
                    app.showSnackbar("berhasil mengunduh data!")
                    return true
                })
                .catch(function (resp) {
                    app.is_download = false
                    app.showSnackbar("oops, something went wrong. Please try again!")
                })
        },
        downloadFile() {
            location.href = this.link_file_download
        },
        showSnackbar(text) {
            var app = this
            app.snackbarText = text
            app.snackbar = true
        },
        storeNilai() {
            var app = this
            if (app.data.nilai == '') {
                app.showSnackbar("Nilai harus diisi")
                return false
            }
            app.is_save = true
            axios.post('lecturer/e-tugas/set-nilai', app.data)
                .then(function (resp) {
                    app.is_save = false
                    app.dialog = false
                    app.data.nilai = 0
                    app.data.tugas_id = ''
                    app.$store.state.obj_list_etugas = resp.data.etugas_kelas_mahasiswa
                    app.showSnackbar("Data berhasil disimpan!")
                    return true
                })
                .catch(function (resp) {
                    app.is_save = false
                    app.dialog = false
                    app.data.nilai = 0
                    app.data.tugas_id = ''
                    app.showSnackbar("oops, something went wrong. Please try again!")
                })
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
