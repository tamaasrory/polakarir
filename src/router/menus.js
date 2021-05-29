/*
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */
import user from '@/router/menus/user'
import roles from '@/router/menus/roles'
import material from '@/router/menus/material'

const menus = [
  {
    path: '/',
    name: 'home',
    component: () => import(/* webpackChunkName: "about.chunk" */ '@/views/Home'),
    meta: {
      title: 'Dashboard',
      icon: 'mdi-view-dashboard-outline',
      requiresAuth: true,
      allowRole: ['admin', 'leader', 'officer']
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
      allowRole: ['admin', 'leader', 'officer']
    }
  }
]
export default menus.concat(
  user,
  roles,
  material,
  about
)
