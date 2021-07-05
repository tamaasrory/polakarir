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
      <v-spacer/>
      <account/>
    </v-app-bar>
    <v-container class="px-10 pb-10">
      <h1 class="my-2">
        Template Surat
      </h1>
      <v-card>
        <v-row dense>
          <v-col cols="3" class="align-self-center mr-auto ">
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
          <v-col lg="3" align="right" class="align-self-center">
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
            ></v-text-field>

          </v-col>
          <v-col cols="1" class="align-self-lg-center" align="right">
            <v-btn
              class="mx-2"
              fab
              align="end"
              x-small
              outlined
              @click="_add()"
              style="border-width: 3px"
              color="cyan"
            >
              <v-icon dark large> mdi-plus </v-icon>
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
          <template v-slot:item.updated_at="{item}">
            {{ item.updated_at | moment('DD MMMM YYYY HH:mm') }}
          </template>
          <template v-slot:item.aksi="{item}">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
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
              <template v-slot:activator="{ on, attrs }">
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
              <template v-slot:activator="{ on, attrs }">
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
          @click="_loadData(true)"
        >
          Terapkan
        </v-btn>
      </div>
    </v-navigation-drawer>
  </div>
</template>

<script>
import {mapActions} from 'vuex'
import Dialog from '@/components/Dialog'
import {can} from '@/plugins/supports'
import Account from "@/components/default/Account";

export default {
  name: 'TemplateSurat',
  components: {
    'account': Account,
    'delete-dialog-confirm': Dialog
  },
  data() {
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
      dcNegativeBtn: () => {
        this.showDC = false
      },
      dcPositiveBtn: () => this._delete(true)
    }
  },
  computed: {
    headerData() {
      return [
        {text: 'Nomor', value: 'id_template_surat'},
        {text: 'Nama Template', value: 'nama_template'},
        {text: 'Jenis Surat', value: 'jenis_surat'},
        {text: 'Pembuat', value: 'nip_author'},
        {text: 'Tanggal Pembuatan', value: 'created_at'},
        {text: 'Validator', value: 'nip_author'},
        {text: 'Status', value: 'status'},
        {text: 'Aksi', value: 'aksi'}
      ]
    }
  },
  watch: {
    options(a, b) {
      this._loadData(true)
    }
  },
  mounted() {
    this._loadData(false) // loading data form server
  },
  methods: {
    ...mapActions(['getTemplateSurat', 'deleteTemplateSurat']),
    can,
    _detail(value) {
      this.$router.push({name: 'material_view', params: {id: value.id}})
    },
    _add() {
      this.$router.push({name: 'template_surat_add'})
    },
    _edit(value) {
      this.$router.push({name: 'template_surat_edit', params: {id: value.id_template_surat}})
    },
    _delete(value) {
      if (value === true) {
        this.dcProgress = true
        this.dcdisabledNegativeBtn = true
        this.dcdisabledPositiveBtn = true
        this.dcMessages = `Sedang menghapus template surat`
      } else {
        this.deleteId = value.id
        this.dcMessages = `Hapus material <span class="pink--text">#${this.deleteId}</span> ?`
        this.showDC = true
      }
    },
    _clearFilter() {
      this.searchQuery = null
      this._loadData(true)
    },
    _loadData(abort) {
      if (this.datas.length === 0 || abort) {
        this.isLoading = true
        this.getTemplateSurat({ add: this.filterTask, ...this.options })
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
