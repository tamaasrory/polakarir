<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="material">
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
        Profil
      </h1>
      <v-container class="mt-16">
        <v-row>
          <v-col cols="4">
            <avatar size="200" username="H i"></avatar>
          </v-col>
          <v-col cols="8" class="align-self-center">
            <template>
              <v-card>
              <v-simple-table >
                <template #default>
                  <tbody>
                  <tr>
                    <td>NIP</td>
                    <td>{{user ? user.id : '' }}</td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td>{{user ? user.email : '' }}</td>
                  </tr>
                  <tr>
                    <td>Jabatan</td>
                    <td>{{ (user.sinergi ? user.sinergi.nama_jabatan : (user?user.role[0]:'')).toLowerCase()}}</td>
                  </tr>
                  </tbody>
                </template>
              </v-simple-table>
              </v-card>
<!--              <v-btn elevation="2"
                     @click="_editProfil()"
                     class="mt-5 cyan accent-3 text-capitalize white&#45;&#45;text rounded-xl" >
                Ubah
              </v-btn>-->
            </template>
          </v-col>
        </v-row>
      </v-container>
    </v-container>
  </div>
</template>

<script>
import {mapActions, mapGetters, mapState} from 'vuex'
import Dialog from '@/components/Dialog'
import {canEdit} from '@/plugins/supports'
import Account from "@/components/default/Account";
import Avatar from 'vue-avatar'


export default {
  name: 'Profil',
  components: {
    Avatar,
    Account,
    'delete-dialog-confirm': Dialog
  },
  data() {
    return {

        innitialName: 'tri',


      desserts: [
        {
          name: 'Username',
          calories: 'trimueri'
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
    ...mapGetters(['isAuth']),
    ...mapState(['user']),
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
    speakerInitials(speaker) {
      const name = speaker.user.name.split(' ')
      return `${name[0].charAt(0)}${name[1] ? name[1].charAt(0) : ''}`;
    },
    _detail(value) {
      this.$router.push({name: 'material_view', params: {id: value.id}})
    },
    _editProfil() {
      this.$router.push({name: 'edit_profil'})
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
