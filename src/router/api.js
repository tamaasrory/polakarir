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
import SyaratJabatan from '@/router/apis/syarat-jabatan'
import Profil from '@/router/apis/profil'
import TemplateSurat from '@/router/apis/template-surat'
import Dashboard from '@/router/apis/dashboard'
import ArsipSurat from '@/router/apis/arsip-surat'
import JenisSurat from '@/router/apis/jenis-surat'
import Sinergi from '@/router/apis/sinergi'
import PolaKarir from '@/router/apis/pola-karir'
import StandarKompetensi from '@/router/apis/standar-kompetensi'

const $api = {
  ...auth,
  ...roles,
  ...user,
  ...app,
  ...SuratMasuk,
  ...SuratKeluar,
  ...TemplateSurat,
  ...Dashboard,
  ...PolaKarir,
  ...ArsipSurat,
  ...JenisSurat,
  ...Sinergi,
  ...Profil,
  ...PolaKarir,
  ...StandarKompetensi,
  ...SyaratJabatan
}

export default $api
