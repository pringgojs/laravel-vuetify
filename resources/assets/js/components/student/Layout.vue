<template>
  <v-app id="inspire">
    <v-navigation-drawer
      :clipped="$vuetify.breakpoint.lgAndUp"
      v-model="drawer"
      width="250"
      fixed
      app
    >
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
              <v-icon class="ml-0 pl-3">{{ item.icon }}</v-icon>
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
      <v-toolbar-title style="width: 300px" class="ml-0 pl-0">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span class="hidden-sm-and-down font-weight-regular">Dosen Jaga</span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="search"
        placeholder="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>apps</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>notifications</v-icon>
      </v-btn>
      <v-menu bottom left full-width>
        <v-avatar slot="activator">
          <v-icon >account_circle</v-icon>
        </v-avatar>
          <v-list>
            <v-list-tile
              @click="logout"
            >
              <v-list-tile-title>Keluar</v-list-tile-title>
            </v-list-tile>
          </v-list>
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
        { icon: 'home', text: 'Beranda', link: '/beranda'},
        { icon: 'history', text: 'E-tugas', link: '/etugas' },
        { icon: 'content_copy', text: 'Materi', link: '/materi-kuliah' },
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
        let base_url = window.location.origin
        window.location.href = base_url+'/logout'
      }
    },
    mounted() {
    }
  }
</script>