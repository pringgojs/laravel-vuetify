<template>
    <v-layout row justify-center>
        <v-dialog v-model="formDialogDetail" fullscreen hide-overlay transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar dark color="primary">
            <v-btn icon dark @click="closeFormDialog">
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>Pendidikan Agama</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn dark flat @click.native="saveFormDialog">Save</v-btn>
            </v-toolbar-items>
            </v-toolbar>
            <v-list three-line subheader>
            <v-subheader>Detail Etugas</v-subheader>
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
                <v-checkbox ></v-checkbox>
                </v-list-tile-action>
                <v-list-tile-content>
                <v-list-tile-title>Notifications</v-list-tile-title>
                <v-list-tile-sub-title>Notify me about updates to apps or games that I downloaded</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile avatar>
                <v-list-tile-action>
                <v-checkbox></v-checkbox>
                </v-list-tile-action>
                <v-list-tile-content>
                <v-list-tile-title>Sound</v-list-tile-title>
                <v-list-tile-sub-title>Auto-update apps at any time. Data charges may apply</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile avatar>
                <v-list-tile-action>
                <v-checkbox></v-checkbox>
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

<script>
export default {
    data () {
        return {
            tugas_id: ''
        }
    },
    
    // computed for return object to template in vuex
    computed: {
        getID() {
            return this.$store.state.detailEetugasId
        },
        formDialogDetail() {
            return this.$store.state.formDetailEtugas
        }
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
            this.$store.state.formDetailEtugas = false
        },
        closeFormDialog() {
            console.log('x')
            this.$store.state.formDetailEtugas = false
        }
    }
}
</script>
