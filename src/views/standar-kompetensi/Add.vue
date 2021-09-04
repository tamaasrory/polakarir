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

        </v-app-bar>
        <v-container fluid>
            <h1 class="my-2">
                Tambah Draft Template
            </h1>
            <div class="mt-lg-10">

                <v-row>
                    <v-col cols="2" class="mt-n7">
                        <v-subheader
                                class="font-weight-black black--text"
                        >Jenis OPD
                        </v-subheader>
                    </v-col>
                    <v-col cols="5" class="mt-n7">
                        <v-autocomplete
                                v-model="skj.id_opd"
                                :items="opdItems"
                                label="Jenis OPD"
                                clearable
                                outlined
                                item-text="name"

                                :rules="[rules.required]"
                        />
                    </v-col>
                </v-row>
                <v-row class="mt-n7">
                    <v-col cols="2">
                        <v-subheader
                                class="font-weight-black black--text"
                        >Nama Jabatan
                        </v-subheader>
                    </v-col>
                    <v-col cols="5">
                        <v-text-field
                                v-model="skj.nama_jabatan"
                                class="outline yellow--text"
                                outlined
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="mt-n7">
                    <v-col cols="2">
                        <v-subheader
                                class="font-weight-black black--text"
                        >Kelompok Jabatan
                        </v-subheader>
                    </v-col>
                    <v-col cols="5">
                        <v-autocomplete
                                v-model="skj.kelompok_jabatan"
                                :items="kelompok_jabatan"
                                label="Pilih Kelompok Jabatan"
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
                        >Urusan Pemerintah
                        </v-subheader>
                    </v-col>
                    <v-col cols="5">
                        <v-text-field
                                v-model="skj.urusan_pemerintah"
                                class="outline yellow--text"
                                outlined
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="mt-n7">
                    <v-col cols="2">
                        <v-subheader
                                class="font-weight-black black--text"
                        >File SKJ
                        </v-subheader>
                    </v-col>
                    <v-col cols="5">
                        <v-file-input
                                v-model="skj.draf"
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

                skj: {

                    nama_jabatan: null,
                    kelompok_jabatan: null,
                    urusan_pemerintah: null,
                    jenis_jabatan: null,
                    id_opd: null,
                    draf: null,
                },


                opdItems: [
                    { name: 'Badan',  id: 2 },
                    { name: 'Dinas', id: 1 },
                    { name: 'Inspektorat', id: 3 },
                    { name: 'Kecamatan', id: 4 },
                ],

                kelompok_jabatan: [
                  'Jabatan Pimpinan Tinggi',
                  'Jabatan Administrasi',
                  'Jabatan Administrator',
                  'Jabatan Pengawas',
                  'Administator',
                  'Pengawas',
                ],

                schema: {
                    nama_jabatan: 'required',
                    kelompok_jabatan: 'required',
                    urusan_pemerintah: 'required',
                    jenis_jabatan: 'required',
                    id_opd: 'required',
                },

                items: { jenis_surat: [], id_opd: [] },
                rules: {
                    required: v => {
                        v = isEmpty(v)
                        return !v || 'Tidak Boleh Kosong'
                    }
                },
                showDC: false,
                deleteId: '',
                dcMessages: 'Simpan SKJ Baru Sekarang?',
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
                return inputValidator(this.schema, this.rules, this.skj)
            }
        },
        methods: {
            ...mapActions(['addStandarKopentensi']),
            postAdd() {
                let skj_draf = new FormData();
                _.each(this.skj, (value, key) => {
                    skj_draf.append(key, value)
                })
                this.dcProgress = true
                this.dcdisabledNegativeBtn = true
                this.dcdisabledPositiveBtn = true
                this.dcMessages = 'Tunggu Sebentar, Sedang Menyimpan SKJ Baru...'
                this.addStandarKopentensi(skj_draf).then((res) => {
                    this.dcProgress = false
                    this.dcMessages = res.msg
                    setTimeout(() => {
                        this.showDC = false
                        this.$router.push({name: 'standar_kompetensi'})
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
