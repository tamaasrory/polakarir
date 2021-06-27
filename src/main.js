
/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import VueMoment from 'vue-moment'
import LoadScript from 'vue-plugin-load-script'
import Viewer from 'v-viewer'

import 'viewerjs/dist/viewer.css'
import '@mdi/font/css/materialdesignicons.min.css'
import { isEmpty } from '@/plugins/supports'

const moment = require('moment')
require('moment/locale/id')
Vue.config.productionTip = false

Vue.use(LoadScript)
Vue.use(Viewer)

Vue.use(VueMoment, {
  moment
})

// Navigation Guards
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    const auth = store.getters.isAuth
    if (!auth) {
      next({ name: 'login' })
    } else {
      const perm = store.state.perm || []
      if (!isEmpty(perm)) {
        if (to.matched.some(record => {
          if (perm.includes(record.meta.requirePermission)) {
            return true
          }
          return false
        })) {
          next()
        }
      } else {
        next({ name: 'not_found' })
      }
    }
  } else {
    next()
  }
})

const vm = new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
