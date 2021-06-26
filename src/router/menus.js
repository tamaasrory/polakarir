/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */
import user from '@/router/menus/user'
import roles from '@/router/menus/roles'
import SuratMasuk from '@/router/menus/surat-masuk'
import SuratKeluar from '@/router/menus/surat-keluar'
import Agenda from '@/router/menus/agenda'
import TemplateSurat from '@/router/menus/template-surat'
import ArsipSurat from '@/router/menus/arsip-surat'
import Profil from '@/router/menus/profil'

const menus = [
  {
    path: '/',
    name: 'home',
    component: () => import(/* webpackChunkName: "about.chunk" */ '@/views/Home'),
    meta: {
      title: 'Home',
      icon: 'mdi-home',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator', 'Staff']
    }
  },
  {
    path: '/login',
    name: 'login',
    component: () => import(/* webpackChunkName: "login.chunk" */ '@/views/Login'),
    meta: {
      title: 'Login'
    }
  },
  {
    path: '*',
    name: 'not_found',
    component: () => import(/* webpackChunkName: "about.chunk" */ '@/views/NotFound'),
    meta: {
      title: 'Not Found'
    }
  }
]
const about = [
  {
    path: '/about',
    name: 'about',
    component: () => import(/* webpackChunkName: "about.chunk" */ '@/views/About'),
    meta: {
      title: 'About',
      icon: 'mdi-help-circle',
      subheader: 'Lainnya',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  }
]
export default menus.concat(
  user,
  roles,
  SuratMasuk,
  SuratKeluar,
  Agenda,
  TemplateSurat,
  ArsipSurat,
  Profil
)
