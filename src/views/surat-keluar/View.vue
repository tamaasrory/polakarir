<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div>
    <v-app-bar
      fixed
      dark
      color="primary"
          >
      <v-btn
        icon
        dark
        @click="backButton"
      >
        <v-icon color="primary">mdi-arrow-left</v-icon>
      </v-btn>
      <v-toolbar-title style="line-height: 1.3">
        Detail Surat Keluar
        <div
          v-if="!loadingData"
          style="font-size: 11pt"
        >
          {{ surat_keluar.id }}
        </div>
        <v-skeleton-loader
          v-else
          ref="skeleton"
          type="text"
          max-width="100%"
        />
      </v-toolbar-title>
    </v-app-bar>
    <v-container class="white">
      <v-row class="py-0 mx-1">
        <v-col
          cols="12"
          md="4"
          class="mx-md-auto elevation-2 mt-md-3 mt-2"
          style="border-radius: 10px"
        >
          <v-col
            cols="12"
            md="6"
            class="d-flex"
          >
            <v-row>
              <v-col
                cols="12"
                md="12"
              >
                <label
                  class="v-label v-label--active theme--light"
                  style="font-size: 9pt !important;"
                >
                  Nama Surat Keluar
                </label>
                <div v-text="surat_keluar.nama" />
              </v-col>
              <v-col
                cols="12"
                md="12"
              >
                <label
                  class="v-label v-label--active theme--light"
                  style="font-size: 9pt !important;"
                >
                  Satuan
                </label>
                <div v-text="surat_keluar.satuan" />
              </v-col>
            </v-row>
          </v-col>
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
      surat_keluar: {}
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
