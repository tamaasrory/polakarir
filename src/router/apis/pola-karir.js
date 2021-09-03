import $axios from '@/router/server'

const PolaKarir = {

  viewKarir ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.get('/pola-karir/detail')
        .then((response) => {
          if (response.status === 200) {
            resolve(response.data.value)
          } else {
            resolve({ value: {} })
          }
        })
        .catch((error) => {
          console.log(error)
          resolve({ value: {} })
        })
    })
  },
  filterKarir ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.post('/pola-karir/filter', payload)
        .then((response) => {
          if (response.status === 200) {
            resolve({ data: response.data.value })
          } else {
            resolve({ data: {} })
          }
        })
        .catch((error) => {
          console.log(error)
          resolve({ data: {} })
        })
    })
  }

}

export default PolaKarir
