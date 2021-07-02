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
          <div class="pt-2 pb-5">
            <v-btn
              class="mr-2"
              color="#2d62ed"
              :dark="!disableActions"
              :disabled="disableActions"
              @click="showDialog.teruskan=!showDialog.teruskan"
            >
              teruskan <v-icon>mdi-share</v-icon>
            </v-btn>
            <v-btn
              color="green"
              :dark="!disableActions"
              :disabled="disableActions"
              @click="showDialog.memo=!showDialog.memo"
            >
              memo <v-icon>mdi-pen</v-icon>
            </v-btn>
          </div>
          <v-card
            class="px-md-3"
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
                    <v-list-item @click="">
                      <v-list-item-action class="mr-4">
                        <v-icon>mdi-cloud-upload</v-icon>
                      </v-list-item-action>
                      <v-list-item-title>Ganti File</v-list-item-title>
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
            v-model="teruskan.kepada"
            :items="items.teruskan"
            label="Kepada"
            outlined
            placeholder="Pilih kepada siapa akan disampaikan"
          />
          <v-textarea
            v-model="teruskan.pesan"
            rows="2"
            label="Pesan"
            outlined
            placeholder="tuliskan pesan bila dibutuhkan"
          />
        </v-card-text>
        <v-card-actions style="background: #eee">
          <v-spacer />
          <v-btn
            color="primary"
            class="mr-1 my-2 px-10 text-capitalize"
            large
          >
            Proses
          </v-btn>
          <v-btn
            color="error"
            class="mr-2 my-2 px-10 text-capitalize"
            large
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
    >
      <v-card>
        <v-card-title
          class="py-3"
          style="border-bottom: 2px solid #eee;"
        >
          Memo
        </v-card-title>
        <v-card-text class="pt-5 pb-0">
          <v-select
            v-model="memo.kepada"
            :items="items.memo"
            label="Kepada"
            outlined
            placeholder="Pilih kepada siapa akan disampaikan"
          />
          <v-textarea
            v-model="memo.pesan"
            rows="2"
            label="Pesan"
            outlined
            placeholder="tuliskan pesan bila dibutuhkan"
          />
        </v-card-text>
        <v-card-actions style="background: #eee">
          <v-spacer />
          <v-btn
            color="primary"
            class="mr-1 my-2 px-10 text-capitalize"
            large
          >
            Proses
          </v-btn>
          <v-btn
            color="error"
            class="mr-2 my-2 px-10 text-capitalize"
            large
            @click="showDialog.memo=false"
          >
            Kembali
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { urlSuratKeluar } from '@/router/Path'

export default {
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
        lampiran: null
      },
      teruskan: {
        kepada: null,
        pesan: null,
        ket: null,
        kode_jabatan_terusan: null,
        catatan: null
      },
      memo: {
        kepada: null,
        pesan: null,
        ket: null,
        kode_jabatan_terusan: null,
        catatan: null
      },
      items: { teruskan: [], memo: [] },
      showDialog: { teruskan: false, memo: false, lampiran: false },
      errorResponse: false
    }
  },
  computed: {
    disableActions () {
      return this.loadingData || this.errorResponse
    }
  },
  created () {
    this._loadData()
  },
  methods: {
    ...mapActions(['getSuratKeluarById']),
    urlSuratKeluar,
    backButton () {
      this.$router.push({ name: 'surat_keluar' })
    },
    _loadData () {
      this.loadingData = true
      this.getSuratKeluarById({ id: this.id })
        .then(data => {
          this.surat_keluar = data || {}
          this.loadingData = false
        })
        .catch(() => {
          this.surat_keluar = {}
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
