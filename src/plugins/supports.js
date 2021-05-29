/**
 * supports.js by tama asrory
 */
import { asset } from '@/router/Path'
import $axios from '@/router/server'
import store from '../store'

let { role } = store.state.user

export const isEmpty = (v, callBack) => {
  let result = (!v) || (v !== null && !Object.keys(v || {}).length && !v.length)
  result = typeof callBack === 'function' ? callBack(result, v) : result
  return result
}

export const inputValidator = (schema, rules, data) => {
  let notValid = false
  Object.keys(schema).map(value => {
    let funs = schema[value].split('|')
    // console.log(funs)
    for (let i = 0; i < funs.length; i++) {
      let valid = rules[funs[i]](data[value])
      // console.log(valid)
      if (typeof valid === 'string') {
        notValid = true
        break
      }
    }
  })
  return notValid
}

export const imgUrlToBlob = (imgUrl, callback) => {
  let tmp = new Promise((resolve, reject) => {
    $axios.get(asset(imgUrl))
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
  tmp.then(d => {
    fetch(d).then(res => res.blob()).then(res => callback(res)).finally(() => {
      setTimeout(() => {
      }, 1500)
    })
  })
}

export const dataFilter = (word, datas, callback) => {
  if (!isEmpty(word)) {
    let tmp = []
    datas.map(v => {
      if (callback(v)) {
        tmp.push(v)
      }
    })
    return tmp
  } else {
    return datas
  }
}

export const canEdit = (actor) => {
  for (const val of actor) {
    if (role.includes(val)) {
      return true
    }
  }
  return false
}
