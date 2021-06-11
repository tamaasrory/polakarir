const SuratKeluar = [
  // ROUTES PARFUM START HERE
  {
    path: '/surat-keluar',
    name: 'surat-keluar',
    component: () => import(/* webpackChunkName: "surat-keluar.chunk" */ '@/views/surat-keluar/Index'),
    meta: {
      title: 'Surat Keluar',
      icon: 'mdi-email-send',
      // subheader: 'Data Master',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/surat-keluar/baru',
    name: 'surat-keluar_add',
    component: () => import(/* webpackChunkName: "surat-keluar.chunk" */ '@/views/surat-keluar/Add'),
    meta: {
      title: 'Tambah Surat Keluar',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/surat-keluar/view/:id',
    name: 'surat-keluar_view',
    component: () => import(/* webpackChunkName: "surat-keluar.chunk" */ '@/views/surat-keluar/View'),
    props: true,
    meta: {
      title: 'Detail Surat Keluar',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/surat-keluar/edit/:id',
    name: 'surat-keluar_edit',
    component: () => import(/* webpackChunkName: "surat-keluar.chunk" */ '@/views/surat-keluar/Edit'),
    props: true,
    meta: {
      title: 'Edit Surat Keluar',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  }
  // END PARFUM
]
export default SuratKeluar
