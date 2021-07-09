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
      <v-icon
        color="primary"
        class="mr-5"
        @click="$emit('toggle-drawer')"
        v-text="'mdi-menu'"
      />
      <v-spacer/>
      <Account/>
    </v-app-bar>
    <v-container fluid>
      <h1 class="my-2">
        Ubah Draft Template
      </h1>
      <div
        v-if="!loadingData"
        style="font-size: 11pt"
      >
        {{ template_surat.id }}
      </div>
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
              v-model="template_surat.id"
              class="outline yellow--text"
              outlined
              :rules="[rules.required]"
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
              v-model="template_surat.nama_template"
              class="outline yellow--text"
              outlined
              :rules="[rules.required]"
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
              v-model="template_surat.jenis_surat"
              class="outline yellow--text"
              outlined
              :rules="[rules.required]"
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
              <template v-slot:label>
                <v-btn depressed x-small rounded class="text-capitalize">Choose File</v-btn>
                No File Chosen
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
import {mapActions} from 'vuex'
import Dialog from '@/components/Dialog'
import Account from "@/components/default/Account";

export default {
  components: {
    Account,
    'update-dialog-confirm': Dialog
  },
  props: {
    id: {type: [String, Number], required: true}
  },
  data() {
    return {
      loadingData: true,
      template_surat: {
        id: this.id,
        id_template_surat: this.id_template_surat,
        nama_template: null,
        nip_author: null,
        url_berkas: null,
        sumber_hukum:null,
        jenis_surat:null,
        status: null,
      },
      rules: {
        required: value => !!value || 'Tidak Boleh Kosong'
      },
      showDC: false,
      dcMessages: 'Simpan Perubahan Sekarang?',
      dcProgress: false,
      dcdisabledNegativeBtn: false,
      dcdisabledPositiveBtn: false,
      dcNegativeBtn: () => {
        this.showDC = false
      },
      dcPositiveBtn: () => this.postUpdate()
    }
  },
  computed: {
    dataValidation() {
      return !!(this.template_surat.id)
    }
  },
  created() {
    this.getTemplateSuratById( {id: this.id})
      .then(data => {
        /*console.log('Error template: ' + data.nama_template)*/
        this.template_surat.nama_template = data.template_surat.nama_template ?? ''
        this.template_surat.jenis_surat = data.template_surat.jenis_surat ?? ''
        this.loadingData = false
      })
    .catch((error) => {
      this.template_surat = {
        id_template_surat: null,
        jenis_surat: null,
        nama_template: null,

      }
      console.log('Error template: ' + error)

    })
  },
  methods: {
    ...mapActions(['getTemplateSuratEdit', 'updateTemplateSurat']),
    backButton() {
      this.$router.push({name: 'template_surat'})
    },
    postUpdate() {
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
