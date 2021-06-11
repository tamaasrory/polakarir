const SuratMasuk = [
  // ROUTES PARFUM START HERE
  {
    path: '/surat-masuk',
    name: 'surat-masuk',
    component: () => import(/* webpackChunkName: "surat-masuk.chunk" */ '@/views/surat-masuk/Index'),
    meta: {
      title: 'Surat Masuk',
      icon: 'mdi-email-receive',
      // subheader: 'Data Master',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/surat-masuk/baru',
    name: 'surat-masuk_add',
    component: () => import(/* webpackChunkName: "surat-masuk.chunk" */ '@/views/surat-masuk/Add'),
    meta: {
      title: 'Tambah Surat Masuk',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/surat-masuk/view/:id',
    name: 'surat-masuk_view',
    component: () => import(/* webpackChunkName: "surat-masuk.chunk" */ '@/views/surat-masuk/View'),
    props: true,
    meta: {
      title: 'Detail Surat Masuk',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/surat-masuk/edit/:id',
    name: 'surat-masuk_edit',
    component: () => import(/* webpackChunkName: "surat-masuk.chunk" */ '@/views/surat-masuk/Edit'),
    props: true,
    meta: {
      title: 'Edit Surat Masuk',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  }
  // END PARFUM
]

export default SuratMasuk
