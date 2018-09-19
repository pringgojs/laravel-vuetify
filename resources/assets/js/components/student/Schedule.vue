<template>
    <v-flex sm12>
        <h1 class="font-weight-light">Jadwal</h1>
        <div class="subheading">Modul untuk perkuliahan</div>
        <content-loader v-if="!isLoaded" height="250"></content-loader>
        
        <v-flex sm12 v-if="isLoaded" mt-5>
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
            axios.get('student/schedule').then(function (resp) {
                app.isLoaded = true;
                app.bodyTable = resp.data.data;
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!");
            });
        },
        showSnackbar(text) {
            var app = this;
            app.snackbarText = text;
            app.snackbar = true;
        }
    }
}
</script>
