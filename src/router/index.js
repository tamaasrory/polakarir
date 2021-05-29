/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

import Vue from 'vue'
import VueRouter from 'vue-router'
import menus from './menus'

Vue.use(VueRouter)

const routes = menus

const router = new VueRouter({
  // mode: 'history',
  routes,
  scrollBehavior () {
    document.getElementById('app').scrollIntoView()
  }
})

export default router
