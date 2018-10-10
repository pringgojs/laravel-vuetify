<template>
    <v-layout row justify-center>
        <v-dialog v-model="$store.state.form_dialog_detail_etugas" fullscreen hide-overlay transition="dialog-bottom-transition">
            <v-card>
                <v-toolbar dark color="primary">
                    <v-btn icon dark @click="closeFormDialog">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>{{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.nilai_master_modul.modul : ''}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click="download">Download Excel</v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <v-list three-line subheader>
                    <v-subheader>Detail Etugas</v-subheader>
                    
                    <v-list-tile avatar>
                        <v-list-tile-content>
                        <v-list-tile-title>Matakuliah</v-list-tile-title>
                        <v-list-tile-sub-title>{{$store.state.form_dialog_detail_etugas ? $store.state.obj_etugas.mata_kuliah.matakuliah : ''}}</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
                <v-divider></v-divider>
                <v-list three-line subheader>
                    <v-subheader>Upload Tugas</v-subheader>
                    <v-flex sm12>
                        <v-data-table
                            :headers="$store.state.table_headers"
                            :items="$store.state.obj_list_etugas"
                            hide-actions
                            class="elevation-1"
                        >
                            <template slot="items" slot-scope="props">
                                <tr :id="'tr-'+props.item.id">
                                    <td>{{ props.item.nrp }}</td>
                                    <td class="text-xs-left" :id="'nama-'+props.item.nomor">{{ props.item.nama }}</td>
                                    <td class="text-xs-left" v-for="(item, index) in $store.state.obj_etugas.list_etugas_by_master_modul">{{ nilai(index, props.item) }}</td>
                                    <td class="text-xs-left">{{props.item.rata_rata}}</td>
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
            snackbarText: '',
            snackbar: false,
            headerTable: [],
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
    mutation: {
        
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

        },
        showSnackbar(text) {
            var app = this
            app.snackbarText = text
            app.snackbar = true
        },
        nilai(index, obj) {
            index+=1
            var t = 'tugas_'+index
            return obj[t]
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

                    app.$store.state.obj_list_etugas = resp.data.etugas_kelas_mahasiswa
                    app.showSnackbar("Data berhasil disimpan!")
                    return true
                })
                .catch(function (resp) {
                    app.is_save = false
                    app.dialog = false
                    app.showSnackbar("oops, something went wrong. Please try again!")
                })
        }
    }
}
</script>
