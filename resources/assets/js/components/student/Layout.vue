<template>
  <v-app id="inspire">
    <v-navigation-drawer
      :clipped="$vuetify.breakpoint.lgAndUp"
      v-model="drawer"
      width="250"
      fixed
      app
    >
    <v-toolbar flat class="transparent">
      <v-list class="">
        <v-list-tile avatar>
          <v-list-tile-avatar>
            <img src="img/avatar.png">
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title id="title-name"></v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-toolbar>
      <v-list dense>
        <template v-for="item in items">
          <v-layout
            v-if="item.heading"
            :key="item.heading"
            row
            align-center
          >
          </v-layout>

          <v-list-tile v-else :key="item.text" @click="link(item.link)">
            <v-list-tile-action>
              <v-icon class="">{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>

    <!-- toolbar -->
    <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      color="blue darken-3"
      dark
      app
      fixed
    >
      <v-toolbar-title style="width: 300px" >
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span class="hidden-sm-and-down font-weight-regular">Manajemen Tugas</span>
      </v-toolbar-title>

      <v-spacer></v-spacer>
      
      <v-btn color="info" class="white--text" @click="manualBook" >
        <v-icon>book</v-icon>
        Manual book 
      </v-btn>
      <v-menu bottom left full-width>
        <v-avatar slot="activator"  @click="logout">
          <v-icon >logout</v-icon>
        </v-avatar>
      </v-menu>
      
    </v-toolbar>
    <!-- end of toolbar -->
    
    <!-- content -->
    <v-content>
      <v-container fluid fill-height >
        <v-layout justify-start align-left>
          
          <!-- your content here -->
          <router-view name="home"></router-view>
          <router-view></router-view>
          <!-- end of your content -->

        </v-layout>
        <User/>
      </v-container>
    </v-content>
    <!-- end of content -->
    
  </v-app>
</template>

<script>
  import Cookies from 'js-cookie'
  import User from './../User'

  export default {
    data: () => ({
      dialog: false,
      drawer: null,
      items: [
        // { icon: 'home', text: 'Beranda', link: '/beranda'},
        { icon: 'history', text: 'E-tugas', link: '/etugas' },
        { icon: 'content_copy', text: 'Materi', link: '/materi-kuliah' },
        { icon: 'lock', text: 'Ubah Password', link: '/reset-password' },
      ]
    }),
    props: {
      source: String
    },
    methods: {
      link(link) {
        this.$router.push(link)
      },
      logout() {
        Cookies.remove('user')
        let base_url = window.location.origin
        window.location.href = base_url+'/logout'
      },
      manualBook() {
        window.open('/mahasiswa.pdf', '_blank')
      }
    },
    mounted() {
    },
    components: {
      User
    }
  }
</script>