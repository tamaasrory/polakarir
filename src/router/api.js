
/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

import auth from '@/router/apis/auth'
import material from '@/router/apis/material'
import roles from '@/router/apis/roles'
import user from '@/router/apis/user'
import app from '@/router/apis/app'
import SuratMasuk from '@/router/apis/surat-masuk'

const $api = {
  ...auth,
  ...material,
  ...roles,
  ...user,
  ...app,
  ...SuratMasuk
}

export default $api
