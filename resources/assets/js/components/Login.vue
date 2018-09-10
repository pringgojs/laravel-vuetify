<template>
  <v-app id="inspire">
    

    <!-- toolbar -->
    <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      color="blue darken-3"
      dark
      app
      fixed
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <span class="hidden-sm-and-down">Dosen Jaga</span>
      </v-toolbar-title>
      
    </v-toolbar>
    <!-- end of toolbar -->
    
    <!-- content -->
    <v-content>
      <v-container fluid fill-height >
        <v-layout justify-center align-center>
          
          <!-- your content here -->
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
          <!-- end of your content -->

        </v-layout>
      </v-container>
    </v-content>
    <!-- end of content -->
    
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      dialog: false,
      drawer: null,
    }),
    props: {
      source: String
    }
  }
</script>
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

            if (app.isStudentFormActive) {
                app.label = 'Username';
                app.isStudentFormActive = false;
                app.data.type = 'dosen';
                app.labelBy = 'mahasiswa';
                app.showSnackbar('Anda berganti signin');
                return true;
            }
            
            app.label = 'Nomer Induk Mahasiswa (NIM)';
            app.isStudentFormActive = true;
            app.data.type = 'mahasiswa';
            app.labelBy = 'dosen';
            app.showSnackbar('Anda berganti signin');
        },
        login() {
            console.log("work");
            var app = this;
            app.errors = [];
            event.preventDefault();
            app.validate();

            if (app.errors.length) {
                app.snackbarText = 'Semua inputan harus terisi';
                app.snackbar = true;
                
                return true;
            }

            var data = app.data;
            axios.post('login', data).then(function (resp) {
                if (resp.data.status ==1) {
                    app.showSnackbar('Selamat datang, Anda berhasil masuk');
                    window.location.href = resp.data.url;
                    return true;
                }
                app.showSnackbar('Data tidak ditemukan, silahkan coba lagi.');

            })
            .catch(function (resp) {
                app.showSnackbar('oops, something went wrong. Please try again!');
            });
        },
        validate() {
            var app = this;
            if (!app.data.username) app.errors.push(app.label + ' tidak boleh kosong');
            if (!app.data.password) app.errors.push('password tidak boleh kosong');
        },
        showSnackbar(text) {
            var app = this;
            app.snackbarText = text;
            app.snackbar = true;
        }
    }
}
</script>
