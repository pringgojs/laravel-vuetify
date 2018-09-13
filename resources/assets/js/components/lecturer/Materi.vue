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
                    <tr @click="addMateri(props.item.nomor_nilai_master_modul)">
                        <td>{{ props.item.modul }}</td>
                        <td class="text-xs-left">{{ props.item.matakuliah }}</td>
                        <td class="text-xs-center">{{ props.item.program }}</td>
                        <td class="text-xs-left">{{ props.item.jurusan }}</td>
                        <td class="text-xs-left">{{ props.item.tahun }}</td>
                        <td class="text-xs-center">{{ props.item.semester }}</td>
                        <td class="text-xs-center">{{ props.item.pararel }}</td>
                    </tr>
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

        <!-- dialog -->
            <v-dialog v-model="dialog" width="800px">
                <v-card>
                    <v-card-title
                    class="grey lighten-4 py-4 title"
                    >
                    Materi Baru
                    </v-card-title>
                    <v-card-text>
                        <v-flex xs12>
                            <v-text-field
                                label="Judul"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-textarea
                            name="input-7-1"
                            label="Keterangan"
                            value=""
                            ></v-textarea>
                        </v-flex>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="dialog = false">Cancel</v-btn>
                        <v-btn flat @click="dialog = false">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
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
            descriptionSemester: '',
            filter: '',
            snackbarText: '',
            snackbar: false,
            isLoaded: false,
            dialog: false,
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
            axios.get('lecturer/schedule').then(function (resp) {
                app.isLoaded = true;
                app.descriptionSemester = resp.data.keterangan;
                app.bodyTable = resp.data.data;
                app.semesters = resp.data.data_semester;
                console.log(resp.data);
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
            app.isLoaded = false;
            axios.get('lecturer/schedule/get-by-semester/'+app.filter).then(function (resp) {
                app.isLoaded = true;
                app.descriptionSemester = resp.data.keterangan;
                app.bodyTable = resp.data.data;
            })
            .catch(function (resp) {
                showSnackbar("oops, something went wrong. Please try again!");
            });
        },
        addMateri(nomor_nilai_master_modul) {
            this.dialog = true;
        }
    }
}
</script>
