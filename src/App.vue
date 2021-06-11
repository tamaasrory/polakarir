<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <v-app>
    <v-navigation-drawer
      v-if="isAuth"
      v-model="drawer"
      color="#2D62ED"
      fixed
      app
      left
      dark
    >
      <v-list-item>
        <v-list-item-action>
          <img
            :src="require('@/assets/ic-nav-vertical.svg')"
            alt="W"
            height="30"
            width="40"
            style="cursor: pointer"
            @click="$emit('toggle-drawer')"
          >
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title class="title">
            E-Office
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            {{ user ? user.name : '' }}
          </v-list-item-title>
          <v-list-item-subtitle>
            {{ user ? user.role[0] : '' }}
          </v-list-item-subtitle>
        </v-list-item-content>
        <v-menu
          bottom
          left
        >
          <template #activator="{ on, attrs }">
            <v-btn
              dark
              icon
              v-bind="attrs"
              v-on="on"
            >
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
          </template>

          <v-list>
            <v-list-item>
              <v-list-item-title style="cursor: pointer">
                Profile
              </v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title
                style="cursor: pointer"
                @click="showDialogLogout = true"
              >
                Logout
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
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
      </v-list>
    </v-navigation-drawer>
    <v-main :style="isAuth ? /*'margin-top:50pt;margin-bottom:50pt'*/'' : ''">
      <router-view @toggle-drawer="toggleDrawer" />
      <dialog-logout
        :show-dialog="showDialogLogout"
        :negative-button="cancelLogout"
        :positive-button="postLogout"
        :title="'Logout'"
        :message="'Apakah anda yakin akan keluar dari sistem?'"
      />
    </v-main>
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
    drawer: true,
    showDialogLogout: false,
    toolbarTitle: 'E-Office',
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
    console.log(JSON.stringify(this.user))
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
      if (this.isAuth) {
        this.drawer = !this.drawer
      }
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
