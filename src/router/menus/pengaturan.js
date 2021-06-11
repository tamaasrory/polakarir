export default [
  // ROUTES PARFUM START HERE
  {
    path: '/pengaturan',
    name: 'pengaturan',
    component: () => import(/* webpackChunkName: "pengaturan.chunk" */ '@/views/pengaturan/Index'),
    meta: {
      title: 'Pengaturan',
      icon: 'mdi-cog',
      // subheader: 'Data Master',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/pengaturan/baru',
    name: 'pengaturan_add',
    component: () => import(/* webpackChunkName: "pengaturan.chunk" */ '@/views/pengaturan/Add'),
    meta: {
      title: 'Tambah Pengaturan',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/pengaturan/view/:id',
    name: 'pengaturan_view',
    component: () => import(/* webpackChunkName: "pengaturan.chunk" */ '@/views/pengaturan/View'),
    props: true,
    meta: {
      title: 'Detail Pengaturan',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/pengaturan/edit/:id',
    name: 'pengaturan_edit',
    component: () => import(/* webpackChunkName: "pengaturan.chunk" */ '@/views/pengaturan/Edit'),
    props: true,
    meta: {
      title: 'Edit Pengaturan',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  }
  // END PARFUM
]
