<template>
    <v-flex sm12>
        <h1 class="font-weight-light">Jadwal</h1>
        <div class="subheading">Modul untuk perkuliahan {{descriptionSemester}}</div>
        <content-loader v-if="!isLoaded" :height="250"></content-loader>
        
        <v-flex sm6 d-flex mt-5 v-if="isLoaded">
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
                    <td>{{ props.item.modul }}</td>
                    <td class="text-xs-left">{{ props.item.matakuliah }}</td>
                    <td class="text-xs-center">{{ props.item.program }}</td>
                    <td class="text-xs-left">{{ props.item.jurusan }}</td>
                    <td class="text-xs-left">{{ props.item.tahun }}</td>
                    <td class="text-xs-center">{{ props.item.semester }}</td>
                    <td class="text-xs-center">{{ props.item.pararel }}</td>
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
        }
    }
}
</script>
