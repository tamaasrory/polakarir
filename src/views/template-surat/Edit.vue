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
      <account/>
    </v-app-bar>
    <v-container fluid>
      <h1 class="my-2">
        Ubah Draft Template
      </h1>
      <div class="mt-lg-10">
        <v-row>
          <v-col cols="2">
            <v-subheader
              class="font-weight-black black--text"
            >NIP Author
            </v-subheader>
          </v-col>
          <v-col cols="5">
            <v-text-field
              v-model="template_surat.nip_author"
              class="outline yellow--text"
              outlined
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="2" class="mt-n7">
            <v-subheader
              class="font-weight-black black--text"
            >Jenis Surat
            </v-subheader>
          </v-col>
          <v-col cols="5" class="mt-n7">
            <!--            <v-text-field
                          v-model="template_surat.jenis_surat"
                          class="outline yellow&#45;&#45;text"
                          outlined
                        ></v-text-field>-->
            <v-autocomplete
              v-model="template_surat.id_jenis_surat"
              :items="items.jenis_surat"
              label="Jenis Surat"
              clearable
              outlined

            />
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
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row class="mt-n7">
          <v-col cols="2">
            <v-subheader
              class="font-weight-black black--text"
            >Sumber Hukum
            </v-subheader>
          </v-col>
          <v-col cols="5">
            <v-text-field
              v-model="template_surat.sumber_hukum"
              class="outline yellow--text"
              outlined
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row class="mt-n7">
          <v-col cols="2">
            <v-subheader
              class="font-weight-black black--text"
            >Status
            </v-subheader>
          </v-col>
          <v-col cols="5">
            <v-select
              v-model="template_surat.status"
              :items="statusItems"
              class="outline yellow--text"
              outlined
            ></v-select>
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
              v-model="template_surat.draf"
              prepend-icon=""
              outlined
              solo>
              <template v-slot:label>
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
              @click="showDC = true"
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
import {isEmpty} from "@/plugins/supports";
import _ from 'lodash';

export default {
  components: {
    'account': Account,
    'update-dialog-confirm': Dialog
  },
  props: {
    id: {type: [String, Number], required: true}
  },
  data() {
    return {
      loadingData: true,
      template_surat: {
        nama_template: null,
        nip_author: null,
        id_jenis_surat: 'Instruksi',
        sumber_hukum: null,
        status: null,
        draf: null,
        id_template_surat: null
      },
      statusItems:['publish','draft'],
      items: { jenis_surat: []},
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
      //return !!(this.template_surat.id)
      return inputValidator(this.rules, this.template_surat)
    }
  },
  created() {
    this.getTemplateSuratEdit( {id: this.id})
      .then(data => {
        //this.template_surat.id_template_surat = this.id
        this.template_surat = data
        this.loadingData = false
      })
    .catch((error) => {
      this.template_surat = {
        nama_template: null,
        id_template_surat: null,
        jenis_surat: null,
        nip_author: null,
        sumber_hukum: null,
        status: null

      }
      console.log('Error template: ' + error)

    })

    this.createTemplateSurat().then(data => {
      this.items.jenis_surat = isEmpty(data.jenis_surat, [])
    })
  },
  methods: {
    ...mapActions(['getTemplateSuratEdit','updateTemplateSurat','createTemplateSurat']),
    backButton() {
      this.$router.push({name: 'template_surat'})
    },
    postUpdate() {
      let template_surat = new FormData();
      _.each(this.template_surat, (value, key) => {
        template_surat.append(key, value)
      })
      this.dcProgress = true
      this.dcdisabledNegativeBtn = true
      this.dcdisabledPositiveBtn = true
      this.dcMessages = 'Sedang Menyimpan Template Surat...'
      this.updateTemplateSurat(template_surat).then((res) => {
        this.dcMessages = 'Berhasil Memperbaharui Template Surat'
        this.dcProgress = false
        //this.dcMessages = res.msg
        setTimeout(() => {
          this.showDC = false
          this.dcdisabledNegativeBtn = false
          this.dcdisabledPositiveBtn = false
          this.$router.push({name: 'template_surat'})
          this.dcMessages = 'Simpan Perubahan Sekarang?'
        }, 1500)
      })
    }
  }
}
</script>

<style scoped>

</style>
