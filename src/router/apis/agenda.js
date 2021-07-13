import $axios from '@/router/server'

const Agenda = {
  // START Agenda API
  getAgendaToCalender ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      const { from, to } = payload
      let query = {
        from: from || '',
        to: to || ''
      }
      query = new URLSearchParams(query).toString()
      $axios.get(`/dashborad/index?${query}`)
        .then((response) => {
          if (response.status === 200) {
            const items = response.data.agenda
            const suratKeluarActive = response.data.surat_keluar_active
            const suratMasukActive = response.data.surat_masuk_active
            resolve({ items, suratKeluarActive, suratMasukActive })
          } else {
            resolve({ items: [], suratKeluarActive: 0, suratMasukActive: 0 })
          }
        }).catch((error) => {
          console.log(error)
          resolve({ items: [], suratKeluarActive: 0, suratMasukActive: 0 })
        })
    })
  },
  getAgendaAll ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      const { page, itemsPerPage, sortBy, sortDesc, search } = payload
      let query = {
        search: search || '',
        page: page || 1,
        per_page: itemsPerPage || 5,
        sortBy: sortBy.length ? JSON.stringify(sortBy) : '',
        sortDesc: sortDesc.length ? JSON.stringify(sortDesc) : ''
      }
      query = new URLSearchParams(query).toString()
      $axios.get(`/agenda/all?${query}`)
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
  getAgendaById ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.get(`/agenda/detail/${payload.id}`)
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
  deleteAgenda ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.delete(`/agenda/delete/${payload}`)
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
  addAgenda ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.post('/agenda/baru', payload)
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
  updateAgenda ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.put(`/agenda/update/${payload.id}`, payload)
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
  }
  // END Agenda API
}

export default Agenda
