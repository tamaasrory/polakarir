<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="template_surat">
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
      <v-toolbar-title>
        Pergerakan Karir
      </v-toolbar-title>
      <v-spacer />
    </v-app-bar>
    <v-container class="px-10 pb-10">
      <h1 class="my-2">
        Akan Dikembangkan
      </h1>
    </v-container>
  </div>
</template>

<script>

export default {
  components: {},
  data () {
    return {}
  },
  computed: {}
}
</script>
<style>
.v-data-footer__icons-before, .v-data-footer__icons-after {
  display: none !important;
}
</style>
