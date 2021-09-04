<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="home">
    <v-app-bar
      color="white"
      fixed
      app
      light
    >
      <v-icon
        color="primary"
        class="mr-5"
        @click="$emit('toggle-drawer')"
        v-text="'mdi-menu'"
      />
      <v-spacer />
    </v-app-bar>
    <v-container class="px-10 pb-10">
      <div class="mb-3">
        <h1 class="my-2">
          Dashboard
        </h1>
      </div>
      <div
        v-if="loadingData"
        style="height: 300px;display: flex;align-items: center;justify-content: center"
      >
        <v-progress-circular
          :size="80"
          :width="5"
          color="grey"
          indeterminate
        />
      </div>
      <img
        :src="imgUrl"
        style="width: 100%"
        alt=""
      >
    </v-container>
  </div>
</template>

<script>
import { baseURL } from '@/router/Path'
import { mapActions } from 'vuex'

export default {
  name: 'Home',
  data: () => ({
    pegawai: {},
    imgUrl: null,
    loadingData: false
  }),
  created () {
    this.loadingData = true
    this.getDashboard()
      .then(data => {
        this.pegawai = data || {}
        this.loadingData = false
        this.imgUrl = baseURL + this.pegawai.url
      })
      .catch(() => {
        this.pegawai = {}
      })
  },
  methods: {
    ...mapActions(['getDashboard'])
  }
}
</script>
<style scoped>
.lead {
  font-size: 12pt !important;
  color: #6c6b6b;
}
</style>
