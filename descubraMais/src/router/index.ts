import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
    {
      path: '/cadastroUsuario',
      name: 'cadastroUsuario',
      component: () => import('../views/cadastroUsuario.vue'),
    },
    {
      path: '/cadastroGuia',
      name: 'cadastroGuia',
      component: () => import('../views/cadastroGuia.vue'),
    },
    {
      path: '/adicionarPontoTuristico',
      name: 'AdicionarPontoTuristico',
      component: () => import('../views/AdicionarPontoTuristico.vue'),
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/LoginView.vue'),
    },
    {
      path: '/cadastroTurista',
      name: 'cadastroTurista',
      component: () => import('../views/cadastroTurista.vue'),
    },
  ],
})

export default router
