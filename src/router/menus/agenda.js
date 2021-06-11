export default [
  // ROUTES PARFUM START HERE
  {
    path: '/agenda',
    name: 'agenda',
    component: () => import(/* webpackChunkName: "agenda.chunk" */ '@/views/agenda/Index'),
    meta: {
      title: 'Agenda',
      icon: 'mdi-calendar-month-outline',
      // subheader: 'Data Master',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/agenda/baru',
    name: 'agenda_add',
    component: () => import(/* webpackChunkName: "agenda.chunk" */ '@/views/agenda/Add'),
    meta: {
      title: 'Tambah Agenda',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/agenda/view/:id',
    name: 'agenda_view',
    component: () => import(/* webpackChunkName: "agenda.chunk" */ '@/views/agenda/View'),
    props: true,
    meta: {
      title: 'Detail Agenda',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  },
  {
    path: '/agenda/edit/:id',
    name: 'agenda_edit',
    component: () => import(/* webpackChunkName: "agenda.chunk" */ '@/views/agenda/Edit'),
    props: true,
    meta: {
      title: 'Edit Agenda',
      requiresAuth: true,
      allowRole: ['Super Admin', 'Administrator']
    }
  }
  // END PARFUM
]
