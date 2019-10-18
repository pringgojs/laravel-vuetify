<template>
    <v-flex sm12>
        <h1 class="font-weight-light">Perbarui Materi</h1>
        <div class="subheading">Tambahkan materi sebagai bahan belajar mahasiswa</div>
        <content-loader v-if="!isLoaded" :height="250"></content-loader>

        <v-container row grid-list-xl v-if="isLoaded">
            <v-layout wrap align-center>
                <template>
                    <v-flex md2 d-flex>
                        <v-select 
                            :items="filter.list_semester"
                            v-model="filter.semester"
                            label="Semester"
                            item-text="tahun"
                            item-value="semester"
                            @change="selectMatakuliah(1)"
                            solo
                        >
                            <template slot="selection" slot-scope="data">
                                {{ data.item.semester }}
                            </template>
                            <template slot="item" slot-scope="data">
                                {{ data.item.semester }}
                            </template>
                        </v-select>
                    </v-flex>
                    <v-flex md2 d-flex>
                        <v-select 
                            :items="filter.list_program"
                            v-model="filter.program"
                            label="Program"
                            item-text="program"
                            item-value="nomor"
                            solo
                            @change="selectMatakuliah()"
                        >
                        </v-select>
                    </v-flex>
                    <v-flex md4 d-flex>
                        <v-select 
                            :items="filter.list_jurusan"
                            v-model="filter.jurusan"
                            label="Jurusan"
                            item-text="jurusan"
                            item-value="nomor"
                            solo
                            @change="selectMatakuliah()"
                        >
                        </v-select>
                    </v-flex>
                    <v-flex md2 d-flex>
                        <v-select 
                            :items="filter.list_semester_tempuh"
                            v-model="filter.semester_tempuh"
                            label="Semester Tempuh"
                            solo
                            @change="selectMatakuliah()"
                        >
                        </v-select>
                    </v-flex>
                    <v-flex md2 d-flex>
                        <v-select 
                            :items="filter.list_pararel"
                            v-model="filter.pararel"
                            label="Pararel"
                            solo
                            @change="selectMatakuliah()"
                        >
                        </v-select>
                    </v-flex>
                    <v-flex md6 d-flex>
                        <v-select 
                            :items="filter.list_matakuliah"
                            v-model="filter.matakuliah"
                            label="Pilih matakuliah"
                            item-text="matakuliah"
                            item-value="nomor"
                            @change="selectModul()"
                            solo
                        >
                            <template slot="selection" slot-scope="data">
                                {{ data.item.matakuliah }}
                            </template>
                            <template slot="item" slot-scope="data">
                                {{ data.item.matakuliah }}
                            </template>
                        </v-select>
                    </v-flex>
                    <v-flex md6 d-flex>
                        <v-select 
                            :items="list_modul"
                            v-model="nilai_master_modul"
                            label="Pilih Modul"
                            item-text="modul"
                            item-value="nomor"
                            solo
                        >
                            <template slot="selection" slot-scope="data">
                                {{ data.item.modul }}
                            </template>
                            <template slot="item" slot-scope="data">
                                {{ data.item.modul }}
                            </template>
                        </v-select>
                    </v-flex>
                </template>

                <v-flex xs12 sm12 md12>
                    <v-text-field
                        label="Judul materi"
                        v-model="judul"
                        solo
                    ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-textarea
                    solo
                    name="input-7-4"
                    label="Keterangan"
                    v-model="keterangan"
                    ></v-textarea>
                </v-flex>
                
                <v-flex xs12>
                    <p>Tambahkan File (Optional)</p>
                    <file-pond
                        name="file"
                        ref="pond"
                        label-idle="Drop files here..."
                        allow-multiple="false"
                        v-bind:files="myFiles"/>
                    <p>Ukuran maksimal file 10MB dengan jenis file 'pdf', 'jpeg', 'jpg', 'png', 'zip', 'rar', 'xls', 'xlxs', 'doc', 'docx', 'ppt', 'pptx'. </p>
                    <template v-if="materi.file_url"><a slot="activator" v-bind:href="materi.file_url"> Download File </a></template>
                </v-flex>
                <router-link to="/materi"><v-btn flat >Saya berubah pikiran</v-btn></router-link>
                <v-btn color="info" @click="submit">Simpan</v-btn>

            </v-layout>
        </v-container>

        <v-snackbar v-model="snackbar" right bottom >
            {{snackbarText}}
            <v-btn dark flat @click="snackbar = false" >
                Close
            </v-btn>
        </v-snackbar>
    </v-flex>
</template>

<script>
import { ContentLoader } from 'vue-content-loader'

// Import Vue FilePond
import vueFilePond from 'vue-filepond'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginFileEncode from 'filepond-plugin-file-encode'
// Import FilePond styles
import 'filepond/dist/filepond.min.css'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css'
const FilePond = vueFilePond( 
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType,
    FilePondPluginFileEncode
)

export default {
    data () {
        return {
            isLoaded: false,
            snackbarText: '',
            snackbar: false,
            nilai_master_modul: '',
            list_modul: [],
            myFiles: '',
            judul: '',
            keterangan: '',
            menu: false,
            menu2: false,
            id: '',
            materi: '',
            filter: {
                list_semester: [],
                list_kelas: [],
                list_matakuliah: [],
                list_program: [],
                list_jurusan: [],
                list_semester_tempuh: [1,2,3,4,5,6,7,8],
                list_pararel: ['A', 'B'],
                semester: '',
                kelas: '',
                matakuliah: '',
                program: '',
                jurusan: '',
                semester_tempuh: '',
                pararel: '',
                
            }
        }
    },
    mounted() {
        this.initData()
    },
    created() {
        this.id = this.$route.params.id
    },
    methods: {
        initData() {
            var app = this
            axios.get('lecturer/materi/edit/'+this.id).then(function (resp) {
                app.isLoaded = true
                app.isLoaded = true
                app.filter.list_semester = resp.data.list_semester
                app.filter.list_jurusan = resp.data.list_jurusan
                app.filter.list_program = resp.data.list_program

                app.filter.list_matakuliah = resp.data.list_matakuliah
                app.filter.semester = resp.data.kuliah.tahun+'/'+resp.data.kuliah.semester
                app.filter.jurusan = resp.data.materi.jurusan
                app.filter.matakuliah = resp.data.kuliah.matakuliah
                app.filter.program = resp.data.materi.program
                app.filter.pararel = resp.data.materi.to_kelas.pararel
                app.filter.semester_tempuh = resp.data.semester_tempuh
                app.materi = resp.data.materi
                // data materi
                app.nilai_master_modul = resp.data.materi.nilai_master_modul
                app.list_modul = resp.data.list_modul
                app.judul = resp.data.materi.judul
                app.keterangan = resp.data.materi.keterangan
            })
            .catch(function (resp) {
                app.showSnackbar("oops, something went wrong. Please try again!")
            })
        },
        showSnackbar(text) {
            var app = this
            app.snackbarText = text
            app.snackbar = true
        },
        selectKelas() {
            if (!this.filter.semester) return false
            var app = this
            axios.get('filter/lecturer/get-kelas/'+app.filter.semester).then(function (resp) {
                app.filter.list_kelas = []
                app.filter.list_kelas = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        selectMatakuliah(is_semester_tempuh = '') {
            if (is_semester_tempuh == 1) {
                var split_semester = this.filter.semester.split('/')
                var ganjil_genap_semester = split_semester[1]
                if (ganjil_genap_semester == 1) {
                    this.filter.list_semester_tempuh = [1,3,5,7]
                } else {
                    this.filter.list_semester_tempuh = [2,4,6,8]
                }
            }
            if (!this.filter.kelas) return false
            var app = this
            axios.post('filter/lecturer/get-matakuliah', app.filter).then(function (resp) {
                app.filter.list_matakuliah = []
                app.filter.list_matakuliah = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        selectModul() {
            if (!this.filter.matakuliah) return false
            var app = this
            axios.post('filter/lecturer/get-modul', app.filter).then(function (resp) {
                app.list_modul = []
                app.list_modul = resp.data
            })
            .catch(function (resp) {
                app.showSnackbar("Terjadi kegagalan sistem. Silahkan coba lagi!")
            })
        },
        submit() {
            var app = this

            if (!app.nilai_master_modul) {
                app.showSnackbar('Anda belum memilih modul.')
                return false
            }

            if (!app.judul) {
                app.showSnackbar('Judul materi harus diisi')
                return false
            }

            if (!app.keterangan) {
                app.showSnackbar('Keterangan materi harus diisi')
                return false
            }
            
            var file = app.$refs.pond.getFiles()
            let form = new FormData()
            if (file.length) {
                form.append('file', file[0].file)
            } else {
                form.append('file', '')
            }
            form.append('judul', app.judul)
            form.append('keterangan', app.keterangan)
            form.append('nilai_master_modul', app.nilai_master_modul)
            form.append('program', app.filter.program)
            form.append('jurusan', app.filter.jurusan)
            form.append('matakuliah', app.filter.matakuliah)
            axios.post( 'lecturer/materi/update/'+app.id, form, { headers: {'Content-Type': 'multipart/form-data'}}).then(function (resp) {
                if (resp.data.code == 200) {
                    app.judul = ''
                    app.keterangan = ''
                    app.myFiles = []
                    app.showSnackbar('materi berhasil disimpan')
                    app.$router.push('/materi') 
                }
            })
            .catch(function(e) {
                app.showSnackbar('materi gagal disimpan')
            })
        }
    },
    components: {
        ContentLoader,
        FilePond
    },
}
</script>
