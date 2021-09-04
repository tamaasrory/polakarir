import $axios from '@/router/server'

const SKJ = {
    // START SuratKeluar API
    getSKJ({commit}, payload) {
        return new Promise((resolve, reject) => {
            const {page, itemsPerPage, sortBy, sortDesc, search} = payload
            let query = {
                page: page || 1,
                per_page: itemsPerPage || 5,
                sortBy: sortBy.length ? JSON.stringify(sortBy) : '',
                sortDesc: sortDesc.length ? JSON.stringify(sortDesc) : '',
                search: search,
                ...payload.add
            }
            query = new URLSearchParams(query).toString()
            $axios.get(`/standar-kompetensi/all?${query}`)
                .then((response) => {
                    if (response.status === 200) {
                        const items = response.data.value.data
                        const total = response.data.value.total
                        resolve({items, total})
                    } else {
                        resolve({items: [], total: 0})
                    }
                })
                .catch((error) => {
                    console.log(error)
                    resolve({items: [], total: 0})
                })
        })
    },
    getSKJById({commit}, payload) {
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
    deleteSuratKeluar({commit}, payload) {
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
    createSuratKeluar({commit}) {
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
    addStandarKopentensi({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.post('/standar-kompetensi/baru', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    if (response.status === 200) {
                        resolve(response.data)
                    } else {
                        resolve({msg: 'Sepertinya ada masalah, silahkan coba lagi'})
                    }
                })
                .catch((error) => {
                    console.log(error)
                    resolve({msg: error})
                })
        })
    },
    downloadSKJ ({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/standar-kompetensi/download/${payload.id}`, { method: 'GET', responseType: 'blob' }).then(response => {
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
    },
  // END SuratKeluar API
}

export default SKJ
