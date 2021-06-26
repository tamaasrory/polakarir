<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div>
    <v-app-bar
      color="white"
      fixed
      app
      light
    >
      <v-btn
        icon
        dark
        @click="backButton"
      >
        <v-icon color="primary">
          mdi-arrow-left
        </v-icon>
      </v-btn>
      <v-toolbar-title>Surat Keluar</v-toolbar-title>
    </v-app-bar>
    <v-container class="white">
      <v-row>
        <v-col
          cols="6"
          md="3"
        >
          Perihal
        </v-col>
        <v-col
          cols="6"
          md="9"
        >
          {{ surat_keluar.perihal_surat }}
        </v-col>
        <v-col
          cols="6"
          md="3"
        >
          Jenis Surat
        </v-col>
        <v-col
          cols="6"
          md="9"
        >
          {{ surat_keluar.jenis_surat }}
        </v-col>
        <v-col
          cols="6"
          md="3"
        >
          Urgensi
        </v-col>
        <v-col
          cols="6"
          md="9"
        >
          {{ surat_keluar.derajat_surat }}
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  props: {
    id: { type: [String, Number], required: true }
  },
  data () {
    return {
      loadingData: true,
      surat_keluar: {
        perihal_surat: null,
        jenis_surat: null,
        derajat_surat: null
      }
    }
  },
  created () {
    this.getSuratKeluarById({ id: this.id })
      .then(data => {
        this.surat_keluar = data || {}
        this.loadingData = false
      })
      .catch((error) => {
        this.surat_keluar = {}
        console.log('Error : ' + error)
      })
  },
  methods: {
    ...mapActions(['getSuratKeluarById']),
    backButton () {
      this.$router.push({ name: 'surat_keluar' })
    }
  }
}
</script>

<style scoped>
  .v-label {
    font-size: 19px !important;
  }

  .v-text-field > .v-input__control > .v-input__slot::after {
    content: none !important;
  }
</style>
