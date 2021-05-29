export default [
  // ROUTES PARFUM START HERE
  {
    path: '/material',
    name: 'material',
    component: () => import(/* webpackChunkName: "material.chunk" */ '@/views/material/Index'),
    meta: {
      title: 'Material',
      icon: 'mdi-wrench',
      subheader: 'Data Master',
      requiresAuth: true,
      allowRole: ['admin', 'leader']
    }
  },
  {
    path: '/material/baru',
    name: 'material_add',
    component: () => import(/* webpackChunkName: "material.chunk" */ '@/views/material/Add'),
    meta: {
      title: 'Tambah Material',
      requiresAuth: true,
      allowRole: ['admin', 'leader']
    }
  },
  {
    path: '/material/view/:id',
    name: 'material_view',
    component: () => import(/* webpackChunkName: "material.chunk" */ '@/views/material/View'),
    props: true,
    meta: {
      title: 'Detail Material',
      requiresAuth: true,
      allowRole: ['admin', 'leader']
    }
  },
  {
    path: '/material/edit/:id',
    name: 'material_edit',
    component: () => import(/* webpackChunkName: "material.chunk" */ '@/views/material/Edit'),
    props: true,
    meta: {
      title: 'Edit Material',
      requiresAuth: true,
      allowRole: ['admin', 'leader']
    }
  }
  // END PARFUM
]
