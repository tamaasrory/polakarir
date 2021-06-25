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
      <v-toolbar-title style="line-height: 1.3">
        Edit Material
        <div
          v-if="!loadingData"
          style="font-size: 11pt"
        >
          {{ material.id }}
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
                v-model="material.nama"
                label="Nama Material"
                outlined
                :rules="[rules.required]"
              />
              <v-text-field
                v-model="material.satuan"
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
      material: {
        nama: null,
        satuan: null
      },
      rules: {
        required: value => !!value || 'Tidak Boleh Kosong'
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
      return !!(this.material.nama)
    }
  },
  created () {
  },
  methods: {
    backButton () {
      this.$router.push({ name: 'material' })
    },
    postUpdate () {
      this.dcProgress = true
      this.dcdisabledNegativeBtn = true
      this.dcdisabledPositiveBtn = true
      this.dcMessages = 'Sedang Menyimpan Material...'
    }
  }
}
</script>

<style scoped>

</style>
