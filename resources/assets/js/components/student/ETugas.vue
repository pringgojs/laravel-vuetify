<template>
    <v-flex sm12>
        <h1 class="font-weight-light">E Tugas</h1>
        <div class="subheading">Daftar tugas kuliah. Selesaikan tugas secara cepat dan tepat waktu</div>
        <content-loader v-if="!isLoaded" :height="250"></content-loader>
        <v-flex md5 mt-5 v-if="isLoaded">
            <v-select 
                :items="semesters"
                v-model="filter"
                label="Pilih matakuliah"
                item-text="tahun"
                item-value="kuliah"
                @change="selectSemester()"
                solo
            >
                <template slot="selection" slot-scope="data">
                    {{ data.item.tahun }} / {{ data.item.semester }} - {{ data.item.matakuliah }}
                </template>
                <template slot="item" slot-scope="data">
                    {{ data.item.tahun }} / {{ data.item.semester }} - {{ data.item.matakuliah }}
                </template>
            </v-select>
        </v-flex>
            
        <v-flex sm12 v-if="isLoaded">
            <v-data-table
                :headers="headerTable"
                :items="$store.state.obj_list_etugas"
                hide-actions
                class="elevation-1"
            >
                <template slot="items" slot-scope="props">
                    <tr :id="'tr-'+props.item.id">
                        <td style="min-width:250px">{{ props.item.modul }}</td>
                        <td class="text-xs-left" :id="'matakuliah-'+props.item.id">{{ props.item.matakuliah }}</td>
                        <td class="text-xs-left" :id="'kelas-'+props.item.id">{{ props.item.tahun }} / {{ props.item.semester }} - {{ props.item.program }} {{ props.item.jurusan }} ({{props.item.kelas}} {{props.item.pararel}})</td>
                        <td class="text-xs-left" :id="'dosen-'+props.item.id">{{ props.item.nama }}</td>
                        <td class="text-xs-left" :id="'judul-'+props.item.id">
                            <a slot="activator"  @click="detail(props.item.id)"> 
                                {{ props.item.judul }}
                            </a>
                        </td>
                        <td class="text-xs-center" :id="'keterangan-'+props.item.id">{{ props.item.keterangan }}</td>
                        <td class="text-xs-center" :id="'due-date-'+props.item.id">{{ dateView(props.item.due_date) }}</td>
                        <td class="text-xs-center">
                            <template v-if="props.item.file_url">
                                <a v-bind:href="props.item.file_url"> 
                                    Download file tugas
                                </a>
                            </template>
                        </td>
                        <td class="text-xs-center" :style="statusLate(props.item.due_date, props.item.nilai_mahasiswa)" :id="'due-date-'+props.item.id">{{ props.item.nilai_mahasiswa ? dateView(props.item.nilai_mahasiswa.updated_at) : '-'}}</td>
                        <td class="text-xs-center">{{ props.item.nilai_mahasiswa ? props.item.nilai_mahasiswa.nilai : ''}}</td>

                        <td class="text-xs-center">
                            <template v-if="!props.item.nilai_mahasiswa">
                                <v-btn flat icon color="pink">
                                    <v-icon>close</v-icon>
                                </v-btn>
                            </template>
                            <template v-if="props.item.nilai_mahasiswa">
                                <v-btn flat icon color="info">
                                    <v-icon>check</v-icon>
                                </v-btn>
                            </template>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-flex>

        <!-- modal -->
        <detail-etugas></detail-etugas>
    </v-flex>
</template>

<script>
import { ContentLoader } from 'vue-content-loader';
import * as moment from 'moment';
moment.locale('id');

export default {
    data () {
        return {
            headerTable: [
                { text: 'Modul', value: 'modul' },
                { text: 'Matakuliah', value: 'matakuliah' },
                { text: 'Kelas', value: 'kelas' },
                { text: 'Dosen', value: 'nama' },
                { text: 'Judul Tugas', value: 'judul' },
                { text: 'Keterangan', value: 'keterangan' },
                { text: 'Due Date', value: 'due_date' },
                { text: 'File Lampiran Tugas', value: 'file_url' },
                { text: 'Tanggal Upload', value: 'id' },
                { text: 'Nilai', value: 'nilai' },
                { text: 'Status', value: 'id' },
            ],
            semesters: [],
            filter: '',
            snackbarText: '',
            snackbar: false,
            isLoaded: false,
            dialog: false,
            title_confirm: '',
            desc_confirm: '',
            detail_id: ''
        }
    },
    components: {
        ContentLoader
    },
    mounted() {
        this.initData();
        let count = this.$store.state.count
    },
    methods: {
        initData() {
            var app = this;
            axios.get('student/e-tugas').then(function (resp) {
                app.isLoaded = true;
                app.$store.state.obj_list_etugas = null
                app.$store.state.obj_list_etugas =  resp.data.data;
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
            axios.get('student/e-tugas/kuliah/'+app.filter).then(function (resp) {
                app.$store.state.obj_list_etugas = null
                console.log(resp.data)
                app.$store.state.obj_list_etugas = resp.data.data
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!");
            });
        },
        detail(id) {
            var app = this;

            axios.get('student/e-tugas/detail/'+id).then(function (resp) {
                app.$store.state.obj_etugas = resp.data
                app.$store.state.form_dialog_detail_etugas = true
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!");
            });
        },
        dateView(date) {
            if (date != '0000-00-00 00:00:00') {
                return moment(date).format("dddd, Do MMMM YYYY, h:mm:ss a");
            }
            return '-'
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

<style>
.fab-container {
  position: fixed;
  bottom: 20px;
  right: 0;
}
</style>
