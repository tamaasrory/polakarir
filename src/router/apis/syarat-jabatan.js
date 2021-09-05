import $axios from '@/router/server'

const SyaratJabatan = {
  // START Agenda API

  getSyaratJabatan ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      const { page, itemsPerPage, sortBy, sortDesc, search } = payload
      let query = {
        page: page || 1,
        per_page: itemsPerPage || 5,
        sortBy: sortBy.length ? JSON.stringify(sortBy) : '',
        sortDesc: sortDesc.length ? JSON.stringify(sortDesc) : '',
        search: search,
        ...payload.add
      }
      query = new URLSearchParams(query).toString()
      $axios.get(`/syarat-jabatan/all?${query}`)
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
  getSyaratJabatanById ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.get(`/syarat-jabatan/detail/${payload.id}`)
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
  downloadSyaratJabatan ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.get(`/syarat-jabatan/download/${payload.id}`, { method: 'GET', responseType: 'blob' }).then(response => {
        if (response.status === 200) {
          var fileURL = window.URL.createObjectURL(new Blob([response.data]))
          var fileLink = document.createElement('a')
          fileLink.href = fileURL
          fileLink.setAttribute('download', `${payload.nama}.docx`)
          document.body.appendChild(fileLink)
          fileLink.click()
          resolve(response.data.value)
        } else {
          resolve(response.data.value)
        }
      }).catch(error => {
        console.log(error)
        resolve([])
      })
    })
  }

  // END Agenda API
}

export default SyaratJabatan
