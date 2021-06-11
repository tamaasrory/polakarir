<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div
    style="background-size: 100% 100%;height: 100%;width: 100%"
    :style="`background-image: url(${require('../assets/bg-login.svg')});`"
  >
    <v-container
      fluid
      fill-height
    >
      <v-app-bar
        color="transparent"
        :elevation="0"
        fixed
        dark
      >
        <v-spacer />
        <img
          :src="require('@/assets/ic-nav.svg')"
          alt="W"
          height="30"
          width="40"
          style="cursor: pointer"
          class="mr-5"
          @click="$emit('toggle-drawer')"
        >
        <v-app-bar-title class="font-weight-bold">
          E-Office
        </v-app-bar-title>
        <v-spacer />
        {{ timeNow }}
        <v-spacer />
      </v-app-bar>
      <v-layout
        class="mt-10"
        align-center
        justify-center
      >
        <v-flex
          xs12
          sm8
          md8
        >
          <div class="mb-5">
            <div class="display-2 white--text">
              Selamat Datang di<br> E-Office Kota Pekanbaru
            </div>
            <div
              class="white--text mt-2"
              style="font-size: 17px"
            >
              Sistem Informasi Manajemen Arsip dan Persuratan
            </div>
          </div>
          <v-card
            color="#fff"
            elevation="4"
            class="px-3"
            style="border-radius: 15px;"
          >
            <v-layout class="pb-6">
              <v-flex
                xs12
                sm6
                md5
              >
                <div
                  style="color: #2D62ED;font-size: 17px;text-align: center"
                  class="pt-5"
                >
                  <strong>Login</strong> ke akun anda
                </div>
                <v-card-text>
                  <v-snackbar
                    v-model="snackbar"
                    vertical
                  >
                    {{ errors.message }}
                    <v-btn
                      color="pink"
                      text
                      @click="snackbar = false"
                    >
                      close
                    </v-btn>
                  </v-snackbar>
                  <v-form>
                    <v-text-field
                      v-model="data.username"
                      label="Username"
                      name="username"
                      outlined
                      :disabled="loading"
                      :rules="[rules.required]"
                    />
                    <v-text-field
                      id="password"
                      v-model="data.password"
                      label="Password"
                      name="password"
                      outlined
                      :disabled="loading"
                      :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                      :rules="[rules.required]"
                      :type="showPassword ? 'text' : 'password'"
                      @click:append="showPassword = !showPassword"
                    />
                  </v-form>
                  <v-btn
                    :loading="loading"
                    :disabled="isComplate"
                    color="#3ACCE1"
                    class="pl-5 pr-5"
                    rounded
                    large
                    :dark="!isComplate"
                    block
                    @click="postLogin"
                  >
                    Login
                  </v-btn>
                  <v-btn
                    link
                    text
                    class="text-center"
                    block
                    style="text-transform: capitalize;color:#2D62ED;"
                  >
                    Lupa Password ?
                  </v-btn>
                </v-card-text>
              </v-flex>
              <v-flex
                xs12
                sm6
                md7
              >
                <img
                  :src="require('@/assets/img-surat-login.png')"
                  style="position: absolute;transform: translate(0%,-25%);width: 60%;"
                >
              </v-flex>
            </v-layout>
          </v-card>
          <v-card
            color="#fff"
            elevation="4"
            class="px-3 mx-12"
            style="border-radius: 15px;transform: translateY(-30px)"
          >
            <v-card-text class="text-center">
              <v-btn
                icon
                color="#2D62ED"
              >
                <v-icon>mdi-instagram</v-icon>
              </v-btn>
              <v-btn
                icon
                color="#2D62ED"
              >
                <v-icon>mdi-twitter</v-icon>
              </v-btn>
              <v-btn
                icon
                color="#2D62ED"
              >
                <v-icon>mdi-facebook</v-icon>
              </v-btn>
              <v-btn
                icon
                color="#2D62ED"
              >
                <v-icon>mdi-earth</v-icon>
              </v-btn>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations, mapState } from 'vuex'

export default {
  data () {
    return {
      data: {
        username: '',
        password: '',
        remember_me: false
      },
      showPassword: false,
      rules: {
        required: value => !!value || 'Tidak Boleh Kosong',
        emailMatch: v => /.+@.+\..+/.test(v) || 'E-mail tidak valid'
      },
      loader: null,
      loading: false,
      snackbar: false,
      timeNow: this.$moment().format('DD MMMM YYYY HH:mm')
    }
  },
  computed: {
    ...mapGetters(['isAuth']), // MENGAMBIL GETTERS isAuth DARI VUEX
    ...mapState(['errors']),
    isComplate () {
      return !((this.data.username !== '' && this.data.password !== '') && !this.loading)
    }
  },
  watch: {
    loader () {
      this.loading = !this.loader
      this.loader = null
    }
  },
  // SEBELUM COMPONENT DI-RENDER
  created () {
    setInterval(() => {
      this.timeNow = this.$moment().format('DD MMMM YYYY HH:mm')
    }, 1000)
    // this.CLEAR_ERRORS()
    // KITA MELAKUKAN PENGECEKAN JIKA SUDAH LOGIN DIMANA VALUE isAuth BERNILAI TRUE
    if (this.isAuth) {
      // MAKA DI-DIRECT KE ROUTE DENGAN NAME home
      this.$router.push({ name: 'home' })
    }
  },
  methods: {
    ...mapMutations(['CLEAR_ERRORS']),
    ...mapActions(['login']),
    // KETIKA TOMBOL LOGIN DITEKAN, MAKA AKAN MEMINCU METHODS postLogin()
    postLogin () {
      this.loader = 'loading'
      this.CLEAR_ERRORS()
      // DIMANA TOMBOL INI AKAN MENJALANKAN FUNGSI submit() DENGAN MENGIRIMKAN DATA YANG DIBUTUHKAN
      this.login(this.data).then((data) => {
        // KEMUDIAN DI CEK VALUE DARI isAuth
        // APABILA BERNILAI TRUE
        if (this.isAuth) {
          // MAKA AKAN DI-DIRECT KE ROUTE DENGAN NAME home
          this.$router.go({
            path: 'home',
            force: false
          })
        } else {
          this.snackbar = true
          this.loading = false
        }
      })
    }
  }
}
</script>
<style>
  .custom-loader {
    animation: loader 1s infinite;
    display: flex;
  }
  @-moz-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @-webkit-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @-o-keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @keyframes loader {
    from {
      transform: rotate(0);
    }
    to {
      transform: rotate(360deg);
    }
  }
</style>
