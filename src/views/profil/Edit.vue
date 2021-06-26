<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="material">
    <v-app-bar
      color="white"
      elevation="0"
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
      <v-avatar class="mx-3">
        <img
          src="https://cdn.vuetifyjs.com/images/john.jpg"
          alt="John"
        >
      </v-avatar>
      <div class="mt-5">
        <h4 class="mr-5 light-blue--text accent-4">
          Tri Mueri Sandes
        </h4>
        <p class="mr-5 light-blue--text accent-1">
          Kasubag umum
        </p>
      </div>
      <div class="text-center">
        <v-menu offset-y>
          <template #activator="{ on, attrs }">
            <v-btn
              fab
              text
              small
              color="light-blue accent-4"
              v-bind="attrs"
              v-on="on"
            >
              <v-icon large>
                mdi-chevron-down
              </v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item
              v-for="(item, index) in items"
              :key="index"
            >
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-app-bar>
    <v-container fluid>
      <h1 class="my-2">
        Edit Profil
      </h1>
      <v-container class="mt-16">
        <v-row>
          <v-col cols="4">
            <v-card
              outlined
              elevation="5"
              shadow="none"
              min-height="300"
              max-width="1120">

            </v-card>
            <v-slider
              class="mt-5"
              hint="Im a hint"
              max="50"
              min="-50"
            ></v-slider>
            <v-file-input
              prepend-icon=""
              color="white"
              flat="true"
              solo>
              <template v-slot:label >
                <v-btn color="#CBCBCB"  x-small  rounded class="text-capitalize">Choose File</v-btn>
                No File Chosen
              </template>
            </v-file-input>
          </v-col>
          <v-col cols="8">
            <template>
              <v-simple-table>
                <template #default>
                  <tbody>
                  <tr
                    v-for="item in desserts"
                    :key="item.name"
                  >
                    <td class="font-weight-bold">{{ item.name }}</td>
                    <td>{{ item.calories }}</td>
                  </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <v-btn elevation="2"
                     @click="_addTujuan()"
                     class="mt-5 cyan accent-3 text-capitalize white--text rounded-xl" >
                Simpan
              </v-btn>
            </template>
          </v-col>
        </v-row>
      </v-container>
    </v-container>
  </div>
</template>

<script>
import {mapActions} from 'vuex'
import Dialog from '@/components/Dialog'
import {canEdit} from '@/plugins/supports'

export default {
  name: 'Material',
  components: {
    'delete-dialog-confirm': Dialog
  },
  data() {
    return {

      desserts: [
        {
          name: 'Username',
          calories: 'trimueri'
        },
        {
          name: 'Password',
          calories: '*******'
        },
        {
          name: 'Nama',
          calories: 'Jhon doe'
        },
        {
          name: 'E-mail',
          calories: 'trimuerisandes@gmail.com'
        },
        {
          name: 'No HP',
          calories: '081314721408'
        },
        {
          name: 'Alamat',
          calories: 'Panam, Pekanbaru'
        }
      ],

      searchQuery: '',
      toggleFp: false,
      isLoading: true,
      datas: [],

      options: {},
      pagination: {},
      serverLength: 0,
      config: {
        table: {
          page: 1,
          pageCount: 0,
          sortBy: ['id'],
          sortDesc: [true],
          itemsPerPage: 10,
          itemKey: 'id'
        }
      },

      showDC: false,
      deleteId: '',
      dcMessages: '',
      dcProgress: false,
      dcdisabledNegativeBtn: false,
      dcdisabledPositiveBtn: false,
      dcNegativeBtn: () => {
        this.showDC = false
      },
      dcPositiveBtn: () => this._delete(true)
    }
  },
  computed: {
    headerData() {
      return [
        {text: 'Nomor', value: 'nama'},
        {text: 'Nomor Berkas', value: 'satuan'},
        {text: 'Judul Berkas', value: 'updated_at'},
        {text: 'Klasifikasi', value: 'updated_at'},
        {text: 'Lokasi Fisik Berkas', value: 'updated_at'},
        {text: 'Aksi', value: 'aksi'}
      ]
    }
  },
  watch: {
    options(a, b) {
      this._loadData(true)
    }
  },
  mounted() {
    this._loadData(false) // loading data form server
  },
  methods: {
    ...mapActions(['getMaterial', 'deleteMaterial']),
    canEdit,
    _detail(value) {
      this.$router.push({name: 'material_view', params: {id: value.id}})
    },
    _addArsip() {
      this.$router.push({name: 'arsip-surat_add'})
    },
    _edit(value) {
      this.$router.push({name: 'material_edit', params: {id: value.id}})
    },
    _delete(value) {
      if (value === true) {
        this.dcProgress = true
        this.dcdisabledNegativeBtn = true
        this.dcdisabledPositiveBtn = true
        this.dcMessages = 'Sedang menghapus material'
        this.deleteMaterial(this.deleteId)
          .then((res) => {
            this._loadData(true)
            this.dcProgress = false
            this.dcMessages = 'Berhasil Menghapus Material'
            setTimeout(() => {
              this.deleteId = ''
              this.showDC = false
              this.dcdisabledNegativeBtn = false
              this.dcdisabledPositiveBtn = false
            }, 1500)
          })
          .catch((err) => {
            console.log(err)
            this.dcdisabledNegativeBtn = false
            this.dcdisabledPositiveBtn = false
          })
      } else {
        this.deleteId = value.id
        this.dcMessages = `Hapus material <span class="pink--text">#${this.deleteId}</span> ?`
        this.showDC = true
      }
    },
    _clearFilter() {
      this.searchQuery = null
      this._loadData(true)
    },
    _loadData(abort) {
      if (this.datas.length === 0 || abort) {
        this.isLoading = true
        this.getMaterial({search: this.searchQuery, ...this.options}).then(
          (data) => {
            this.datas = data.items || []
            this.serverLength = data.total || 0
            this.isLoading = false
          }
        )
      } else {
        this.isLoading = false
      }
    }
  }
}
</script>
<style>
.v-data-footer__icons-before,
.v-data-footer__icons-after {
  display: none !important;
}
</style>
