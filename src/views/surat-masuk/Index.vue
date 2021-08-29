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
      <v-btn
        title="Perbarui Data"
        icon
        @click="_loadData(true)"
      >
        <v-icon>mdi-reload</v-icon>
      </v-btn>
    </v-app-bar>
    <v-container fluid>
      <h1 class="my-2">
        Pilih Alur Karir
      </h1>
      <div class="mt-lg-10">
      <v-row>
        <v-col cols="3">
          <v-subheader
            class="font-weight-black black--text"
          >Teknis/Non Teknis</v-subheader>
        </v-col>
        <v-col cols="5">
          <v-text-field
            class="outline yellow--text"
            outlined
          ></v-text-field>
        </v-col>
      </v-row>
        <v-row>
          <v-col cols="3">
            <v-subheader
              class="font-weight-black black--text"
            >Status Jabatan</v-subheader>
          </v-col>
          <v-col cols="5">
            <v-text-field
              class="outline yellow--text"
              outlined
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="3">
            <v-subheader
              class="font-weight-black black--text"
            >Jenis Jabatan</v-subheader>
          </v-col>
          <v-col cols="5">
            <v-text-field
              class="outline yellow--text"
              outlined
            ></v-text-field>
          </v-col>
        </v-row>
      </div>
      <h1 class="my-2">
        View Jalur
      </h1>
      <v-container class="mb-15">
        <v-row justify="space-around">
      <v-card >
        <v-img
          :src="require('@/assets/bkpsdm-administrator.png')"
          lazy-src="https://picsum.photos/id/11/10/6"
          max-height="650"
          max-width="698"
        >

        </v-img>
      </v-card>
        </v-row>
      </v-container>
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
        <v-btn
          color="success"
          @click="_loadData(true)"
        >
          Terapkan
        </v-btn>
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
    headerData () {
      return [
        {
          text: 'Nomor',
          align: 'left',
          value: 'id_surat_masuk'
        },
        { text: 'Perihal', value: 'perihal_surat' },
        { text: 'Jenis Surat', value: 'jenis_surat' },
        { text: 'Pengirim', value: 'pengirim_surat' },
        { text: 'Tanggal Surat', value: 'tanggal_surat' },
        { text: 'Urgensi', value: 'derajat_surat' },
        { text: 'Status', value: 'status' }
      ]
    }
  },
  watch: {
    options (a, b) {
      this._loadData(true)
    }
  },
  mounted () {
    this._loadData(false) // loading data form server
  },
  methods: {
    ...mapActions(['getSuratMasuk', 'deleteSuratMasuk']),
    can,
    _detail (value) {
      this.$router.push({ name: 'surat_masuk_view', params: { id: value.id_surat_masuk } })
    },
    _add () {
      this.$router.push({ name: 'surat_masuk_add' })
    },
    _edit (value) {
      this.$router.push({ name: 'surat_masuk_edit', params: { id: value.id_surat_masuk } })
    },
    _delete (value) {
      if (value === true) {
        this.dcProgress = true
        this.dcdisabledNegativeBtn = true
        this.dcdisabledPositiveBtn = true
        this.dcMessages = 'Sedang menghapus surat masuk'
        this.deleteSuratMasuk(this.deleteId).then(res => {
          this._loadData(true)
          this.dcProgress = false
          this.dcMessages = 'Berhasil Menghapus Surat Masuk'
          setTimeout(() => {
            this.deleteId = ''
            this.showDC = false
            this.dcdisabledNegativeBtn = false
            this.dcdisabledPositiveBtn = false
          }, 1500)
        }).catch(err => {
          console.log(err)
          this.dcdisabledNegativeBtn = false
          this.dcdisabledPositiveBtn = false
        })
      } else {
        this.deleteId = value.id_surat_masuk
        this.dcMessages = `Hapus surat masuk <span class="pink--text">#${this.deleteId}</span> ?`
        this.showDC = true
      }
    },
    _clearFilter () {
      this.searchQuery = null
      this._loadData(true)
    },
    _loadData (abort) {
      if (this.datas.length === 0 || abort) {
        this.isLoading = true
        this.getSuratMasuk({ search: this.searchQuery, ...this.options })
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
