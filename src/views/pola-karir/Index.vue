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
        v-if="can(['surat-keluar-create'])"
        title="Tambah Surat Keluar"
        icon
        @click="_add()"
      >
        <v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-btn
        icon
        @click="booltmp.fp = !booltmp.fp"
      >
        <v-icon>mdi-magnify</v-icon>
      </v-btn>
      <v-btn
        title="Perbarui Data"
        icon
        @click="_loadData(true)"
      >
        <v-icon>mdi-reload</v-icon>
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer
      v-model="booltmp.fp"
      fixed
      width="350"
      temporary
      right
    >
      <v-list-item class="grey lighten-4">
        <v-list-item-content>
          <v-list-item-title>
            <v-icon>mdi-magnify</v-icon> Filter Pola Karir
          </v-list-item-title>
        </v-list-item-content>
        <v-list-item-icon>
          <v-btn
            icon
            @click="booltmp.fp=!booltmp.fp"
          >
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </v-list-item-icon>
      </v-list-item>

      <v-row class="px-4 py-4">
        <v-col
          cols="12"
        >
<!--          <v-text-field
            v-model="filterQuery.search"
            placeholder="ketikkan sesuatu"
            label="Pencarian"
            light
            clearable
            hide-details
            outlined
            class="mb-4"
          />-->
          <v-select
            v-model="filterQuery.nomor_surat"
            placeholder="ketikkan nomor surat"
            :items="jabatan"
            label="Jenis Jabatan"
            light
            clearable
            hide-details
            outlined
            class="mb-4"
          />
          <v-select
            v-model="filterQuery.penerima"
            placeholder="ketikkan nama penerima"
            :items="esselon"
            label="Esselon"
            light
            clearable
            hide-details
            outlined
            class="mb-4"
          />
          <v-select
            v-model="filterQuery.penerima"
            placeholder="ketikkan nama penerima"
            :items="fungsional"
            label="Fungsional"
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
          v-show="isClearSearch"
          text
          color="primary"
          @click="_clearFilter()"
        >
          Bersihkan filter
        </v-btn>
        <v-btn
          color="success"
          @click="_loadData(true)"
        >
          Terapkan
        </v-btn>
      </div>
    </v-navigation-drawer>
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
              Alur Karir {{ pegawai.nama_pegawai }}
            </h3>
            <v-row>
              <h3 class="pt-2 pb-2">
                Jenis Jabatan
              </h3>
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
              <h3 class="pb-2">
                Esselon
              </h3>
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
              <h3 class="pb-2">
                Fungsional
              </h3>
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
            color="#fff"
            elevation="0"
            class="px-7 py-4"
            style="border-radius: 15px;"
          >
            <h3 class="pb-4 text-center">
              Alur Karir {{ pegawai.nama_pegawai }}
            </h3>
            <v-row>
              <h3 class="pt-2 pb-2">
                Jenis Jabatan
              </h3>
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
              <h3 class="pb-2">
                Esselon
              </h3>
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
              <h3 class="pb-2">
                Fungsional
              </h3>
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
      v-model="booltmp.fp"
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
            @click="booltmp.fp=!booltmp.fp"
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
import { can, isEmpty } from '@/plugins/supports'

export default {
  name: 'SuratMasuk',
  data () {
    return {
      filterQuery: {
        nomor_surat: null,
        penerima: null,
        tgl: null
      },
      booltmp: {
        fp: false,
        ft: false
      },
      jabatan: ['Struktural', 'Fungsional', 'Pelaksana'],
      esselon: ['2A', '2B','3A','3B','4A','4B'],
      fungsional: ['Pemula', 'Terampil','Mahir','Penyelia','Ahli Pertama','Ahli Muda','Ahli Madya','Ahli Utama'],
      datas: [],
      pegawai: [],
      imgUrl: null
    }
  },
  watch: {
    options (a, b) {
      this._loadData(true)
    }
  },
  mounted() {
    this._loadData(false) // loading data form server
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
  computed: {
    isClearSearch () {
      for (const filterTaskKey in this.filterQuery) {
        if (!isEmpty(this.filterQuery[filterTaskKey])) {
          return true
        }
      }
      return false
    }
  },
  methods: {
    ...mapActions(['getDashboard', 'getPolaKarir']),
    can,
    backButton () {
      this.$router.push({ name: 'surat_masuk' })
    },
    _clearFilter () {
      this.filterQuery = {
        nomor_surat: null,
        penerima: null,
        tgl: null,
        search: null
      }
      this._loadData(true)
    },
    _loadData (abort) {
      if (this.datas.length === 0 || abort) {
        this.isLoading = true
        this.getPolaKarir({ add: this.filterQuery, ...this.options })
          .then((data) => {
            this.datas = data.items || []
            this.serverLength = data.total || 0
            this.isLoading = false
          })
      } else {
        this.isLoading = false
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
