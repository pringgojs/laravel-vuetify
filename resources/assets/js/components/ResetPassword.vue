<template>
    <v-flex sm12>
        <h1 class="font-weight-light"> Ubah Password</h1>
        <div class="subheading">Perbarui akun Anda secara berkala untuk menjaga keamanan akun</div>
        <content-loader v-if="!isLoaded" :height="250"></content-loader>

        <v-container fluid grid-list-xl v-if="isLoaded">
            <v-layout wrap align-center>
                <v-flex xs12>
                    <v-text-field
                        label="Password"
                        v-model="password"
                        solo
                    ></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="password">
                    <v-text-field
                        label="Ketik ulang password"
                        v-model="retypePassword"
                        solo
                    ></v-text-field>
                </v-flex>
                
                <!-- <router-link to="/materi"><v-btn flat >Kembali</v-btn></router-link> -->
                <v-btn color="info" @click="submit">Perbaruhi</v-btn>
            </v-layout>
        </v-container>

        <v-snackbar
            v-model="snackbar" right bottom  >
                {{snackbarText}}
                <v-btn dark flat @click="snackbar = false" >
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
            isLoaded: false,
            snackbarText: '',
            snackbar: false,
            password: '',
            retypePassword: '',

        }
    },
    mounted() {
        this.initData()
    },
    methods: {
        initData() {
            var app = this
            app.isLoaded = true
        },

        showSnackbar(text) {
            var app = this
            app.snackbarText = text
            app.snackbar = true
        },
        
        submit() {
            var app = this
            if (app.password == '') {
                app.showSnackbar('Password harus diisi')
                return false
            }

            if (app.retypePassword == '') {
                app.showSnackbar('Silahkan ketik ulang password anda')
                return false
            }

            if (app.retypePassword != app.password) {
                app.showSnackbar('Password yang Anda masukkan tidak sama')
                return false
            }

            let form = new FormData()
            form.append('password', app.password)
            axios.post( 'reset-password', form, { headers: {'Content-Type': 'multipart/form-data'}}).then(function (resp) {
                if (resp.data.code == 200) {
                    app.showSnackbar('Password berhasil diperbaruhi')
                    app.password = ''
                    app.retypePassword = ''
                }
            })
            .catch(function(e) {
                app.showSnackbar('Password gagal diperbaruhi')
            })
        }
    },
    components: {
        ContentLoader
    },
}

</script>