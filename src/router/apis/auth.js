import $axios from '@/router/server'

export default {
  logout ({ commit }, payload) {
    commit('SET_TOKEN', null)
    commit('SET_USER', {})
  },
  login ({ commit }, payload) {
    commit('SET_TOKEN', null)
    commit('SET_USER', null)
    commit('SET_PERM', null)

    return new Promise((resolve, reject) => {
      $axios.post('/auth/login', payload)
        .then((response) => {
          const { data, status } = response

          if (status === 200) {
            if (data.value) {
              commit('SET_TOKEN', data.token)
              commit('SET_USER', data.value)
              commit('SET_PERM', data.value.perm)
            } else {
              commit('SET_ERRORS', { message: data.msg })
            }
          }
          resolve(response)
        })
        .catch((error) => {
          commit('SET_ERRORS', { message: error })
          resolve(error)
        })
    })
  },
  authRefresh ({ commit }) {
    return new Promise((resolve, reject) => {
      $axios.get('/auth/refresh')
        .then((response) => {
          const { data, status } = response
          if (status === 200) {
            if (data.value) {
              commit('SET_PERM', data.value)
              resolve(data.value)
              // localStorage.setItem('token', data.token)
            } else {
              commit('SET_ERRORS', { message: data.msg })
            }
          }
          resolve(false)
        })
        .catch((error) => {
          commit('SET_ERRORS', { message: error })
          resolve(error)
        })
    })
  }
}
