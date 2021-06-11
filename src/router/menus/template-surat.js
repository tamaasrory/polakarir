const TemplateSurat = [
  // ROUTES PARFUM START HERE
  {
    path: '/template-surat',
    name: 'template-surat',
    component: () => import(/* webpackChunkName: "template-surat.chunk" */ '@/views/template-surat/Index'),
    meta: {
      title: 'Template Surat',
      icon: 'mdi-text-box-multiple',
      // subheader: 'Data Master',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/template-surat/baru',
    name: 'template-surat_add',
    component: () => import(/* webpackChunkName: "template-surat.chunk" */ '@/views/template-surat/Add'),
    meta: {
      title: 'Tambah Template Surat',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/template-surat/view/:id',
    name: 'template-surat_view',
    component: () => import(/* webpackChunkName: "template-surat.chunk" */ '@/views/template-surat/View'),
    props: true,
    meta: {
      title: 'Detail Template Surat',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/template-surat/edit/:id',
    name: 'template-surat_edit',
    component: () => import(/* webpackChunkName: "template-surat.chunk" */ '@/views/template-surat/Edit'),
    props: true,
    meta: {
      title: 'Edit Template Surat',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  }
  // END PARFUM
]
export default TemplateSurat
