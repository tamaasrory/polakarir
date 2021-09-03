import $axios from '@/router/server'

const Dashboard = {

  getDashboard ({ commit }, payload) {
    return new Promise((resolve, reject) => {
      $axios.get('/pola-karir/detail')
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

}

export default Dashboard
