<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <v-container
    fluid
    fill-height
  >
    <v-layout
      align-center
      justify-center
    >
      <v-flex
        xs12
        sm8
        md4
      >
        <v-card
          color="#fff"
          flat
        >
          <v-toolbar
            color="#fff"
            flat
          >
            <v-toolbar-title class="mx-auto display-1">
              Login
            </v-toolbar-title>
          </v-toolbar>
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
                v-model="data.email"
                label="Email"
                name="email"
                prepend-icon="person"
                :disabled="loading"
                :rules="[rules.required, rules.emailMatch]"
              />
              <v-text-field
                id="password"
                v-model="data.password"
                label="Password"
                name="password"
                prepend-icon="lock"
                :disabled="loading"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required]"
                :type="showPassword ? 'text' : 'password'"
                @click:append="showPassword = !showPassword"
              />
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn
              :loading="loading"
              :disabled="isComplate"
              color="primary"
              class="pl-5 pr-5"
              rounded
              large
              @click="postLogin"
            >
              Login
              <v-icon right>
                mdi-send
              </v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapActions, mapGetters, mapMutations, mapState } from 'vuex'

export default {
  data () {
    return {
      data: {
        email: '',
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
      snackbar: false
    }
  },
  computed: {
    ...mapGetters(['isAuth']), // MENGAMBIL GETTERS isAuth DARI VUEX
    ...mapState(['errors']),
    isComplate () {
      return !((this.data.email !== '' && this.data.password !== '') && !this.loading)
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
