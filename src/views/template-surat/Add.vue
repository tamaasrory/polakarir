<template>
  <div class="template">
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
        Tambah Draft Template
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
              v-model="template_surat.jenis_surat"
              :items="items.jenis_surat"
              label="Jenis Surat"
              clearable
              outlined
              :rules="[rules.required]"
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
import {mapActions} from 'vuex'
import Dialog from '@/components/Dialog'
import {can, isEmpty} from '@/plugins/supports'
import Account from "@/components/default/Account";
import _ from 'lodash';

export default {
  name: 'Add-Template',
  components: {
    'account': Account,
    'dialog-confirm': Dialog
  },
  data() {
    return {
      searchQuery: '',
      toggleFp: false,
      isLoading: true,
      datas: [],

      template_surat: {
        nip_author: null,
        jenis_surat: null,
        nama_template: null,
        sumber_hukum: null,
        status: null,
        draf: null,
        id_template_surat: null
      },

      statusItems:['publish','draft'],

      schema: {
        nip_author: 'required',
        nama_template: 'required'
      },

      items: { jenis_surat: []},
      rules: {
        required: v => {
          v = isEmpty(v)
          return !v || 'Tidak Boleh Kosong'
        }
      },
      showDC: false,
      deleteId: '',
      dcMessages: 'Simpan Template Surat Baru Sekarang?',
      dcProgress: false,
      dcdisabledNegativeBtn: false,
      dcdisabledPositiveBtn: false,
      dcNegativeBtn: () => {
        this.showDC = false
      },
      dcPositiveBtn: () => this.postAdd()
    }
  },
  computed: {
    dataValidation() {
      return inputValidator(this.schema, this.rules, this.template_surat)
    }
  },
  created () {
    this.createTemplateSurat().then(data => {
      this.items.jenis_surat = isEmpty(data.jenis_surat, [])
    })
  },
  methods: {
    ...mapActions(['addTemplateSurat','createTemplateSurat']),
    backButton() {
      this.$router.push({
        name: 'template_surat'
      })
    },
    postAdd() {
      let template_surat = new FormData();
      _.each(this.template_surat, (value, key) => {
        template_surat.append(key, value)
      })
      this.dcProgress = true
      this.dcdisabledNegativeBtn = true
      this.dcdisabledPositiveBtn = true
      this.dcMessages = 'Tunggu Sebentar, Sedang Menyimpan Template Surat Baru...'
      this.addTemplateSurat(template_surat).then((res) => {
        this.dcProgress = false
        this.dcMessages = res.msg
        setTimeout(() => {
          this.showDC = false
          this.$router.push({name: 'template_surat'})
          this.dcMessage = 'Simpan Template Surat Baru Sekarang?'
        }, 2000)
      })
    },
  }
}
</script>
<style>
.v-data-footer__icons-before, .v-data-footer__icons-after {
  display: none !important;
}
</style>
