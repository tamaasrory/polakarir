export default [
  // ROUTES roles START HERE
  {
    path: '/roles',
    name: 'roles',
    component: () => import(/* webpackChunkName: "roles.chunk" */ '@/views/roles/Index'),
    meta: {
      title: 'Roles',
      icon: 'mdi-key',
      requiresAuth: true,
      allowRole: ['Super Admin']
    }
  },
  {
    path: '/roles/baru',
    name: 'roles_add',
    component: () => import(/* webpackChunkName: "roles.chunk" */ '@/views/roles/Add'),
    meta: {
      title: 'Tambah Roles',
      requiresAuth: true,
      allowRole: ['Super Admin']
    }
  },
  {
    path: '/roles/view/:id',
    name: 'roles_view',
    component: () => import(/* webpackChunkName: "roles.chunk" */ '@/views/roles/View'),
    props: true,
    meta: {
      title: 'Detail Roles',
      requiresAuth: true,
      allowRole: ['Super Admin']
    }
  },
  {
    path: '/roles/edit/:id',
    name: 'roles_edit',
    component: () => import(/* webpackChunkName: "roles.chunk" */ '@/views/roles/Edit'),
    props: true,
    meta: {
      title: 'Edit Roles',
      requiresAuth: true,
      allowRole: ['Super Admin']
    }
  }
  // END roles
]
