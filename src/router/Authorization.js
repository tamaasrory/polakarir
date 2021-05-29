/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */
import store from '../store'

var { role, detail } = store.state.user

export const isLeader = () => {
  return role.includes('leader')
}

export const isAdmin = () => {
  return role.includes('admin')
}

export const isOfficer = () => {
  return role.includes('officer')
}
