<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div>
    <v-app-bar
      fixed
      dark
      color="primary"
          >
      <v-btn
        icon
        dark
        @click="backButton"
      >
        <v-icon color="primary">mdi-arrow-left</v-icon>
      </v-btn>
      <v-toolbar-title>Surat Masuk Baru</v-toolbar-title>
    </v-app-bar>
    <v-container class="white">
      <v-row class="py-0 py-md-3">
        <v-col
          cols="12"
          md="6"
          class="mx-auto"
        >
          <v-row>
            <v-col
              cols="12"
              md="12"
            >
              <v-text-field
                v-model="surat_masuk.nama"
                label="Nama Surat Masuk"
                outlined
                :rules="[rules.required]"
              />
              <v-text-field
                v-model="surat_masuk.satuan"
                label="Satuan"
                outlined
                :rules="[rules.required]"
              />

              <v-btn
                color="green"
                large
                :dark="dataValidation"
                :disabled="!dataValidation"
                @click="showDC = true"
              >
                <v-icon color="white">
                  mdi-check
                </v-icon>
                SIMPAN
              </v-btn>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
    <dialog-confirm
      :show-dialog="showDC"
      :negative-button="dcNegativeBtn"
      :positive-button="dcPositiveBtn"
      :disabled-negative-btn="dcdisabledNegativeBtn"
      :disabled-positive-btn="dcdisabledPositiveBtn"
      :progress="dcProgress"
      :title="'Simpan'"
      :message="dcMessages"
    />
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import Dialog from '@/components/Dialog'

export default {
  components: {
    'dialog-confirm': Dialog
  },
  data () {
    return {
      loadingData: true,
      dataValidation: true,
      surat_masuk: {
        nama: null,
        satuan: null
      },
      rules: {
        required: value => !!value || 'Tidak Boleh Kosong'
      },
      showDC: false,
      dcMessages: 'Simpan Surat Masuk Baru Sekarang?',
      dcProgress: false,
      dcdisabledNegativeBtn: false,
      dcdisabledPositiveBtn: false,
      dcNegativeBtn: () => { this.showDC = false },
      dcPositiveBtn: () => this.postAdd()
    }
  },
  computed: {
  },
  methods: {
    ...mapActions(['addSuratMasuk']),
    backButton () {
      this.$router.push({ name: 'surat_masuk' })
    },
    postAdd () {
      this.dcProgress = true
      this.dcdisabledNegativeBtn = true
      this.dcdisabledPositiveBtn = true
      this.dcMessages = 'Tunggu Sebentar, Sedang Menyimpan Surat Masuk Baru...'
      this.addSuratMasuk(this.surat_masuk).then((res) => {
        this.dcProgress = false
        this.dcMessages = 'Berhasil Menyimpan Surat Masuk Baru'
        setTimeout(() => {
          this.showDC = false
          this.$router.push({ name: 'surat_masuk' })
          this.dcMessages = 'Simpan Surat Masuk Baru Sekarang?'
        }, 1500)
      })
    }
  }
}
</script>

<style scoped>

</style>
