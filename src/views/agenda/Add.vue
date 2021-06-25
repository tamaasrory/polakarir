<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div>
    <v-app-bar
      color="white"
      elevation="0"
      fixed
      app
      light
    >
      <v-icon
        color="primary"
        @click="$emit('toggle-drawer')"
        v-text="'mdi-menu'"
      />
      <v-spacer />
      <v-btn
        title="Tambah Material"
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
        Buat Agenda
      </h1>
      <div class="mt-lg-10">
        <v-row>
          <v-col cols="2">
            <v-subheader
              class="font-weight-black black--text"
            >Kegiatan</v-subheader>
          </v-col>
          <v-col cols="5">
            <v-text-field
              class="outline yellow--text"
              outlined
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row class="mt-n7">
          <v-col cols="2">
            <v-subheader
              class="font-weight-black black--text"
            >Tanggal Kegiatan</v-subheader>
          </v-col>
          <v-col cols="5">
            <v-text-field
              class="outline yellow--text"
              outlined
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row class="mt-n7">
          <v-col cols="2">
            <v-subheader
              class="font-weight-black black--text"
            >Lokasi</v-subheader>
          </v-col>
          <v-col cols="5">
            <v-text-field
              class="outline yellow--text"
              outlined
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row class="mt-n7">
          <v-col cols="2">
            <v-subheader
              class="font-weight-black black--text"
            >Status</v-subheader>
          </v-col>
          <v-col cols="5">
            <v-text-field
              class="outline yellow--text"
              outlined
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row class="mt-n7">
          <v-col cols="2">
            <v-subheader
              class="font-weight-black black--text"
            >Tujuan</v-subheader>
          </v-col>
          <v-col cols="5">
            <v-text-field
              class="outline yellow--text"
              outlined
            ></v-text-field>
          </v-col>
          <v-col>
            <v-btn
              elevation="2"
              class="cyan accent-3 text-capitalize white--text rounded-xl"
            >Pilih tujuan</v-btn>
          </v-col>
        </v-row class="mt-n7">
        <v-row>
          <v-col sm="12" lg="7" md="12" align="right">
            <v-btn
              elevation="2"
              large
              class=" cyan accent-3 text-capitalize white--text rounded-xl"
            >Simpan</v-btn>
          </v-col>
        </v-row>
      </div>
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
  name: 'Material',
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
          sortBy: ['id'],
          sortDesc: [true],
          itemsPerPage: 10,
          itemKey: 'id'
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
          text: 'ID',
          align: 'left',
          value: 'id'
        },
        { text: 'Nama', value: 'nama' },
        { text: 'Satuan', value: 'satuan' },
        { text: 'Updated', value: 'updated_at' },
        { text: '', value: 'aksi' }
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
    ...mapActions(['getMaterial', 'deleteMaterial']),
    can,
    _detail (value) {
      this.$router.push({ name: 'material_view', params: { id: value.id } })
    },
    _add () {
      this.$router.push({ name: 'material_add' })
    },
    _edit (value) {
      this.$router.push({ name: 'material_edit', params: { id: value.id } })
    },
    _delete (value) {
      if (value === true) {
        this.dcProgress = true
        this.dcdisabledNegativeBtn = true
        this.dcdisabledPositiveBtn = true
        this.dcMessages = `Sedang menghapus material`
        this.deleteMaterial(this.deleteId).then(res => {
          this._loadData(true)
          this.dcProgress = false
          this.dcMessages = `Berhasil Menghapus Material`
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
        this.deleteId = value.id
        this.dcMessages = `Hapus material <span class="pink--text">#${this.deleteId}</span> ?`
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
        this.getMaterial({ search: this.searchQuery, ...this.options })
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
