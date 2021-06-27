/**
 * supports.js by tama asrory
 */
import { asset } from '@/router/Path'
import $axios from '@/router/server'
import store from '../store'

const perm = store.state.perm || []

/**
 * callBack function<br>
 * r = result dari pemeriksaan bernilai true (bila value kosong) dan<br>
 * bernilai false (bila value tidak kosong)<br>
 *
 * v = value original yang di periksa<br>
 * <code>(r, v) => (r ? [] : v)</code><br>
 */
export const isEmpty = (v, callBack) => {
  if (typeof callBack !== 'function' && typeof callBack !== 'undefined') {
    callBack = (r, v) => (r ? callBack : v)
  }
  if (['undefined', null, 'null', ''].includes(v)) {
    return true
  }
  let result = typeof v === 'string' ? !v.length : false
  result = !Object.keys(v || {}).length && result
  result = (!v) || result
  result = typeof callBack === 'function' ? callBack(result, v) : result
  return result
}

/**
 * if "valid" return false,
 * if "not valid" return true
 * @param schema
 * @param rules
 * @param data
 * @returns {boolean}
 */
export const inputValidator = (schema, rules, data) => {
  let notValid = false
  Object.keys(schema).map(value => {
    const funs = schema[value].split('|')
    // console.log(funs)
    for (let i = 0; i < funs.length; i++) {
      const valid = rules[funs[i]](data[value])
      // console.log(valid)
      if (typeof valid === 'string') {
        notValid = true
        break
      }
    }
    return null
  })
  return notValid
}

export const imgUrlToBlob = (imgUrl, callback) => {
  const tmp = new Promise((resolve, reject) => {
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
    const tmp = []
    datas.map(v => {
      if (callback(v)) {
        tmp.push(v)
      }
      return null
    })
    return tmp
  } else {
    return datas
  }
}

export const can = (permissions) => {
  for (const permission of permissions) {
    if (perm.includes(permission)) {
      return true
    }
  }
  return false
}
