import $axios from '@/router/server'

const SKJ = {
  // START SuratKeluar API
  getSKJ ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      const { page, itemsPerPage, sortBy, sortDesc } = payload
      let query = {
        page: page || 1,
        per_page: itemsPerPage || 5,
        sortBy: sortBy.length ? JSON.stringify(sortBy) : '',
        sortDesc: sortDesc.length ? JSON.stringify(sortDesc) : '',
        ...payload.add
      }
      query = new URLSearchParams(query).toString()
      $axios.get(`/standar-kompetensi/all?${query}`)
        .then((response) => {
          if (response.status === 200) {
            const items = response.data.value.data
            const total = response.data.value.total
            resolve({ items, total })
          } else {
            resolve({ items: [], total: 0 })
          }
        })
        .catch((error) => {
          console.log(error)
          resolve({ items: [], total: 0 })
        })
    })
  },
  getSKJById ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.get(`/standar-kompetensi/detail/${payload.id}`)
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data.value)
          } else {
            resolve(response.data.value)
          }
        })
        .catch((error) => {
          console.error(error)
          reject(error)
        })
    })
  },
  deleteSuratKeluar ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.delete(`/surat-keluar/delete/${payload}`)
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data.value)
          } else {
            resolve(response.data.value)
          }
        })
        .catch((error) => {
          console.log(error)
          resolve([])
        })
    })
  },
  createSuratKeluar ({ commit }) {
    return new Promise((resolve, reject) => {
      $axios.get('/surat-keluar/create')
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data.value)
          } else {
            resolve(response.data.value)
          }
        })
        .catch((error) => {
          console.log(error)
          resolve([])
        })
    })
  },
  addSuratKeluar ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.post('/surat-keluar/baru', payload, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data)
          } else {
            resolve({ msg: 'Sepertinya ada masalah, silahkan coba lagi' })
          }
        })
        .catch((error) => {
          console.log(error)
          resolve({ msg: error })
        })
    })
  },
  editSuratKeluar ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.get(`/surat-keluar/edit/${payload.id}`)
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data.value)
          } else {
            resolve(response.data.value)
          }
        })
        .catch((error) => {
          console.log(error)
          resolve([])
        })
    })
  },
  updateSuratKeluar ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.post('/surat-keluar/update', payload, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data)
          } else {
            resolve(response.data)
          }
          resolve(response.data)
        })
        .catch((error) => {
          console.log(error)
          resolve([])
        })
    })
  },
  validasiSuratKeluar ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.put('/surat-keluar/validasi-surat', payload)
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data)
          } else {
            resolve(response.data)
          }
          resolve(response.data)
        })
        .catch((error) => {
          console.log(error)
          resolve('Sepertinya ada masalah, silahkan coba lagi')
        })
    })
  },
  tteSuratKeluar ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.post('/surat-keluar/tte', payload)
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data)
          } else {
            resolve(response.data)
          }
          resolve(response.data)
        })
        .catch((error) => {
          console.log(error)
          resolve('Sepertinya ada masalah, silahkan coba lagi')
        })
    })
  },
  downloadSurat ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.get(`/surat-keluar/download/${payload}`, {
        responseType: 'blob'
      })
        .then((response) => {
          if (response.status === 200) {
            resolve({ result: true, data: new Blob([response.data]) })
          } else {
            resolve({ result: false })
          }
        })
        .catch((error) => {
          console.log(error)
          resolve({ result: false })
        })
    })
  }
  // END SuratKeluar API
}

export default SKJ
