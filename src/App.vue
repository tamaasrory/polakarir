<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <v-app>
    <v-app-bar
      v-if="isAuth"
      color="#0288D1"
      fixed
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title>{{ toolbarTitle }}</v-toolbar-title>
      <v-spacer />

      <v-btn
        icon
        @click="showDialogLogout = true"
      >
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>

    <v-navigation-drawer
      v-if="isAuth"
      v-model="drawer"
      fixed
      left
      temporary
    >
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            {{ user ? user.name : '' }}
          </v-list-item-title>
          <v-list-item-subtitle>
            {{ user ? user.email : '' }}
          </v-list-item-subtitle>
        </v-list-item-content>
        <v-btn
          icon
          @click.stop="drawer = !drawer"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>

      <v-divider />

      <v-list subheader>
        <template v-for="(item, index) in items">
          <v-subheader
            v-if="!!item.subheader"
            :key="item.subheader"
            v-text="item.subheader"
          />
          <v-list-item
            :key="index"
            :to="item.link"
            link
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
        <v-list-item
          link
          @click="showDialogLogout = true"
        >
          <v-list-item-icon>
            <v-icon>mdi-logout</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-main :style="isAuth ? 'margin-top:50pt;margin-bottom:50pt' : ''">
      <router-view @toggle-drawer="toggleDrawer" />
      <dialog-logout
        :show-dialog="showDialogLogout"
        :negative-button="cancelLogout"
        :positive-button="postLogout"
        :title="'Logout'"
        :message="'Apakah anda yakin akan keluar dari sistem?'"
      />
    </v-main>
    <v-footer
      v-if="!isAuth"
      absolute
      class="font-weight-medium"
    >
      <v-col
        class="text-center"
        cols="12"
      >
        {{ new Date().getFullYear() }} —
        <strong>Tajriy App</strong>
      </v-col>
    </v-footer>
  </v-app>
</template>

<script>
import { mapActions, mapGetters, mapState } from 'vuex'
import Dialog from './components/Dialog'
import menus from './router/menus'

export default {
  name: 'App',
  components: {
    'dialog-logout': Dialog
  },
  data: () => ({
    drawer: false,
    showDialogLogout: false,
    toolbarTitle: 'Dashboard',
    items: []
  }),
  computed: {
    ...mapGetters(['isAuth']),
    ...mapState(['user'])
  },
  watch: {
    $route (to, from) {
      this.toolbarTitle = to.meta.title
      this.items = []
      for (let i = 0; i < menus.length; i++) {
        const { path, meta } = menus[i]
        const { allowRole, icon, title, subheader } = meta
        if (this.user !== null) {
          if (allowRole) {
            let allow = false
            const roles = this.user.role || []
            for (let j = 0; j < roles.length; j++) {
              if (allowRole.includes(roles[j])) {
                allow = true
              }
            }

            if (allow) {
              if (icon) {
                const tmp = { title: title, icon: icon, link: path }
                if (subheader) {
                  let alreadyExist = false
                  for (const item of this.items) {
                    if (subheader === item.subheader) {
                      alreadyExist = true
                    }
                  }
                  if (!alreadyExist) {
                    tmp.subheader = subheader
                  }
                }
                this.items.push(tmp)
              }
            }
          }
        }
      }
    }
  },
  created () {
  },
  methods: {
    ...mapActions(['logout']),
    postLogout () {
      // KEMUDIAN DI CEK VALUE DARI isAuth
      // APABILA BERNILAI TRUE
      this.logout()
      this.showDialogLogout = false
      if (!this.isAuth) {
        // MAKA AKAN DI-DIRECT KE ROUTE DENGAN NAME home
        this.$router.push({ name: 'login' })
      }
    },
    cancelLogout () {
      this.showDialogLogout = false
    },
    toggleDrawer () {
      this.drawer = !this.drawer
    }
  }
}
</script>
<style>
  html {
    overflow: scroll;
    overflow-x: hidden;
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
  }

  ::-webkit-scrollbar {
    width: 0px; /* Remove scrollbar space */
    background: transparent; /* Optional: just make scrollbar invisible */
  }

  /* Optional: show position indicator in red */
  ::-webkit-scrollbar-thumb {
    background: rgba(217, 217, 217, 0.99);
  }

  .theme--light.v-application {
    background: #ffffff !important;
    color: rgba(0, 0, 0, 0.87);
  }
</style>
