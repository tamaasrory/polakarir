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
      <v-toolbar-title>Surat Keluar</v-toolbar-title>
      <v-spacer />
      <v-btn
        v-if="canRevisi"
        icon
        @click="_edit()"
      >
        <v-icon>
          mdi-circle-edit-outline
        </v-icon>
      </v-btn>
      <v-btn
        title="Perbarui Data"
        icon
        @click="_loadData()"
      >
        <v-icon>mdi-reload</v-icon>
      </v-btn>
    </v-app-bar>
    <v-container class="white">
      <v-row>
        <v-col
          cols="12"
          md="8"
          class="mx-auto"
        >
          <div>
            <v-btn
              v-if="showBtnTeruskan"
              class="mr-2 mt-2 mb-3"
              color="#2d62ed"
              :dark="!disableActions"
              :disabled="disableActions"
              @click="showDialog.teruskan=!showDialog.teruskan"
            >
              teruskan <v-icon>mdi-share</v-icon>
            </v-btn>
            <v-menu
              v-if="showBtnTte"
              offset-y
            >
              <template #activator="{ on, attrs }">
                <v-btn
                  class="mr-2 mt-2 mb-3"
                  color="#2d62ed"
                  :dark="!disableActions"
                  :disabled="disableActions"
                  v-bind="attrs"
                  v-on="on"
                >
                  Setujui <v-icon class="ml-1">
                    mdi-draw
                  </v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item @click="">
                  <v-list-item-title>
                    Hanya Setujui
                  </v-list-item-title>
                </v-list-item>
                <v-list-item @click="showDialog.tte=true">
                  <v-list-item-title>
                    Setujui & Tanda Tangani
                  </v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
            <v-btn
              v-if="showBtnMemo"
              color="green"
              class="mt-2 mb-3"
              :dark="!disableActions"
              :disabled="disableActions"
              @click="showDialog.memo=!showDialog.memo"
            >
              Revisi <v-icon>mdi-pen</v-icon>
            </v-btn>
          </div>
          <v-card
            class="px-md-3 mt-3"
          >
            <v-card-text class="px-md-0">
              <v-row class="px-1">
                <v-col
                  cols="4"
                  md="3"
                >
                  <strong>Perihal</strong>
                </v-col>
                <v-col
                  cols="8"
                  md="9"
                >
                  <v-skeleton-loader
                    v-show="loadingData"
                    max-width="300"
                    type="text"
                  />
                  <div
                    v-show="!loadingData"
                    class="black--text"
                  >
                    {{ surat_keluar.perihal_surat }}
                  </div>
                </v-col>
                <v-col
                  cols="4"
                  md="3"
                  style="border-top: 2px solid #eee"
                >
                  <strong>Jenis Surat</strong>
                </v-col>
                <v-col
                  cols="8"
                  md="9"
                  style="border-top: 2px solid #eee"
                >
                  <v-skeleton-loader
                    v-show="loadingData"
                    max-width="300"
                    type="text"
                  />
                  <div
                    v-show="!loadingData"
                    class="black--text"
                  >
                    {{ surat_keluar.jenis_surat }}
                  </div>
                </v-col>
                <v-col
                  cols="4"
                  md="3"
                  style="border-top: 2px solid #eee"
                >
                  <strong>Urgensi</strong>
                </v-col>
                <v-col
                  cols="8"
                  md="9"
                  style="border-top: 2px solid #eee"
                >
                  <v-skeleton-loader
                    v-show="loadingData"
                    max-width="300"
                    type="text"
                  />
                  <div
                    v-show="!loadingData"
                    class="black--text"
                  >
                    {{ surat_keluar.derajat_surat }}
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
          <v-card
            class="mt-5"
            min-height="100"
          >
            <v-card-title
              class="py-2"
              style="border-bottom: 2px solid #eee;font-size: 12pt"
            >
              Isi Surat
            </v-card-title>
            <v-card-text class="py-3">
              <v-skeleton-loader
                v-show="loadingData"
                type="paragraph"
              />
              <div
                v-show="!loadingData"
              >
                {{ surat_keluar.isi_surat_ringkas || 'tidak ada ringkasan surat' }}
              </div>
            </v-card-text>
          </v-card>
          <v-card
            class="mt-5"
            min-height="150"
          >
            <v-card-title
              class="py-2"
              style="border-bottom: 2px solid #eee;font-size: 12pt"
            >
              Lampiran
            </v-card-title>
            <v-card-text class="py-3">
              <v-skeleton-loader
                v-show="loadingData"
                max-width="150"
                max-height="80"
                type="image"
              />
              <v-skeleton-loader
                v-show="loadingData"
                class="mt-2"
                max-width="150"
                type="sentences"
              />
              <div v-show="!loadingData">
                <v-menu v-if="!!surat_keluar.lampiran">
                  <template #activator="{ on, attrs }">
                    <v-card
                      class="text-center"
                      width="150"
                      v-bind="attrs"
                      v-on="on"
                    >
                      <v-card-text class="pa-1">
                        <v-icon
                          style="font-size: 70px"
                          color="primary"
                        >
                          mdi-file-word
                        </v-icon>
                      </v-card-text>
                      <v-divider />
                      <v-card-subtitle class="pa-1">
                        {{ surat_keluar.lampiran }}
                      </v-card-subtitle>
                    </v-card>
                  </template>
                  <v-list>
                    <v-list-item @click="loadDocPreview()">
                      <v-list-item-action class="mr-4">
                        <v-icon>mdi-eye</v-icon>
                      </v-list-item-action>
                      <v-list-item-title>Lihat Document</v-list-item-title>
                    </v-list-item>
                    <v-list-item
                      :href="urlSuratKeluar(surat_keluar.lampiran)"
                    >
                      <v-list-item-action class="mr-4">
                        <v-icon>mdi-cloud-download-outline</v-icon>
                      </v-list-item-action>
                      <v-list-item-title>Download</v-list-item-title>
                    </v-list-item>
                  </v-list>
                </v-menu>
                <div v-else>
                  tidak ada lampiran surat
                </div>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-dialog
      v-model="showToast"
      persistent
      max-width="360"
    >
      <v-card>
        <v-card-title class="text-h5">
          Info
        </v-card-title>
        <v-card-text
          style="font-size: 14pt"
          v-text="toastMsg"
        />
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="green darken-1"
            text
            @click="closeInfo()"
          >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="showDialog.tte"
      max-width="600"
    >
      <v-card>
        <v-card-title
          class="py-3"
          style="border-bottom: 2px solid #eee;"
        >
          Setujui & Tanda Tangani
        </v-card-title>
        <v-card-text class="pt-5 pb-0">
          <v-text-field
            v-model="tte.hash_tte"
            label="Passparse"
            outlined
            placeholder="Masukkan Passparse"
            :append-icon="showPassparse ? 'mdi-eye-off':'mdi-eye'"
            :type="showPassparse ? 'text' : 'password'"
            @click:append="showPassparse = !showPassparse"
          />
        </v-card-text>
        <v-card-actions style="background: #eee">
          <v-spacer />
          <v-btn
            :loading="loading.tte"
            :disabled="loading.tte || !(tte.hash_tte)"
            color="primary"
            class="mr-1 my-2 px-10 text-capitalize"
            large
            @click="tteSurat()"
          >
            Proses
          </v-btn>
          <v-btn
            color="error"
            class="mr-2 my-2 px-10 text-capitalize"
            large
            :disabled="loading.tte"
            @click="showDialog.tte=false"
          >
            Kembali
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="showDialog.teruskan"
      max-width="600"
    >
      <v-card>
        <v-card-title
          class="py-3"
          style="border-bottom: 2px solid #eee;"
        >
          Teruskan
        </v-card-title>
        <v-card-text class="pt-5 pb-0">
          <v-select
            v-model="teruskan.kode_jabatan_terusan"
            :items="items.teruskan"
            label="Kepada"
            outlined
            placeholder="Pilih kepada siapa akan disampaikan"
          />
          <v-textarea
            v-model="teruskan.catatan"
            rows="2"
            label="Pesan"
            outlined
            placeholder="tuliskan pesan bila dibutuhkan"
          />
        </v-card-text>
        <v-card-actions style="background: #eee">
          <v-spacer />
          <v-btn
            :loading="loading.teruskan"
            :disabled="loading.teruskan || !(teruskan.kode_jabatan_terusan)"
            color="primary"
            class="mr-1 my-2 px-10 text-capitalize"
            large
            @click="teruskanSurat()"
          >
            Proses
          </v-btn>
          <v-btn
            color="error"
            class="mr-2 my-2 px-10 text-capitalize"
            large
            :disabled="loading.teruskan"
            @click="showDialog.teruskan=false"
          >
            Kembali
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="showDialog.memo"
      max-width="600"
      persistent
    >
      <v-card>
        <v-card-title
          class="py-3"
          style="border-bottom: 2px solid #eee;"
        >
          Revisi
        </v-card-title>
        <v-card-text class="pt-5 pb-0">
          <v-select
            v-model="memo.kode_jabatan_terusan"
            :items="items.memo"
            label="Kepada"
            outlined
            placeholder="Pilih kepada siapa akan disampaikan"
          />
          <v-textarea
            v-model="memo.catatan"
            rows="2"
            label="Catatan Revisi"
            outlined
            placeholder="tuliskan revisi"
          />
        </v-card-text>
        <v-card-actions style="background: #eee">
          <v-spacer />
          <v-btn
            :loading="loading.kembalikan"
            :disabled="loading.kembalikan || !(memo.kode_jabatan_terusan && memo.catatan)"
            color="primary"
            class="mr-1 my-2 px-10 text-capitalize"
            large
            @click="kembalikanSurat()"
          >
            Proses
          </v-btn>
          <v-btn
            color="error"
            class="mr-2 my-2 px-10 text-capitalize"
            large
            :disabled="loading.kembalikan"
            @click="showDialog.memo=false"
          >
            Kembali
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="showDocPreview"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
      scrollable
    >
      <v-btn
        fab
        absolute
        right
        bottom
        class="mb-10"
        @click="showDocPreview=false"
      >
        <v-icon>mdi-close</v-icon>
      </v-btn>
      <WebViewer
        :initial-doc="docBlobPreview"
        :filename="docBlobPreviewName"
      />
    </v-dialog>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import { urlSuratKeluar } from '@/router/Path'
import { isEmpty } from '@/plugins/supports'
import WebViewer from '@/components/WebViewer'

export default {
  components: { WebViewer },
  props: {
    id: { type: [String, Number], required: true }
  },
  data () {
    return {
      loadingData: true,
      surat_keluar: {
        perihal_surat: null,
        jenis_surat: null,
        derajat_surat: null,
        isi_surat_ringkas: null,
        lampiran: null,
        nip_author: null
      },
      teruskan: {
        id_surat_keluar: this.id,
        ket: 'Disetujui',
        kode_jabatan_terusan: null,
        catatan: null
      },
      memo: {
        id_surat_keluar: this.id,
        ket: 'Ditolak',
        kode_jabatan_terusan: null,
        catatan: null
      },
      tte: {
        id_surat_keluar: this.id,
        hash_tte: null
      },
      items: { teruskan: [], memo: [] },
      showDialog: { teruskan: false, memo: false, tte: false },
      errorResponse: false,
      loading: {
        tte: false,
        teruskan: false,
        kembalikan: false
      },
      showBtnTeruskan: false,
      showBtnMemo: false,
      showBtnTte: false,
      showDocPreview: false,
      canRevisi: false,
      showPassparse: false,
      docBlobPreview: null,
      docBlobPreviewName: null,
      showToast: false,
      toastMsg: ''
    }
  },
  computed: {
    ...mapState(['user']),
    disableActions () {
      return this.loadingData || this.errorResponse
    }
  },
  created () {
    this._loadData()
  },
  methods: {
    ...mapActions([
      'getSuratKeluarById',
      'validasiSuratKeluar',
      'tteSuratKeluar',
      'downloadSurat'
    ]),
    urlSuratKeluar,
    loadDocPreview () {
      this.downloadSurat(this.id).then(d => {
        if (d.result) {
          this.docBlobPreviewName = this.surat_keluar.lampiran
          this.docBlobPreview = d.data
          this.showDocPreview = true
        }
      })
    },
    backButton () {
      this.$router.back()
    },
    closeInfo () {
      this.backButton()
    },
    tteSurat () {
      this.loading.tte = true
      this.tteSuratKeluar(this.tte).then(d => {
        this.loading.tte = false
        this.showToast = true
        this.toastMsg = d
        this.showDialog.tte = false
      })
    },
    teruskanSurat () {
      this.loading.teruskan = true
      this.validasiSuratKeluar(this.teruskan).then(d => {
        this.loading.teruskan = false
        this.showToast = true
        this.toastMsg = d
        this.showDialog.teruskan = false
      })
    },
    kembalikanSurat () {
      this.loading.kembalikan = true
      this.validasiSuratKeluar(this.memo).then(d => {
        this.loading.kembalikan = false
        this.showToast = true
        this.toastMsg = d
        this.showDialog.memo = false
      })
    },
    _loadData () {
      this.loadingData = true
      this.getSuratKeluarById({ id: this.id })
        .then(data => {
          this.surat_keluar = isEmpty(data.surat_keluar, {})
          this.items.teruskan = isEmpty(data.teruskan, [])
          this.items.memo = isEmpty(data.memo, [])
          this.showBtnTeruskan = isEmpty(data.showBtnTeruskan, false)
          this.showBtnMemo = isEmpty(data.showBtnMemo, false)
          this.showBtnTte = isEmpty(data.showBtnTte, false)
          this.canRevisi = isEmpty(data.canRevisi, false)
          this.loadingData = false
        })
        .catch(() => {
          this.surat_keluar = {}
          this.items.teruskan = []
          this.items.memo = []
          this.loadingData = false
          this.errorResponse = true
        })
    },
    _edit () {
      this.$router.push({ name: 'surat_keluar_edit', params: { id: this.id } })
    }
  }
}
</script>

<style scoped>
  .v-label {
    font-size: 19px !important;
  }

  .v-text-field > .v-input__control > .v-input__slot::after {
    content: none !important;
  }
</style>
