<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div>
    <v-app-bar
      color="white"
      fixed
      app
      light
    >
      <v-btn
        icon
        dark
        @click="backButton"
      >
        <v-icon color="primary">
          mdi-arrow-left
        </v-icon>
      </v-btn>
      <v-toolbar-title style="line-height: 1.3">
        Edit Jenis Surat
        <div
          v-if="!loadingData"
          style="font-size: 11pt"
        >
          {{ jenis_surat.id }}
        </div>
        <v-skeleton-loader
          v-else
          ref="skeleton"
          type="text"
          max-width="100%"
        />
      </v-toolbar-title>
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
                v-model="jenis_surat.nama_jenis_surat"
                label="Nama Jenis Surat"
                outlined
                :rules="[rules.required]"
              />
              <v-text-field
                v-model="jenis_surat.kode_surat"
                label="Kode Surat"
                outlined
                :rules="[rules.required]"
              />

              <v-btn
                color="green"
                large
                :dark="!dataValidation"
                :disabled="dataValidation"
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
    <update-dialog-confirm
      :show-dialog="showDC"
      :negative-button="dcNegativeBtn"
      :positive-button="dcPositiveBtn"
      :disabled-negative-btn="dcdisabledNegativeBtn"
      :disabled-positive-btn="dcdisabledPositiveBtn"
      :title="'Perbarui'"
      :message="dcMessages"
      :progress="dcProgress"
    />
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import Dialog from '@/components/Dialog'
import { inputValidator, isEmpty } from '@/plugins/supports'

export default {
  components: {
    'update-dialog-confirm': Dialog
  },
  props: {
    id: { type: [String, Number], required: true }
  },
  data () {
    return {
      loadingData: true,
      jenis_surat: {
        nama_jenis_surat: null,
        kode_surat: null
      },
      schema: {
        kode_surat: 'required',
        nama_jenis_surat: 'required'
      },
      rules: {
        required: v => {
          v = isEmpty(v)
          return !v || 'Tidak Boleh Kosong'
        }
      },
      showDC: false,
      dcMessages: 'Simpan Perubahan Sekarang?',
      dcProgress: false,
      dcdisabledNegativeBtn: false,
      dcdisabledPositiveBtn: false,
      dcNegativeBtn: () => { this.showDC = false },
      dcPositiveBtn: () => this.postUpdate()
    }
  },
  computed: {
    dataValidation () {
      return inputValidator(this.schema, this.rules, this.jenis_surat)
    }
  },
  created () {
    this.getJenisSuratById({ id: this.id })
      .then(data => {
        this.jenis_surat = data || {}
        this.loadingData = false
      })
      .catch((error) => {
        this.jenis_surat = {}
        console.log('Error : ' + error)
      })
  },
  methods: {
    ...mapActions(['getJenisSuratById', 'updateJenisSurat']),
    backButton () {
      this.$router.push({ name: 'jenis_surat' })
    },
    postUpdate () {
      this.dcProgress = true
      this.dcdisabledNegativeBtn = true
      this.dcdisabledPositiveBtn = true
      this.dcMessages = 'Sedang Menyimpan Jenis Surat...'

      this.updateJenisSurat(this.jenis_surat).then((res) => {
        this.dcMessages = 'Berhasil Memperbarui Jenis Surat'
        this.dcProgress = false
        setTimeout(() => {
          this.showDC = false
          this.dcdisabledNegativeBtn = false
          this.dcdisabledPositiveBtn = false
          this.$router.push({ name: 'jenis_surat' })
          this.dcMessages = 'Simpan Perubahan Sekarang?'
        }, 1500)
      })
    }
  }
}
</script>

<style scoped>

</style>
