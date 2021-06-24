import $axios from '@/router/server'

const Sinergi = {
  // START Sinergi API
  getOpd ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.post('/sinergi/opd', payload)
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data)
          } else {
            resolve(response.data)
          }
        })
        .catch((error) => {
          console.log(error)
          resolve([])
        })
    })
  },
  getOpdById ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.post('/sinergi/opd-by-id', payload)
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data)
          } else {
            resolve(response.data)
          }
        })
        .catch((error) => {
          console.log(error)
          resolve([])
        })
    })
  },
  getPegawaiByOpd ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.post('/sinergi/pegawai-by-opd', payload)
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data)
          } else {
            resolve(response.data)
          }
        })
        .catch((error) => {
          console.log(error)
          resolve([])
        })
    })
  },
  getPegawaiByNip ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.post('/sinergi/pegawai-by-nip', payload)
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data)
          } else {
            resolve(response.data)
          }
        })
        .catch((error) => {
          console.log(error)
          resolve([])
        })
    })
  }
  // END Sinergi API
}

export default Sinergi
