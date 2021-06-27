/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

const $states = {
  // STATE HAMPIR SERUPA DENGAN PROPERTY DATA DARI COMPONENT HANYA SAJA DAPAT DIGUNAKAN SECARA GLOBAL
  // VARIABLE TOKEN MENGAMBIL VALUE DARI LOCAL STORAGE token
  token: null,
  errors: [],
  user: {},
  perm: [],
  toggleMainMenu: false,
  dataTmp: []
}

export default $states
