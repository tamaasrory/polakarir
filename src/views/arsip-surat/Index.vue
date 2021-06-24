<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="material">
    <v-app-bar color="white" elevation="0" fixed app light>
      <v-icon
        color="primary"
        class="mr-5"
        @click="$emit('toggle-drawer')"
        v-text="'mdi-menu'"
      />
      <v-spacer />
      <v-avatar class="mx-3">
        <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" />
      </v-avatar>
      <div class="mt-5">
        <h4 class="mr-5 light-blue--text accent-4">Tri Mueri Sandes</h4>
        <p class="mr-5 light-blue--text accent-1">Kasubag umum</p>
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
              <v-icon large> mdi-chevron-down </v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item v-for="(item, index) in items" :key="index">
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-app-bar>
    <v-container fluid>
      <h1 class="my-2">Daftar Arsip</h1>
      <v-card>
        <v-row>
          <v-col>
            <v-tabs centered slider-size="5">
              <v-tabs v-model="tabs" align-with-title 
              <v-tab><p class="font-weight-bold mb-n2">Unit Kerja</p>
              </v-tab>
              <v-tab><p class="font-weight-bold mb-n2">Pengguna</p></v-tab>
            </v-tabs>
          </v-col>
        </v-row>
        
      </v-card>
      <div class="row align-center pb-3">
        <div class="col-md-6 col-12 order-md-0 order-1 pt-0 pt-md-4">
          <v-data-footer
            class="float-left"
            :pagination="pagination"
            :prev-icon="null"
            :next-icon="null"
            :first-icon="null"
            :last-icon="null"
            :page-text="baris"
            :items-per-page-text="smfbsm"
            :items-per-page-options="[10, 15, 50, 100, -1]"
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
    <v-navigation-drawer v-model="toggleFp" fixed width="350" temporary right>
      <v-list-item class="grey lighten-4">
        <v-list-item-content>
          <v-list-item-title>
            <v-icon>mdi-filter-outline</v-icon> Filter
          </v-list-item-title>
        </v-list-item-content>
        <v-list-item-icon>
          <v-btn icon @click="toggleFp = !toggleFp">
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </v-list-item-icon>
      </v-list-item>

      <v-row class="px-4 py-4">
        <v-col cols="12">
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
        style="position: absolute; bottom: 0; right: 0"
      >
        <v-btn
          v-show="searchQuery"
          text
          color="primary"
          @click="_clearFilter()"
        >
          Bersihkan filter
        </v-btn>
        <v-btn color="success" @click="_loadData(true)"> Terapkan </v-btn>
      </div>
    </v-navigation-drawer>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Dialog from "@/components/Dialog";
import { canEdit } from "@/plugins/supports";

export default {
  name: "Material",
  components: {
    "delete-dialog-confirm": Dialog,
  },
  data() {
    return {
      searchQuery: "",
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
          sortBy: ["id"],
          sortDesc: [true],
          itemsPerPage: 10,
          itemKey: "id",
        },
      },

      showDC: false,
      deleteId: "",
      dcMessages: "",
      dcProgress: false,
      dcdisabledNegativeBtn: false,
      dcdisabledPositiveBtn: false,
      dcNegativeBtn: () => {
        this.showDC = false;
      },
      dcPositiveBtn: () => this._delete(true),
    };
  },
  computed: {
    headerData() {
      return [
        { text: "Nomor", value: "nama" },
        { text: "Nomor Berkas", value: "satuan" },
        { text: "Judul Berkas", value: "updated_at" },
        { text: "Klasifikasi", value: "updated_at" },
        { text: "Lokasi Fisik Berkas", value: "updated_at" },
        { text: "Aksi", value: "aksi" },
      ];
    },
  },
  watch: {
    options(a, b) {
      this._loadData(true);
    },
  },
  mounted() {
    this._loadData(false); // loading data form server
  },
  methods: {
    ...mapActions(["getMaterial", "deleteMaterial"]),
    canEdit,
    _detail(value) {
      this.$router.push({ name: "material_view", params: { id: value.id } });
    },
    _addArsip() {
      this.$router.push({ name: "arsip-surat_add" });
    },
    _edit(value) {
      this.$router.push({ name: "material_edit", params: { id: value.id } });
    },
    _delete(value) {
      if (value === true) {
        this.dcProgress = true;
        this.dcdisabledNegativeBtn = true;
        this.dcdisabledPositiveBtn = true;
        this.dcMessages = `Sedang menghapus material`;
        this.deleteMaterial(this.deleteId)
          .then((res) => {
            this._loadData(true);
            this.dcProgress = false;
            this.dcMessages = `Berhasil Menghapus Material`;
            setTimeout(() => {
              this.deleteId = "";
              this.showDC = false;
              this.dcdisabledNegativeBtn = false;
              this.dcdisabledPositiveBtn = false;
            }, 1500);
          })
          .catch((err) => {
            console.log(err);
            this.dcdisabledNegativeBtn = false;
            this.dcdisabledPositiveBtn = false;
          });
      } else {
        this.deleteId = value.id;
        this.dcMessages = `Hapus material <span class="pink--text">#${this.deleteId}</span> ?`;
        this.showDC = true;
      }
    },
    _clearFilter() {
      this.searchQuery = null;
      this._loadData(true);
    },
    _loadData(abort) {
      if (this.datas.length === 0 || abort) {
        this.isLoading = true;
        this.getMaterial({ search: this.searchQuery, ...this.options }).then(
          (data) => {
            this.datas = data.items || [];
            this.serverLength = data.total || 0;
            this.isLoading = false;
          }
        );
      } else {
        this.isLoading = false;
      }
    },
  },
};
</script>
<style>
.v-data-footer__icons-before,
.v-data-footer__icons-after {
  display: none !important;
}
</style>
