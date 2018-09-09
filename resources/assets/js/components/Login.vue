<template>
    <v-flex xs12 sm6>
      <v-card>
          <v-form v-model="valid" lazy-validation>
                <v-img
                src="img/benner.png"
                ></v-img>

                <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">Masuk</h3>
                    <div>Supaya kami tahu siapa Anda</div>
                </div>
                </v-card-title>
                <v-card-text>
                    <v-flex md12>
                        <v-text-field
                            :label="label"
                            v-model="data.username"
                            flat
                            clearable
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="data.password"
                            label="Password"
                            flat
                            type="password"
                            clearable
                            required
                        ></v-text-field>
                    </v-flex>
                    <p>
                        Anda {{labelBy}} ? <a @click="toggleForm()"> Masuk sebagai {{labelBy}}</a>
                    </p>
                </v-card-text>
                <v-card-actions>
                <v-btn flat color="primary" :disabled="!valid" @click="login()">Izinkan saya masuk</v-btn>
                </v-card-actions>
          </v-form>
      </v-card>
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
var axios = require('axios');

export default {
    data () {
        return {
            snackbarText: '',
            valid: true,
            snackbar: false,
            errors: [],
            isStudentFormActive: true,
            label: 'Nomer Induk Mahasiswa (NIM)',
            labelBy: 'dosen',
            data: {
                type: 'mahasiswa',
                username: '',
                password: ''
            }
        
        }
    },
    methods: {
        toggleForm() {
            var app = this;
            app.snackbarText = 'Anda berganti signin';

            if (app.isStudentFormActive) {
                app.label = 'Username';
                app.isStudentFormActive = false;
                app.data.type = 'dosen';
                app.labelBy = 'mahasiswa';
                this.snackbar = true;
                return true;
            }
            
            app.label = 'Nomer Induk Mahasiswa (NIM)';
            app.isStudentFormActive = true;
            app.data.type = 'mahasiswa';
            app.labelBy = 'dosen';
            this.snackbar = true;
            
        },
        login() {
            console.log("work");
            this.errors = [];
            event.preventDefault();
            this.validate();

            if (this.errors.length) {
                this.snackbarText = 'Semua inputan harus terisi';
                this.snackbar = true;
                
                return true;
            }
            return true
            var data = this.data;
            axios.post('login', data).then(function (resp) {
                
                if (resp.data.status ==1) {
                    swal('Selamat datang, Anda berhasil masuk');
                    window.location.href = resp.data.url;
                    return true;
                }

                swal('Data tidak ditemukan, silahkan coba lagi.');
            })
            .catch(function (resp) {
                swal("oops, something went wrong. Please try again!");
            });
        },
        validate() {
            var app = this;
            if (!app.data.username) app.errors.push(app.label + ' tidak boleh kosong');
            if (!app.data.password) app.errors.push('password tidak boleh kosong');
        },
    }
}
</script>
