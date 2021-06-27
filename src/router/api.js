/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

import auth from '@/router/apis/auth'
import roles from '@/router/apis/roles'
import user from '@/router/apis/user'
import app from '@/router/apis/app'
import SuratMasuk from '@/router/apis/surat-masuk'
import SuratKeluar from '@/router/apis/surat-keluar'
import Agenda from '@/router/apis/agenda'
import Profil from '@/router/apis/profil'
import TemplateSurat from '@/router/apis/template-surat'
import ArsipSurat from '@/router/apis/arsip-surat'
import JenisSurat from '@/router/apis/jenis-surat'
import Sinergi from '@/router/apis/sinergi'


const $api = {
  ...auth,
  ...roles,
  ...user,
  ...app,
  ...SuratMasuk,
  ...SuratKeluar,
  ...Agenda,
  ...TemplateSurat,
  ...ArsipSurat,
  ...JenisSurat,
  ...Sinergi,
  ...Profil
}

export default $api
