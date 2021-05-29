/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

import axios from 'axios'
import { baseURL } from './Path'

const $axios = axios.create({
  baseURL: `${baseURL}/api/v1`,
  headers: { 'Content-Type': 'application/json' }
})

$axios.interceptors.request.use(
  (config) => {
    let token = localStorage.getItem('token')

    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`
      // console.log('token on request = ' + token)
    }

    return config
  },

  (error) => {
    return Promise.reject(error)
  }
)

export default $axios
