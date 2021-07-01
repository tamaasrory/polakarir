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
      <v-toolbar-title>Surat Masuk</v-toolbar-title>
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
      <v-data-table
        :loading="isLoading"
        :headers="headerData"
        :search="searchQuery"
        :items="datas"
        :sort-by.sync="config.table.sortBy"
        :sort-desc.sync="config.table.sortDesc"
        :items-per-page="config.table.itemsPerPage"
        :page.sync="config.table.page"
        :server-items-length="serverLength"
        :options.sync="options"
        height="350pt"
        item-key="id_surat_masuk"
        class="elevation-2"
        multi-sort
        hide-default-footer
        fixed-header
        @page-count="config.table.pageCount = $event"
        @pagination="pagination=$event"
      >
        <template #item.updated_at="{item}">
          {{ item.updated_at | moment('DD MMMM YYYY HH:mm') }}
        </template>
        <template #item.aksi="{item}">
          <v-tooltip bottom>
            <template #activator="{ on, attrs }">
              <v-btn
                icon
                v-bind="attrs"
                @click="_edit(item)"
                v-on="on"
              >
                <v-icon
                  color="blue"
                >
                  mdi-circle-edit-outline
                </v-icon>
              </v-btn>
            </template>
            <span>Ubah</span>
          </v-tooltip>
          <v-tooltip
            v-if="can(['surat-masuk-delete'])"
            bottom
          >
            <template #activator="{ on, attrs }">
              <v-btn
                v-bind="attrs"
                icon
                @click="_delete(item)"
                v-on="on"
              >
                <v-icon color="pink">
                  mdi-delete
                </v-icon>
              </v-btn>
            </template>
            <span>Hapus</span>
          </v-tooltip>
          <v-tooltip bottom>
            <template #activator="{ on, attrs }">
              <v-btn
                v-bind="attrs"
                icon
                @click="_detail(item)"
                v-on="on"
              >
                <v-icon color="green">
                  mdi-file-find
                </v-icon>
              </v-btn>
            </template>
            <span>Detail</span>
          </v-tooltip>
        </template>
      </v-data-table>
      <div
        class="row align-center pb-3"
      >
        <div class="col-md-6 col-12 order-md-0 order-1 pt-0 pt-md-4">
          <v-data-footer
            class="float-left"
            :pagination="pagination"
            :prev-icon="null"
            :next-icon="null"
            :first-icon="null"
            :last-icon="null"
            :items-per-page-options="[10,15,50,100,-1]"
            :options.sync="options"
          />
        </div>
        <div class="col-md-6 col-12 order-md-1 order-0 mt-4 pb-0 pb-md-4">
          <v-pagination
            v-model="config.table.page"
            :length="config.table.pageCount"
            total-visible="7"
            circle
          />
        </div>
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
