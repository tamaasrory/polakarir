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
      <v-btn
        title="Tambah Surat Masuk"
        icon
        @click="_add()"
      >
        <v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-btn
        icon
        @click="toggleFp = !toggleFp"
      >
        <v-icon>mdi-magnify</v-icon>
      </v-btn>
      <!--      <v-btn
        title="Perbarui Data"
        icon
        @click="_loadData(true)"
      >
        <v-icon>mdi-reload</v-icon>
      </v-btn>-->
    </v-app-bar>
    <v-container
      fluid
      class="mt-15 mb-15"
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
              View Jalur
            </h3>
            <v-row>
              <v-col>
                <v-card>
                  <v-img
                          :src="imgUrl"
                  />
                </v-card>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="4">
          <v-card
            color="#fff"
            elevation="0"
            class="px-7 py-4"
            style="border-radius: 15px;"
          >
            <h3 class="pb-4 text-center">
              Alur Karir {{pegawai.nama_pegawai}}
            </h3>
            <v-row>
              <h3 class="pt-2 pb-2">Jenis Jabatan</h3>
              <v-select
                v-model="datas.nama_jenis_jabatan"
                :items="datas.nama_jenis_jabatan"
                class="outline yellow--text"
                solo
                style="border-radius: 15px;"
                label="Jenis Jabatan"
              />
            </v-row>
            <v-row>
              <h3 class="pb-2">Esselon</h3>
              <v-select
                 v-model="datas.nama_esselon"
                :items="datas.nama_esselon"
                class="outline yellow--text"
                solo
                style="border-radius: 15px;"
                label="Esselon"
              />
            </v-row>
            <v-row>
              <h3 class="pb-2">Fungsional</h3>
              <v-select
                v-model="datas.nama_fungsional"
                :items="datas.nama_fungsional"
                class="outline yellow--text"
                solo
                style="border-radius: 15px;"
                label="Jenis Jabatan"
              />
            </v-row>
          </v-card>
          <v-card
            outlinedcolor="#fff"
            elevation="0"
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
      </v-card>
      </v-col>
      </v-row>
    </v-container>

    <v-navigation-drawer
      v-model="toggleFp"
      fixed
      width="350"
      temporary
      right
    >
      <v-list-item class="grey lighten-4">
        <v-list-item-content>
          <v-list-item-title>
            <v-icon>mdi-filter-outline</v-icon> Filter
          </v-list-item-title>
        </v-list-item-content>
        <v-list-item-icon>
          <v-btn
            icon
            @click="toggleFp=!toggleFp"
          >
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </v-list-item-icon>
      </v-list-item>

      <v-row class="px-4 py-4">
        <v-col
          cols="12"
        >
          <v-text-field
            v-model="searchQuery"
            placeholder="ketikkan sesuatu untuk mencari"
            label="Pencarian"
            light
            clearable
            hide-details
            outlined
            class="mb-4"
          />
        </v-col>
      </v-row>
      <div
        class="text-right px-4 py-4"
        style="position: absolute;bottom: 0;right: 0"
      >
        <v-btn
          v-show="searchQuery"
          text
          color="primary"
          @click="_clearFilter()"
        >
          Bersihkan filter
        </v-btn>
        <!--        <v-btn
          color="success"
          @click="_loadData(true)"
        >
          Terapkan
        </v-btn>-->
      </div>
    </v-navigation-drawer>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { baseURL } from '@/router/Path'
import Dialog from '@/components/Dialog'
import { can } from '@/plugins/supports'

export default {
  name: 'SuratMasuk',
  data () {
    return {
      datas: [],
      pegawai: [],
      imgUrl: null
    }
  },
  
  created () {
    this.getDashboard()
            .then(data => {
              this.datas = data.value || {}
              this.pegawai = data.pegawai || {}
              this.imgUrl = baseURL + this.datas.url
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
<style>
.v-data-footer__icons-before,.v-data-footer__icons-after{
  display: none !important;
}
</style>
