/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

const $getters = {
  // KITA MEMBUAT SEBUAH GETTERS DENGAN NAMA isAuth
  // DIMANA GETTERS INI AKAN BERNILAI TRUE/FALSE DENGAN KONDISI BERDASARKAN
  // STATE token.
  isAuth: state => {
    return state.token !== 'null' && state.token != null
  }
}

export default $getters
