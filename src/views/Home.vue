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
      <Account />
    </v-app-bar>
    <v-container class="px-10 pb-10">
      <div class="mb-3">
        <h1 class="my-2">
          Dashboard
        </h1>
        <h1 class="my-2">
          Nama : {{pegawai.nama_pegawai}}
        </h1>
        <h1 class="my-2">
          Esselon : {{datas.esselon}}
        </h1>
        <h1 class="my-2">
          Jenis_Jabatan : {{datas.kode_jabatan}}
        </h1>
         <h1 class="my-2">
          Fungsional : {{datas.fungsional}}
        </h1>
        <h1 class="my-2">
          URL : {{datas.url}}
        </h1>
      </div>
    </v-container>
  </div>
</template>

<script>
import Account from '@/components/default/Account'
import { mapActions } from 'vuex'
export default {
  name: 'Home',
  components: { Account },
  data: () => ({
    queryTask: [],
    datas: [],
    pegawai: [],
  }),
  created () {
    this.getDashboard()
            .then(data => {
              this.datas = data.value || {}
              this.pegawai = data.pegawai || {}
              this.loadingData = false
            })
            .catch((error) => {
              this.datas = {}
              console.log('Error : ' + error)
            })
  },
  methods: {
    ...mapActions(['getDashboard']),
    backButton () {
      this.$router.push({ name: 'surat_masuk' })
    }
  }
}
</script>
<style scoped>
.lead {
  font-size: 12pt !important;
  color: #6c6b6b;
}
</style>
