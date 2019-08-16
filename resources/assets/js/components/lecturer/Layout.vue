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
      <v-list class="pa-0">
        <v-list-tile avatar>
          <v-list-tile-avatar>
            <img src="img/avatar.png">
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title id="title-name">Pringgo Juni S</v-list-tile-title>
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
         
          <v-list-group
            class=""
            v-model="mo_model"
            :key="mo_text"
            :prepend-icon="mo_model ? mo_icon : mo_icon_down"
            append-icon=""
            >
            <v-list-tile slot="activator">
              
              <v-list-tile-content>
                <v-list-tile-title>
                  Laporan Nilai
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
              v-for="(child, i) in children"
              :key="i"
              @click="link(child.link)"
            >
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ child.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list-group>
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
      <v-toolbar-title style="width: 300px" class="ml-0 pl-0">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span class="hidden-sm-and-down font-weight-regular">Manajemen Tugas</span>
      </v-toolbar-title>
      
      <v-spacer></v-spacer>
      <v-menu bottom left full-width>
        <v-avatar slot="activator" @click="logout">
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
          <router-view name="lecturerHome"></router-view>
          <router-view></router-view>
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
      items: [
        // { icon: 'home', text: 'Beranda', link: '/home'},
        { icon: 'history', text: 'E-tugas', link: '/e-tugas' },
        { icon: 'content_copy', text: 'Materi', link: '/materi' },
        { icon: 'date_range', text: 'Jadwal', link: '/schedule' },
        { icon: 'lock', text: 'Ubah Password', link: '/reset-password' },
      ],
      children: [
        { text: 'Nilai Permodul', link: '/nilai-permodul'},
      ],
      mo_icon: 'keyboard_arrow_up',
      mo_icon_down: 'keyboard_arrow_down',
      mo_text: 'Nilai',
      mo_model: false,
    }),
    props: {
      source: String
    },
    methods: {
      link(link) {
        this.$router.push(link)
      },
      logout() {
        let base_url = window.location.origin
        window.location.href = base_url+'/logout'
      }
    }
  }
</script>