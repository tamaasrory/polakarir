export default [
  // ROUTES PARFUM START HERE
  {
    path: '/profil',
    name: 'profil',
    component: () => import(/* webpackChunkName: "pengaturan.chunk" */ '@/views/profil/Index'),
    meta: {
      title: 'Profil',
      icon: 'mdi-cog',
      // subheader: 'Data Master',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/profil/baru',
    name: 'profil_add',
    component: () => import(/* webpackChunkName: "pengaturan.chunk" */ '@/views/profil/Add'),
    meta: {
      title: 'Tambah Profil',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/profil/view/:id',
    name: 'profil_view',
    component: () => import(/* webpackChunkName: "pengaturan.chunk" */ '@/views/profil/View'),
    props: true,
    meta: {
      title: 'Detail Profil',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/profil/edit/:id',
    name: 'profil_edit',
    component: () => import(/* webpackChunkName: "pengaturan.chunk" */ '@/views/profil/Edit'),
    props: true,
    meta: {
      title: 'Edit Profil',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/profil/edit',
    name: 'editUser',
    component: () => import(/* webpackChunkName: "pengaturan.chunk" */ '@/views/profil/Edit'),
    props: true,
    meta: {
      title: 'Edit Profil',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  }
  // END PARFUM
]
