import $axios from "@/router/server";
import TemplateSurat from "@/router/apis/template-surat";

const Dashboard = {

  getDashboard({commit}, payload) {
    return new Promise((resolve, reject) => {
      $axios.get(`/dashboard/index/${payload}`)
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

}

export default Dashboard
