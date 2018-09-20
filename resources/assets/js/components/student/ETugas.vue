<template>
    <v-flex sm12>
        <h1 class="font-weight-light">E Tugas</h1>
        <div class="subheading">Daftar tugas kuliah. Selesaikan tugas secara cepat dan tepat waktu</div>
        
        <content-loader v-if="!isLoaded" height="250"></content-loader>
        <v-flex md5 mt-5 v-if="isLoaded">
            <v-select 
                :items="semesters"
                v-model="filter"
                label="Filter jadwal"
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
            
        <v-flex sm12 v-if="isLoaded">
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
                        <td class="text-xs-center">
                            <template v-if="props.item.file_url">
                                <v-btn flat icon color="pink">
                                    <v-icon>close</v-icon>
                                </v-btn>
                            </template>
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
                <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                <v-card>
                    <v-toolbar dark color="primary">
                    <v-btn icon dark @click.native="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Settings</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.native="dialog = false">Save</v-btn>
                    </v-toolbar-items>
                    </v-toolbar>
                    <v-list three-line subheader>
                    <v-subheader>User Controls</v-subheader>
                    <v-list-tile avatar>
                        <v-list-tile-content>
                        <v-list-tile-title>Content filtering</v-list-tile-title>
                        <v-list-tile-sub-title>Set the content filtering level to restrict apps that can be downloaded</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile avatar>
                        <v-list-tile-content>
                        <v-list-tile-title>Password</v-list-tile-title>
                        <v-list-tile-sub-title>Require password for purchase or use password to restrict purchase</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    </v-list>
                    <v-divider></v-divider>
                    <v-list three-line subheader>
                    <v-subheader>General</v-subheader>
                    <v-list-tile avatar>
                        <v-list-tile-action>
                        <v-checkbox v-model="notifications"></v-checkbox>
                        </v-list-tile-action>
                        <v-list-tile-content>
                        <v-list-tile-title>Notifications</v-list-tile-title>
                        <v-list-tile-sub-title>Notify me about updates to apps or games that I downloaded</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile avatar>
                        <v-list-tile-action>
                        <v-checkbox v-model="sound"></v-checkbox>
                        </v-list-tile-action>
                        <v-list-tile-content>
                        <v-list-tile-title>Sound</v-list-tile-title>
                        <v-list-tile-sub-title>Auto-update apps at any time. Data charges may apply</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile avatar>
                        <v-list-tile-action>
                        <v-checkbox v-model="widgets"></v-checkbox>
                        </v-list-tile-action>
                        <v-list-tile-content>
                        <v-list-tile-title>Auto-add widgets</v-list-tile-title>
                        <v-list-tile-sub-title>Automatically add home screen widgets</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    </v-list>
                </v-card>
                </v-dialog>
            </v-layout>
            </template>
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
                { text: 'Judul Materi', value: 'judul' },
                { text: 'Keterangan', value: 'keterangan' },
                { text: 'Due Date', value: 'due_date' },
                { text: 'File Tugas', value: 'file_url' },
                { text: 'Status', value: 'id' },
            ],
            bodyTable: [],
            semesters: [],
            descriptionSemester: '',
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
    },
    methods: {
        initData() {
            var app = this;
            axios.get('student/e-tugas').then(function (resp) {
                app.isLoaded = true;
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
            axios.get('student/e-tugas/kuliah/'+app.filter).then(function (resp) {
                app.bodyTable = resp.data.data;
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!");
            });
        },
        detail(id) {
            this.dialog = true;

            let matakuliah = $('#matakuliah-'+id).html();
            let kelas = $('#kelas-'+id).html();
            let judul = $('#judul-'+id).html();
            let keterangan = $('#keterangan-'+id).html();
            let app = this;
            app.title_confirm = 'Yakin ingin menghapus tugas ?';
            app.desc_confirm = 'Tugas dengan judul "'+judul+' kelas ' +kelas+ '" yang dihapus tidak bisa dikembalikan.';
            app.remove_id = id;
        },
        dateView(date) {
            if (date != '0000-00-00 00:00:00') {
                return moment(date).format("dddd, Do MMMM YYYY, h:mm:ss a");
            }
            return '-'
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
