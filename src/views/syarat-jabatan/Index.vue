<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="template_surat">
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
      <v-toolbar-title>Syarat Jabatan</v-toolbar-title>
      <v-spacer />
      <!--      <account/>-->
    </v-app-bar>
    <v-container class="px-10 pb-10">
      <v-card>
        <v-row dense>
          <v-col>
            <v-tabs
              v-if="(user.sinergi)"
              centered
              slider-size="5"
            >
              <v-tab
                dense
                @click="_loadData(true,1)"
              >
                <p class="font-weight-bold mb-n2 text-capitalize">
                  Struktural
                </p>
              </v-tab>
              <v-tab
                dense
                @click="_loadData(true,2)"
              >
                <p class="font-weight-bold mb-n2 text-capitalize">
                  Fungsional
                </p>
              </v-tab>
            </v-tabs>
            <v-divider class="mt-2" />
          </v-col>
        </v-row>
        <v-row dense>
          <v-col
            cols="3"
            class="align-self-center mr-auto "
          >
            <v-data-footer
              :pagination="pagination"
              :prev-icon="null"
              :next-icon="null"
              :first-icon="null"
              :last-icon="null"
              items-per-page-text="Show"
              :items-per-page-options="[10, 15, 50, 100, -1]"
              :options.sync="options"
            />
          </v-col>
          <v-col
            lg="3"
            align="right"
            class="align-self-center"
          >
            <v-text-field
              v-model="searchQuery"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              rounded
              dense
              class="shrink"
              outlined
              hide-details
              @keyup.enter.native="_loadData(true)"
              @click:append="_loadData(true)"
            />
          </v-col>

          <v-col
            cols="1"
            class="align-self-lg-center"
            align="right"
          >
            <v-btn
              v-if="can(['template-surat-create'])"
              class="mx-2"
              fab
              align="end"
              x-small
              outlined
              style="border-width: 3px"
              color="cyan"
              @click="_add()"
            >
              <v-icon
                dark
                large
              >
                mdi-plus
              </v-icon>
            </v-btn>
          </v-col>
        </v-row>

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
          item-key="id"
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
                  @click="_download(item)"
                  v-on="on"
                >
                  <v-icon
                    color="blue"
                  >
                    mdi-download
                  </v-icon>
                </v-btn>
              </template>
              <span>Download</span>
            </v-tooltip>
            <v-tooltip
              v-if="can(['template-surat-edit'])"
              bottom
            >
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
              v-if="can(['template-surat-delete'])"
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
            <!--            <v-tooltip v-if="can(['template-surat-edit'])" bottom>-->
            <!--              <template v-slot:activator="{ on, attrs }">-->
            <!--                <v-btn-->
            <!--                  v-bind="attrs"-->
            <!--                  icon-->
            <!--                  @click="_detail(item)"-->
            <!--                  v-on="on"-->
            <!--                >-->
            <!--                  <v-icon color="green">-->
            <!--                    mdi-file-find-->
            <!--                  </v-icon>-->
            <!--                </v-btn>-->
            <!--              </template>-->
            <!--              <span>Detail</span>-->
            <!--            </v-tooltip>-->
          </template>
        </v-data-table>
      </v-card>
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
    <download-dialog-confirm
      :show-dialog="showDW"
      :negative-button="dwNegativeBtn"
      :positive-button="dwPositiveBtn"
      :disabled-negative-btn="dwdisabledNegativeBtn"
      :disabled-positive-btn="dwdisabledPositiveBtn"
      :progress="dwProgress"
      :title="dwTitle"
      :message="dwMessages"
    />
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
            <v-icon>mdi-filter-outline</v-icon>
            Filter
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
          @click="_loadData(true,0)"
        >
          Terapkan
        </v-btn>
      </div>
    </v-navigation-drawer>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import Dialog from '@/components/Dialog'
import { can } from '@/plugins/supports'
import Account from '@/components/default/Account'

export default {
  name: 'TemplateSurat',
  components: {
    account: Account,
    'delete-dialog-confirm': Dialog,
    'download-dialog-confirm': Dialog
  },
  data () {
    return {
      id_opd_active: -1,
      template_opd: 'Template Badan Penelitan dan Pengembangan',
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
          sortBy: ['id_syarat_jabatan'],
          sortDesc: [false],
          itemsPerPage: 10,
          itemKey: 'id_syarat_jabatan'
        }
      },

      showDW: false,
      downloadId: '',
      namaTemplate: '',
      dwMessages: '',
      dwProgress: false,
      dwdisabledNegativeBtn: false,
      dwdisabledPositiveBtn: false,
      dwNegativeBtn: () => {
        this.showDW = false
      },
      dwPositiveBtn: () => this._download(true),

      showDC: false,
      dwTitle: '',
      deleteId: '',
      dcMessages: '',
      dcProgress: false,
      dcdisabledNegativeBtn: false,
      dcdisabledPositiveBtn: false,
      dcNegativeBtn: () => {
        this.showDC = false
      },
      dcPositiveBtn: () => this._delete(true)
    }
  },
  computed: {
    ...mapState(['user']),
    headerData () {
      if (this.user.sinergi) {
        return [
          { text: 'Syarat Jabatan', value: 'nama_syarat' },
          { text: 'Jenis Jabatan', value: 'jenis_jabatan' },
          { text: 'Aksi', value: 'aksi' }
        ]
      } else {
        return [
          { text: 'Syarat Jabatan', value: 'nama_syarat' },
          { text: 'Jenis Jabatan', value: 'jenis_jabatan' },
          { text: 'Aksi', value: 'aksi' }
        ]
      }
    }

  },
  watch: {
    options (a, b) {
      this._loadData(true, this.id_opd_active)
    },
    search () {
      this.getTemplateSurat()
    }

  },
  mounted () {
    this._loadData(false, this.id_opd_active) // loading data form server
    this._loadPengajuan(false) // loading data form server
  },
  methods: {
    ...mapActions(['getSyaratJabatan', 'deleteTemplateSurat', 'downloaTemplateSurat', 'downloadTemplateSurat', 'updateTemplateSurat']),
    can,
    goToSuratAjukan () {
      this.$router.push({ name: 'template_surat_ajukan' })
    },
    goToSuratAjukanView () {
      this.$router.push({ name: 'template_surat_ajukan_view' })
    },
    _detail (value) {
      this.$router.push({ name: 'material_view', params: { id: value.id } })
    },
    _add () {
      this.$router.push({ name: 'syarat_jabatan_add' })
    },
    _download: function (value) {
      if (value === true) {
        // this.dwProgress = true
        // this.dwdisabledNegativeBtn = true
        // this.dwdisabledPositiveBtn = true
        // this.dwMessages = `Sedang mendownload template surat`
        this.downloadTemplateSurat({ nama: this.namaTemplate, id: this.downloadId }).then(res => {
          // this._loadData(true)
          // this.dwProgress = false
          // this.dwMessages = 'Berhasil mendownload template surat'
          setTimeout(() => {
            this.downloadId = ''
            this.showDW = false
            this.dwdisabledNegativeBtn = false
            this.dwdisabledPositiveBtn = false
          })
        }).catch(err => {
          console.log(err)
          this.dwdisabledNegativeBtn = false
          this.dwdisabledPositiveBtn = false
        })
      } else {
        this.downloadId = value.id_template_surat
        this.namaTemplate = value.nama_template
        this.dwTitle = 'Download '
        this.dwMessages = 'Download Syarat Jabatan sekarang'
        this.showDW = true
      }
    },
    _edit (value) {
      this.$router.push({ name: 'template_surat_edit', params: { id: value.id_template_surat } })
    },
    _delete (value) {
      if (value === true) {
        this.dcProgress = true
        this.dcdisabledNegativeBtn = true
        this.dcdisabledPositiveBtn = true
        this.dcMessages = 'Sedang menghapus template surat'
        this.deleteTemplateSurat(this.deleteId).then(res => {
          this._loadData(true, this.id_opd_active)
          this.dcProgress = false
          this.dcMessages = 'Berhasil menghapus template surat'
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
        this.deleteId = value.id_template_surat
        this.dcMessages = `Hapus template <span class="pink--text">#${this.deleteId}</span> ?`
        this.showDC = true
      }
    },
    _clearFilter () {
      this.searchQuery = null
      this._loadData(true, this.id_opd_active)
    },
    _loadData (abort, opd) {
      if (this.user.sinergi) {
        this.id_opd_active = opd
        this.options.search = `kode_jabatan:${this.id_opd_active}`
      }
      if (this.datas.length === 0 || abort) {
        this.isLoading = true
        this.getSyaratJabatan({ search: this.searchQuery, add: this.filterTask, ...this.options })
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
.v-data-footer__icons-before, .v-data-footer__icons-after {
  display: none !important;
}
</style>
