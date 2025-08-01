import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Page from '../views/Single.vue'
import Category from '../views/Category.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/category/:slug', component: Category },
  { path: '/:slug', component: Page }, // catch-all for WP pages by slug
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
