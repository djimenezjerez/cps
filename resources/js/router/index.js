// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Root',
    component: () => import('@/views/Login.vue'),
  }, {
    path: '/credentials',
    component: () => import('@/layouts/default/Default.vue'),
    children: [
      {
        path: '',
        name: 'CredentialsIndex',
        component: () => import('@/components/credentials/Index.vue'),
      }, {
        path: ':id',
        name: 'CredentialsForm',
        component: () => import('@/components/credentials/Form.vue'),
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
