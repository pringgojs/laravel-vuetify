<template>
    <v-flex sm12>
        <h1>Materi Baru</h1>
        <div class="subheading">Tambahkan materi sebagai penunjang belajar mahasiswa</div>
        <v-flex xs3 offset-xs9 align-end>
            <router-link to="/materi"><v-btn color="success">Kembali</v-btn></router-link>
        </v-flex>


        <v-flex sm12 md6>
            <v-flex xs12 sm12 md12>
                <v-text-field
                    label="Judul Materi"
                    solo
                ></v-text-field>
            </v-flex>
            <v-flex xs12>
                <v-textarea
                solo
                name="input-7-4"
                label="Keterangan"
                ></v-textarea>
            </v-flex>
            <v-btn color="info">Simpan</v-btn>

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

export default {
    data () {
        return {
            snackbarText: '',
            snackbar: false,
        }
    },
    methods: {
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
