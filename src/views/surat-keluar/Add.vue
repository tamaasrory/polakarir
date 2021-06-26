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
      <v-toolbar-title>Buat Surat Keluar</v-toolbar-title>
    </v-app-bar>
    <v-container class="white">
      <v-row class="py-6 py-md-8 px-2">
        <v-col
          cols="12"
          md="8"
          class="py-0"
        >
          <v-autocomplete
            v-model="surat_keluar.id_jenis_surat"
            :items="items.jenis_surat"
            label="Jenis Surat"
            clearable
            outlined
            :rules="[rules.required]"
          />
        </v-col>
        <v-col
          cols="12"
          md="4"
          class="py-0"
        >
          <v-btn
            x-large
            color="#2d62ed"
            dark
            block
            @click="tmp.showDialogTujuan=true"
          >
            Tujuan Surat
          </v-btn>
        </v-col>
        <v-col
          cols="12"
          md="4"
          class="py-0"
        >
          <span>Kategori Surat</span>
          <v-radio-group
            v-model="surat_keluar.kategori_surat"
            class="mt-2"
            row
          >
            <v-radio
              class="fs-14"
              label="Internal"
              value="internal"
            />
            <v-radio
              class="fs-14"
              label="Eksternal"
              value="eksternal"
            />
          </v-radio-group>
        </v-col>
        <v-col
          cols="12"
          md="4"
          class="py-0"
        >
          <span>Karakteristik Surat</span>
          <v-radio-group
            v-model="surat_keluar.karakteristik_surat"
            class="mt-2"
            row
          >
            <v-radio
              class="fs-14"
              label="Biasa"
              value="biasa"
            />
            <v-radio
              class="fs-14"
              label="Rahasia"
              value="rahasia"
            />
            <v-radio
              class="fs-14"
              label="Sangat Rahasia"
              value="sangat rahasia"
            />
          </v-radio-group>
        </v-col>
        <v-col
          cols="12"
          md="4"
          class="py-0"
        >
          <span>Derajat Surat</span>
          <v-radio-group
            v-model="surat_keluar.derajat_surat"
            class="mt-2"
            row
          >
            <v-radio
              class="fs-14"
              label="Biasa"
              value="biasa"
            />
            <v-radio
              class="fs-14"
              label="Segera"
              value="segera"
            />
            <v-radio
              class="fs-14"
              label="Sangat Segera"
              value="sangat segera"
            />
          </v-radio-group>
        </v-col>
        <v-col
          cols="12"
          md="8"
          class="py-0"
        >
          <v-text-field
            v-model="surat_keluar.perihal_surat"
            label="Perihal Surat"
            outlined
          />
        </v-col>
        <v-col
          cols="12"
          md="4"
          class="py-0"
        >
          <v-file-input
            v-model="surat_keluar.lampiran"
            label="Lampiran"
            prepend-inner-icon="mdi-paperclip"
            :prepend-icon="null"
            outlined
          />
        </v-col>
        <v-col
          cols="12"
          md="12"
          class="py-0"
        >
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
    </v-container>
    <v-dialog
      v-model="tmp.showDialogTujuan"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-toolbar
          dark
          color="primary"
        >
          <v-btn
            icon
            dark
            @click="tmp.showDialogTujuan = false"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Tujuan Surat</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn
              dark
              text
              @click="tmp.showDialogTujuan = false"
            >
              Simpan
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-container fluid>
            <v-row>
              <v-col
                cols="12"
                md="12"
                class="pt-7 pt-md-6 pb-0"
              >
                <v-autocomplete
                  v-model="surat_keluar.id_opd"
                  :items="items.opd"
                  label="OPD"
                  outlined
                  :rules="[rules.required]"
                  :disabled="tmp.loadingOpd"
                  @change="onChangeOpd"
                />
              </v-col>
              <v-col
                v-if="tmp.loadingOpd"
                class="pt-0 pb-5 text-center"
                md="12"
              >
                <div
                  style="background-color: #fff"
                  class="py-3"
                >
                  <v-progress-circular
                    :indeterminate="tmp.loadingOpd"
                    color="primary"
                    class="mr-2"
                  />
                  Sedang Memuat Data...
                </div>
              </v-col>
              <v-col
                v-show="tmp.opd_selected"
                cols="12"
                md="12"
                class="pb-0"
              >
                <v-btn
                  class="float-right"
                  x-small
                  text
                  style="margin-top: -36px;"
                  @click="colSize.expand?collapse():expand()"
                >
                  {{ colSize.expand?'kecilkan&nbsp;':'perluas&nbsp;' }}
                  <v-icon
                    small
                    color="primary"
                  >
                    {{ 'mdi-arrow-'+(colSize.expand?'collapse':'expand') }}
                  </v-icon>
                </v-btn>
                <v-row>
                  <v-col
                    :cols="colSize.col"
                    :sm="colSize.sm"
                    :md="colSize.md"
                    class="py-0"
                  >
                    <v-autocomplete
                      v-model="tmp.jabatan[surat_keluar.id_opd]"
                      :items="items.jabatan"
                      label="Pilih Berdasarkan Jabatan"
                      outlined
                      multiple
                      deletable-chips
                      clearable
                      @change="onChangeJabatan"
                    >
                      <template #prepend-item>
                        <v-list-item
                          ripple
                          @click="togglejabatan()"
                        >
                          <v-list-item-action>
                            <v-icon :color="tmp.jabatan[surat_keluar.id_opd].length > 0 ? 'indigo darken-4' : ''">
                              {{ toggleIconJabatan }}
                            </v-icon>
                          </v-list-item-action>
                          <v-list-item-content>
                            <v-list-item-title>
                              Select All
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-divider class="mt-2" />
                      </template>
                      <template #selection="{ item, index }">
                        <v-chip
                          v-if="index < colSize.show"
                          close
                          @click:close="remove(item.value,'jabatan')"
                        >
                          <span>{{ colSize.expand?item.text:item.text.substring(0,20)+'...' }}</span>
                        </v-chip>
                        <span
                          v-if="index === colSize.show"
                          class="primary--text text-caption"
                        >
                          (+{{ tmp.jabatan[surat_keluar.id_opd].length - colSize.show }})
                        </span>
                      </template>
                    </v-autocomplete>
                  </v-col>
                  <v-col
                    :cols="colSize.col"
                    :sm="colSize.sm"
                    :md="colSize.md"
                    class="py-0"
                  >
                    <v-autocomplete
                      v-model="tmp.pegawai[surat_keluar.id_opd]"
                      :items="items.pegawai"
                      label="Pilih Berdasarkan Nama Pegawai"
                      multiple
                      outlined
                      deletable-chips
                      clearable
                      @change="onChangePegawai"
                    >
                      <template #prepend-item>
                        <v-list-item
                          ripple
                          @click="togglepegawai()"
                        >
                          <v-list-item-action>
                            <v-icon :color="tmp.pegawai[surat_keluar.id_opd].length > 0 ? 'indigo darken-4' : ''">
                              {{ toggleIconPegawai }}
                            </v-icon>
                          </v-list-item-action>
                          <v-list-item-content>
                            <v-list-item-title>
                              Select All
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-divider class="mt-2" />
                      </template>
                      <template #selection="{ item, index }">
                        <v-chip
                          v-if="index < colSize.show"
                          close
                          @click:close="remove(item.value,'pegawai')"
                        >
                          <span>{{ (colSize.expand?item.text:item.text.substring(0,20)+'...').toUpperCase() }}</span>
                        </v-chip>
                        <span
                          v-if="index === colSize.show"
                          class="primary--text text-caption"
                        >
                          (+{{ tmp.pegawai[surat_keluar.id_opd].length - colSize.show }})
                        </span>
                      </template>
                    </v-autocomplete>
                  </v-col>
                  <v-col
                    :cols="colSize.col"
                    :sm="colSize.sm"
                    :md="colSize.md"
                    class="py-0"
                  >
                    <v-autocomplete
                      v-model="tmp.esselon[surat_keluar.id_opd]"
                      :items="items.esselon"
                      label="Pilih Berdasarkan Esselon"
                      multiple
                      outlined
                      deletable-chips
                      clearable
                      @change="onChangeEsselon"
                    >
                      <template #prepend-item>
                        <v-list-item
                          ripple
                          @click="toggleesselon()"
                        >
                          <v-list-item-action>
                            <v-icon :color="tmp.esselon[surat_keluar.id_opd].length > 0 ? 'indigo darken-4' : ''">
                              {{ toggleIconEsselon }}
                            </v-icon>
                          </v-list-item-action>
                          <v-list-item-content>
                            <v-list-item-title>
                              Select All
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-divider class="mt-2" />
                      </template>
                      <template #selection="{ item, index }">
                        <v-chip
                          v-if="index < colSize.show"
                          close
                          @click:close="remove(item.value,'esselon')"
                        >
                          <span>{{ item.text }}</span>
                        </v-chip>
                        <span
                          v-if="index === colSize.show"
                          class="primary--text text-caption"
                        >
                          (+{{ tmp.esselon[surat_keluar.id_opd].length - colSize.show }})
                        </span>
                      </template>
                    </v-autocomplete>
                  </v-col>
                </v-row>
              </v-col>
              <v-col
                v-show="tmp.opd_selected"
                cols="12"
                md="12"
                class="pt-3 pb-5"
              >
                <v-data-table
                  fixed-header
                  :headers="headerDt"
                  :items="showDataTerpilih"
                  multi-sort
                  class="elevation-1"
                  no-data-text="Belum ada tujuan yang dipilih"
                >
                  <template #item.value="{item}">
                    <v-btn
                      icon
                      @click="removeDt(item)"
                    >
                      <v-icon color="#d81b60">
                        mdi-delete
                      </v-icon>
                    </v-btn>
                  </template>
                </v-data-table>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>
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
import { inputValidator, isEmpty } from '@/plugins/supports'

export default {
  components: {
    'dialog-confirm': Dialog
  },
  data () {
    return {
      loadingData: true,
      surat_keluar: {
        id_opd: 0,
        id_jenis_surat: null,
        penerima_surat: [],
        kategori_surat: null,
        karakteristik_surat: null,
        derajat_surat: null,
        perihal_surat: null,
        lampiran: null
      },
      tmp: {
        tujuan: 'jabatan',
        jabatan: { },
        esselon: { },
        pegawai: { },
        opd_selected: false,
        loadingOpd: false,
        showDialogTujuan: false
      },
      items: { jenis_surat: [], opd: [], jabatan: [], esselon: [], pegawai: [], datas: [] },
      colSize: { col: 12, sm: 12, md: 4, show: 1, expand: false },

      schema: {
        id_jenis_surat: 'required',
        id_opd: 'required',
        kategori_surat: 'required',
        penerima_surat: 'required',
        karakteristik_surat: 'required',
        derajat_surat: 'required',
        perihal_surat: 'required',
        lampiran: 'required'
      },
      rules: {
        required: v => {
          v = isEmpty(v)
          return !v || 'Tidak Boleh Kosong'
        }
      },

      showDC: false,
      dcMessages: 'Simpan Surat Keluar Sekarang?',
      dcProgress: false,
      dcdisabledNegativeBtn: false,
      dcdisabledPositiveBtn: false,
      dcNegativeBtn: () => { this.showDC = false },
      dcPositiveBtn: () => this.postAdd()
    }
  },
  computed: {
    dataValidation () {
      return inputValidator(this.schema, this.rules, this.surat_keluar)
    },
    selectedAllJabatan () {
      return this.tmp.jabatan[this.surat_keluar.id_opd].length === this.items.jabatan.length
    },
    selectedAllEsselon () {
      return this.tmp.esselon[this.surat_keluar.id_opd].length === this.items.esselon.length
    },
    selectedAllPegawai () {
      return this.tmp.pegawai[this.surat_keluar.id_opd].length === this.items.pegawai.length
    },
    toggleIconJabatan () {
      if (this.selectedAllJabatan) return 'mdi-close-box'
      if (this.tmp.jabatan[this.surat_keluar.id_opd].length > 0 && !this.selectedAllJabatan) return 'mdi-minus-box'
      return 'mdi-checkbox-blank-outline'
    },
    toggleIconEsselon () {
      if (this.selectedAllEsselon) return 'mdi-close-box'
      if (this.tmp.esselon[this.surat_keluar.id_opd].length > 0 && !this.selectedAllEsselon) return 'mdi-minus-box'
      return 'mdi-checkbox-blank-outline'
    },
    toggleIconPegawai () {
      if (this.selectedAllPegawai) return 'mdi-close-box'
      if (this.tmp.pegawai[this.surat_keluar.id_opd].length > 0 && !this.selectedAllPegawai) return 'mdi-minus-box'
      return 'mdi-checkbox-blank-outline'
    },
    showDataTerpilih () {
      return this.surat_keluar.penerima_surat
    },
    headerDt () {
      return [
        { text: 'Nama', value: 'nama_pegawai' },
        { text: 'OPD', value: 'opd' },
        { text: 'Jabatan', value: 'nama_jabatan' },
        { text: 'Esselon', value: 'esselon' },
        { text: 'Aksi', value: 'value', align: 'center' }
      ]
    }
  },
  created () {
    for (const d of ['jabatan', 'esselon', 'pegawai']) {
      for (let i = 0; i < 60; i++) {
        this.tmp[d][i] = []
      }
    }
    this.createSuratKeluar().then(data => {
      this.items.jenis_surat = isEmpty(data.jenis_surat, [])
      this.items.opd = isEmpty(data.opd, [])
    })
  },
  methods: {
    ...mapActions(['addSuratKeluar', 'createSuratKeluar', 'getPegawaiByOpd']),
    remove (item, key) {
      const index = this.tmp[key][this.surat_keluar.id_opd].indexOf(item)
      if (index >= 0) this.tmp[key][this.surat_keluar.id_opd].splice(index, 1)
    },
    removeDt (key) {
      const index = this.surat_keluar.penerima_surat.indexOf(key)
      if (index >= 0) this.surat_keluar.penerima_surat.splice(index, 1)
    },
    togglejabatan () {
      this.$nextTick(() => {
        this.onChangeJabatan()
        if (!this.selectedAllJabatan) {
          this.tmp.jabatan[this.surat_keluar.id_opd] = this.items.jabatan.map(d => {
            return d.value
          })
        } else {
          this.tmp.jabatan[this.surat_keluar.id_opd] = []
        }
      })
    },
    toggleesselon () {
      this.$nextTick(() => {
        this.onChangeEsselon()
        if (!this.selectedAllEsselon) {
          this.tmp.esselon[this.surat_keluar.id_opd] = this.items.esselon.map(d => {
            return d.value
          })
        } else {
          this.tmp.esselon[this.surat_keluar.id_opd] = []
        }
      })
    },
    togglepegawai () {
      this.$nextTick(() => {
        this.onChangePegawai()
        if (!this.selectedAllPegawai) {
          this.tmp.pegawai[this.surat_keluar.id_opd] = this.items.pegawai.map(d => {
            return d.value
          })
        } else {
          this.tmp.pegawai[this.surat_keluar.id_opd] = []
        }
      })
    },
    onChangeJabatan () {
      this.tmp.tujuan = 'jabatan'
      this.onChange()
    },
    onChangeEsselon () {
      this.tmp.tujuan = 'esselon'
      this.onChange()
    },
    onChangePegawai () {
      this.tmp.tujuan = 'pegawai'
      this.onChange()
    },
    onChange () {
      for (const d of this.tmp[this.tmp.tujuan][this.surat_keluar.id_opd]) {
        for (const data of this.items.datas) {
          if (d.indexOf(data.kode_jabatan) > -1) {
            let o = ''
            for (const opd of this.items.opd) {
              if (parseInt(data.kode_jabatan.substring(0, 2)) === opd.value) {
                o = opd.text
                break
              }
            }
            data.opd = o
            if (this.surat_keluar.penerima_surat.indexOf(data) === -1) {
              this.surat_keluar.penerima_surat.push(data)
            }
          }
        }
      }
    },
    collapse () { this.colSize = { col: 12, sm: 12, md: 4, show: 1, expand: false } },
    expand () { this.colSize = { col: 12, sm: 12, md: 12, show: 15, expand: true } },
    backButton () { this.$router.push({ name: 'surat_keluar' }) },
    onChangeOpd () {
      this.items.jabatan = []
      this.items.esselon = []
      this.items.pegawai = []
      this.tmp.opd_selected = false
      this.tmp.loadingOpd = true
      this.getPegawaiByOpd({ id_opd: this.surat_keluar.id_opd })
        .then(data => {
          this.items.datas = isEmpty(data, [])
          const collectEsselon = []
          const collectJabatan = []
          for (const d of this.items.datas) {
            // kelompokkan kode_jabatan berdasarkan jabatan
            const nj = d.nama_jabatan
            if (typeof collectJabatan[nj] === 'undefined') {
              collectJabatan[nj] = { value: [d.kode_jabatan], text: nj }
            } else {
              collectJabatan[nj].value.push(d.kode_jabatan)
            }

            // kelompokkan kode_jabatan berdasarkan esselon
            if (d.esselon) {
              const es = 'esselon-' + d.esselon
              if (typeof collectEsselon[es] === 'undefined') {
                collectEsselon[es] = { value: [d.kode_jabatan], text: 'Esselon ' + d.esselon }
              } else {
                collectEsselon[es].value.push(d.kode_jabatan)
              }
            }

            // kelompokkan kode_jabatan berdasarkan nip
            if (!JSON.stringify(this.items.pegawai).includes(d.nip)) {
              this.items.pegawai.push({
                value: d.kode_jabatan,
                text: d.nama_pegawai
              })
            }
          }
          this.items.jabatan = Object.values(collectJabatan)
          this.items.esselon = Object.values(collectEsselon)
          this.tmp.opd_selected = true
          this.tmp.loadingOpd = false
        }).catch(() => {
          this.tmp.opd_selected = false
          this.tmp.loadingOpd = false
        })
    },
    postAdd () {
      /* Initialize the form data */
      const formData = new FormData()

      /* Add the form data we need to submit */
      // const type = this.surat_keluar.lampiran.dataBlob.type.split('/')[1]
      // formData.append('lampiran', this.surat_keluar.lampiran, `file.${type}`)
      console.log(this.surat_keluar.lampiran)

      const penerimaSurat = this.surat_keluar.penerima_surat.map(data => {
        return data.kode_jabatan
      })
      console.log(JSON.stringify(penerimaSurat))
      formData.append('penerima_surat',
        new Blob([JSON.stringify(penerimaSurat)], { type: 'application/json' }))

      Object.keys(this.surat_keluar).forEach(d => {
        if (!(['penerima_surat', 'lampiran'].includes(d))) {
          formData.append(d, this.surat_keluar[d])
        }
      })

      this.dcProgress = true
      this.dcdisabledNegativeBtn = true
      this.dcdisabledPositiveBtn = true
      this.dcMessages = 'Tunggu Sebentar, Sedang Menyimpan Surat Keluar...'
      this.addSuratKeluar(this.surat_keluar).then((res) => {
        this.dcProgress = false
        this.dcMessages = res.msg
        setTimeout(() => {
          this.showDC = false
          this.$router.push({ name: 'surat_keluar' })
          this.dcMessages = 'Simpan Surat Keluar Sekarang?'
        }, 2000)
      })
    }
  }
}
</script>

<style>
.fs-14 > label{
  font-size: 14px !important;
}
.theme--light.v-data-table.v-data-table--fixed-header thead th {
  background-color: #eee !important;
}
</style>
