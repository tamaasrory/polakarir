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
        v-if="can(['surat-masuk-create'])"
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
            <v-img
              :src="require('@/assets/bkpsdm-administrator.png')"
              lazy-src="https://picsum.photos/id/11/10/6"
              max-height="650"
              max-width="698"
            />
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
              <v-select
                :items="items"
                class="outline yellow--text"
                solo
                style="border-radius: 15px;"
                label="Teknis/Non Teknis"
              />
            </v-row>
            <v-row>
              <v-select
                :items="items"
                class="outline yellow--text"
                solo
                style="border-radius: 15px;"
                label="Status Jabatan"
              />
            </v-row>
            <v-row>
              <v-select
                :items="items"
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

    <delete-dialog-confirm
      :show-dialog="showDC"
      :negative-button="dcNegativeBtn"
      :positive-button="dcPositiveBtn"
      :disabled-negative-btn="dcdisabledNegativeBtn"
      :disabled-positive-btn="dcdisabledPositiveBtn"
      :progress="dcProgress"
      :title="'Hapus'"
      :message="dcMessages"
    />
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
import Dialog from '@/components/Dialog'
import { can } from '@/plugins/supports'

export default {
  name: 'SuratMasuk',
  components: {
    'delete-dialog-confirm': Dialog
  },
  data () {
    return {
      searchQuery: '',
      toggleFp: false,
      isLoading: true,
      datas: [],
      pegawai: [],

      options: {},
      pagination: {},
      serverLength: 0,
      config: {
        table: {
          page: 1,
          pageCount: 0,
          sortBy: ['id_surat_masuk'],
          sortDesc: [true],
          itemsPerPage: 10,
          itemKey: 'id_surat_masuk'
        }
      },

      showDC: false,
      deleteId: '',
      dcMessages: '',
      dcProgress: false,
      dcdisabledNegativeBtn: false,
      dcdisabledPositiveBtn: false,
      dcNegativeBtn: () => { this.showDC = false },
      dcPositiveBtn: () => this._delete(true)
    }
  },
  computed: {
  },
  watch: {
    options (a, b) {
      // this._loadData(true)
    }
  },
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
  mounted () {
    // this._loadData(false) // loading data form server
  },
  methods: {
    ...mapActions(['getDashboard']),
    can

  },
  _clearFilter () {
    this.searchQuery = null
    this._loadData(true)
  }

}

</script>
<style>
.v-data-footer__icons-before,.v-data-footer__icons-after{
  display: none !important;
}
</style>
