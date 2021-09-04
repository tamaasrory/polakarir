<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="surat-masuk">
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
      <v-toolbar-title>Pola Karir</v-toolbar-title>
      <v-spacer />
    </v-app-bar>
    <v-container
      fluid
      class="mt-4 mb-15"
    >
      <v-row justify="space-around">
        <v-col cols="8">
          <v-card
            color="#fff"
            elevation="0"
            class="px-3 py-4"
            style="border-radius: 15px;"
          >
            <h3 class="pb-4 text-center">
              Lihat Jalur
            </h3>
            <v-alert
              border="top"
              colored-border
              type="info"
              elevation="2"
            >
              {{ pesan }}
            </v-alert>
            <v-row>
              <v-col>
                <v-card>
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
                    v-if="imgUrl"
                    v-show="!loadingData"
                    width="auto"
                    height="auto"
                    :src="imgUrl"
                    style="width: 100%"
                  >
                  <img
                    v-if="!imgUrl"
                    v-show="!loadingData"
                    width="auto"
                    height="auto"
                    :src="require('@/assets/image404.svg')"
                    style="width: 100%"
                  >
                </v-card>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="4">
          <v-card
            color="#fff"
            elevation="3"
            class="px-7 py-4"
            style="border-radius: 15px;"
          >
            <h3 class="pb-4 text-center">
              Alur Karir {{ pegawai.nama_pegawai }}
            </h3>
            <div>
              <div>
                <h3 class="pt-2 pb-2">
                  Jenis Jabatan
                </h3>
              </div>
              <v-select
                v-model="filter.jenis_jabatan"
                :items="items.jenis_jabatan"
                class="outline yellow--text"
                solo
                style="border-radius: 15px;"
                label="Jenis Jabatan"
                @change="onChangeJenisJabatan"
              />
            </div>
            <div v-show="filter.jenis_jabatan===1">
              <div>
                <h3 class="pb-2">
                  Esselon
                </h3>
              </div>
              <v-select
                v-model="filter.esselon"
                :items="items.esselon"
                class="outline yellow--text"
                solo
                style="border-radius: 15px;"
                label="Esselon"
              />
            </div>
            <div v-show="filter.jenis_jabatan===2">
              <div>
                <h3 class="pb-2">
                  Fungsional
                </h3>
              </div>
              <v-select
                v-model="filter.fungsional"
                :items="items.fungsional"
                class="outline yellow--text"
                solo
                style="border-radius: 15px;"
                label="Jenis Jabatan"
              />
            </div>
            <div>
              <v-btn
                color="primary"
                rounded
                large
                block
                @click="filterButton"
              >
                Terapkan
              </v-btn>
            </div>
          </v-card>
          <v-card
            outlinedcolor="#fff"
            elevation="3"
            class="px-7 py-4 mt-10"
            style="border-radius: 15px;"
          >
            <h3 class="pb-4 text-center">
              Keterangan
            </h3>
            <div class="">
              <v-row class="row--dense align-center caption">
                <v-col cols="2">
                  <h1>━</h1>
                </v-col>
                <v-col cols="10">
                  <p>Horizontal : (Mutasi)</p>
                </v-col>
              </v-row>
              <v-row class="row--dense caption">
                <v-col cols="2">
                  <h1>/</h1>
                </v-col>
                <v-col cols="10">
                  <p>Diagonal : (Promosi/Mutasi)</p>
                </v-col>
              </v-row>
              <v-row class="row--dense caption">
                <v-col cols="2">
                  <h1>▏</h1>
                </v-col>
                <v-col cols="10">
                  <p>Vertikal : (Promosi/Kenaikan Jenjang)</p>
                </v-col>
              </v-row>
              <v-row class="row--dense caption">
                <v-col cols="3">
                  <h1>----</h1>
                </v-col>
                <v-col cols="9">
                  <p>Sekolah Kader : Fast Track</p>
                </v-col>
              </v-row>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { baseURL } from '@/router/Path'

export default {
  name: 'PolaKarir',
  data () {
    return {
      datas: [],
      pegawai: [],
      items: {
        jenis_jabatan: [],
        esselon: [],
        fungsional: []
      },
      filter: {
        jenis_jabatan: null,
        esselon: null,
        fungsional: null
      },
      imgUrl: null,
      loadingData: false,
      pesan: 'Tunggu Sebentar, Sendang Mencari...'
    }
  },

  created () {
    this.loadingData = true
    this.viewKarir()
      .then(data => {
        this.pegawai = data.pegawai || {}
        this.filter = {
          jenis_jabatan: this.pegawai.jenis_jabatan,
          esselon: this.pegawai.esselon,
          fungsional: this.pegawai.fungsional
        }
        this.items.jenis_jabatan = data.items.jenis_jabatan || []
        this.items.esselon = data.items.esselon || []
        this.items.fungsional = data.items.fungsional || []
        this.pesan = 'Tunggu Sebentar, Sendang Mencari...'
        this.filterKarir(this.filter)
          .then(d => {
            this.loadingData = false
            if (d.data) {
              console.log(d)
              this.pesan = 'Berikut data yang ditemukan'
              this.imgUrl = baseURL + d.data.url
            } else {
              this.pesan = 'Data yang sesuai tidak ditemukan!'
              this.imgUrl = false
            }
          })
        this.loadingData = false
      })
      .catch((error) => {
        console.log('Error : ' + error)
      })
  },
  methods: {
    ...mapActions(['viewKarir', 'filterKarir']),
    backButton () {
      this.$router.push({ name: 'surat_masuk' })
    },
    filterButton () {
      this.loadingData = true
      this.pesan = 'Tunggu Sebentar, Sendang Mencari...'
      this.filterKarir(this.filter)
        .then(d => {
          this.loadingData = false
          if (d.data) {
            console.log(d)
            this.pesan = 'Berikut data yang ditemukan'
            this.imgUrl = baseURL + d.data.url
          } else {
            this.pesan = 'Data yang sesuai tidak ditemukan!'
            this.imgUrl = false
          }
        })
    },
    onChangeJenisJabatan (e) {
      if (e === 1) {
        this.filter.fungsional = 0
      } else if (e === 2) {
        this.filter.esselon = 0
      } else {
        this.filter.fungsional = 0
        this.filter.esselon = 0
      }
    }
  }
}

</script>
<style>
.v-data-footer__icons-before,.v-data-footer__icons-after{
  display: none !important;
}
</style>
