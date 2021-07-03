<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="material">
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
      <v-avatar class="mx-3">
        <img
          src="https://cdn.vuetifyjs.com/images/john.jpg"
          alt="John"
        >
      </v-avatar>
      <div class="mt-5">
        <h4 class="mr-5 light-blue--text accent-4">
          Tri Mueri Sandess
        </h4>
        <p class="mr-5 light-blue--text accent-1">
          Kasubag umum
        </p>
      </div>
      <div class="text-center">
        <v-menu offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              fab
              text
              small
              color="light-blue accent-4"
              v-bind="attrs"
              v-on="on"
            >
              <v-icon
                large
              >
                mdi-chevron-down
              </v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item
              v-for="(item, index) in items"
              :key="index"
            >
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-app-bar>
    <v-container fluid>
      <h1 class="my-2">
        Tambah Draft Template
      </h1>
      <div class="mt-lg-10">
        <v-row>
          <v-col cols="2">
            <v-subheader
              class="font-weight-black black--text"
            >Jenis Surat
            </v-subheader>
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
            >Nama Template
            </v-subheader>
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
            >File Template
            </v-subheader>
          </v-col>
          <v-col cols="5">
            <v-file-input
              prepend-icon=""
              outlined
              solo>
              <template v-slot:label >
                <v-btn depressed x-small rounded class="text-capitalize">Choose File</v-btn>
                No File Chosen
                </v-icon>
              </template>
            </v-file-input>
          </v-col>
        </v-row>
        <v-row>
          <v-col sm="12" lg="7" md="12" align="right">
            <v-btn
              elevation="2"
              large
              class=" cyan accent-3 text-capitalize white--text rounded-xl"
            >Simpan
            </v-btn>
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

export default {
  name: 'Material',
  components: {
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
        {
          text: 'ID',
          align: 'left',
          value: 'id'
        },
        {text: 'Nama', value: 'nama'},
        {text: 'Satuan', value: 'satuan'},
        {text: 'Updated', value: 'updated_at'},
        {text: '', value: 'aksi'}
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
    can,
    _detail(value) {
      this.$router.push({name: 'material_view', params: {id: value.id}})
    },
    _addTujuan() {
      this.$router.push({name: 'tujuan_add'})
    },
    _add() {
      this.$router.push({name: 'material_add'})
    },
    _edit(value) {
      this.$router.push({name: 'material_edit', params: {id: value.id}})
    },
    _delete(value) {
      if (value === true) {
        this.dcProgress = true
        this.dcdisabledNegativeBtn = true
        this.dcdisabledPositiveBtn = true
        this.dcMessages = `Sedang menghapus material`
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
