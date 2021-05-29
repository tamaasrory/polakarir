export default [
  {
    path: '/user',
    name: 'user',
    component: () => import(/* webpackChunkName: "users.chunk" */ '@/views/user/Index'),
    meta: {
      title: 'User',
      icon: 'mdi-account-circle',
      subheader: 'Data Master',
      requiresAuth: true,
      allowRole: ['admin']
    }
  },
  {
    path: '/user/baru',
    name: 'user_add',
    component: () => import(/* webpackChunkName: "users.chunk" */ '@/views/user/Add'),
    meta: {
      title: 'Tambah User',
      requiresAuth: true,
      allowRole: ['admin']
    }
  },
  {
    path: '/user/view/:id',
    name: 'user_view',
    component: () => import(/* webpackChunkName: "users.chunk" */ '@/views/user/View'),
    props: true,
    meta: {
      title: 'Detail User',
      requiresAuth: true,
      allowRole: ['admin']
    }
  },
  {
    path: '/user/edit/:id',
    name: 'user_edit',
    component: () => import(/* webpackChunkName: "users.chunk" */ '@/views/user/Edit'),
    props: true,
    meta: {
      title: 'Edit User',
      requiresAuth: true,
      allowRole: ['admin']
    }
  }
]
