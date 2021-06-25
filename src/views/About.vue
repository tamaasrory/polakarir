<!--
  - Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
  - Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
  -->

<template>
  <div class="about">
    <v-container>
      <v-layout
        class="mt-7"
        text-center
        wrap
      >
        <v-flex xs12>
          <v-img
            :src="require('../assets/ic-e-office.png')"
            class="my-3"
            contain
            height="200"
          />
        </v-flex>
        <v-flex mb-4>
          <div class="subheading font-weight-bold mt-2 text-h6">
            E-Office
          </div>
          <div>App Version v1.0</div>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>
