const ArsipSurat = [
  // ROUTES PARFUM START HERE
  {
    path: '/arsip-surat',
    name: 'arsip-surat',
    component: () => import(/* webpackChunkName: "arsip-surat.chunk" */ '@/views/arsip-surat/Index'),
    meta: {
      title: 'Arsip Surat',
      icon: 'mdi-package-down',
      // subheader: 'Data Master',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/arsip-surat/baru',
    name: 'arsip-surat_add',
    component: () => import(/* webpackChunkName: "arsip-surat.chunk" */ '@/views/arsip-surat/Add'),
    meta: {
      title: 'Tambah Arsip Surat',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/arsip-surat/view/:id',
    name: 'arsip-surat_view',
    component: () => import(/* webpackChunkName: "arsip-surat.chunk" */ '@/views/arsip-surat/View'),
    props: true,
    meta: {
      title: 'Detail Arsip Surat',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/arsip-surat/edit/:id',
    name: 'arsip-surat_edit',
    component: () => import(/* webpackChunkName: "arsip-surat.chunk" */ '@/views/arsip-surat/Edit'),
    props: true,
    meta: {
      title: 'Edit Arsip Surat',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  }
  // END PARFUM
]

export default ArsipSurat
