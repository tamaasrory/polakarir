const path = '/jenis-surat'
const permission = 'jenis-surat-'
const routeName = 'jenis_surat'
const folder = 'jenis-surat'
const title = 'Jenis Surat'
const JenisSurat = [
  {
    path: path,
    name: routeName,
    component: () => import(/* webpackChunkName: "[request].chunk" */ `@/views/${folder}/Index`),
    meta: {
      title: title,
      icon: 'mdi-shape',
      // subheader: '-',
      requiresAuth: true,
      requirePermission: permission + 'list'
    }
  },
  {
    path: path + '/baru',
    name: routeName + '_add',
    component: () => import(/* webpackChunkName: "[request].chunk" */ `@/views/${folder}/Add`),
    meta: {
      title: 'Tambah' + title,
      requiresAuth: true,
      requirePermission: permission + 'create'
    }
  },
  /*{
    path: path + '/view/:id',
    name: routeName + '_view',
    component: () => import(/!* webpackChunkName: "[request].chunk" *!/ `@/views/${folder}/View`),
    props: true,
    meta: {
      title: 'Detail' + title,
      requiresAuth: true,
      requirePermission: permission + 'list'
    }
  },*/

  {
    path: path + '/edit',
    name: routeName + 'edit',
    component: () => import(/* webpackChunkName: "[request].chunk" */ `@/views/${folder}/Edit`),
    props: true,
    meta: {
      title: 'Edit' + title,
      requiresAuth: true,
      requirePermission: permission + 'edit'
    }
  }

]

export default JenisSurat
