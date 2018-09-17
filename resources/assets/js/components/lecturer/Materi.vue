<template>
    <v-flex sm12>
        <h1>Materi</h1>
        <div class="subheading">Tambahkan materi sebagai penunjang belajar mahasiswa</div>
        
        <content-loader v-if="!isLoaded" height="250"></content-loader>
        <v-flex v-if="isLoaded"  xs3 offset-xs9 align-end>
            <router-link to="materi/add"><v-btn color="info">Upload materi baru</v-btn></router-link>
        </v-flex>
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
                        <td class="text-xs-left" :id="'judul-'+props.item.id">{{ props.item.judul }}</td>
                        <td class="text-xs-center" :id="'keterangan'+props.item.id">{{ props.item.keterangan }}</td>
                        <td class="text-xs-center"><template v-if="props.item.file_url"><a slot="activator" v-bind:href="props.item.file_url"> Download File </a></template></td>
                        <td class="text-xs-center">
                            <div class="text-xs-center">
                                <v-btn fab dark small color="primary" @click="remove(props.item.id)">
                                <v-icon dark>remove</v-icon>
                                </v-btn>
                            </div>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-flex>

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
                { text: 'Hapus', value: 'id' },
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
            remove_id: ''
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
            axios.get('lecturer/materi').then(function (resp) {
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
            axios.get('lecturer/materi/get-by-semester/'+app.filter).then(function (resp) {
                app.bodyTable = resp.data.data;
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!");
            });
        },
        remove(id) {
            this.dialog = true;

            let matakuliah = $('#matakuliah-'+id).html();
            let kelas = $('#kelas-'+id).html();
            let judul = $('#judul-'+id).html();
            let keterangan = $('#keterangan-'+id).html();
            let app = this;
            app.title_confirm = 'Yakin ingin menghapus materi ?';
            app.desc_confirm = 'Materi dengan judul "'+judul+' kelas ' +kelas+ '" yang dihapus tidak bisa dikembalikan.';
            app.remove_id = id;
        },
        sureRemoveMe() {
            let app = this;
            axios.get('lecturer/materi/remove/'+app.remove_id).then(function (resp) {
                app.dialog = false;
                app.showSnackbar("Berhasil menghapus data");
                $('#tr-'+app.remove_id).fadeOut();
            })
            .catch(function (resp) {
                app.dialog = false;
                app.showSnackbar("oops, something went wrong. Please try again!");
            });
        }
    }
}
</script>
