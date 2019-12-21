import Vue from 'vue'
import VueRouter from 'vue-router'

import DashboardLayout from '../components/Dashboard/Layout/DashboardLayout.vue'
import DashboardLayoutAdmin from '../components/Dashboard/Layout/DashboardLayoutAdmin.vue'

// GeneralViews
import NotFound from '../components/GeneralViews/NotFoundPage.vue'
import Login from 'src/components/Dashboard/Views/Login.vue'

Vue.use(VueRouter)

const router = new VueRouter({
  // mode: 'history',
  routes: [
    {
      path: '/',
      name: 'landing',
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/404',
      component: NotFound
    },
    {
      path: '/loja',
      component: DashboardLayout,
      redirect: '/loja/produtos',
      meta: {
        requiresAuth: true
      },
      children: [
        {
          path: 'produtos',
          name: 'produtos',
          component: () => import('src/components/Dashboard/Views/Produtos.vue'),
          meta: {
            requiresAuth: true
          }
        }
      ]
    },
    {
      path: '/admin',
      component: DashboardLayoutAdmin,
      redirect: '/admin/produtos',
      meta: {
        requiresAuth: true
      },
      children: [
        {
          path: 'produtos',
          name: 'produtos',
          component: () => import('src/components/Dashboard/Views/AdminProdutos.vue'),
          meta: {
            requiresAuth: true
          }
        }
      ]
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (!localStorage.getItem('user') && to.name !== 'Login') {
    next({
      path: '/login'
    })
  } else if (to.name === 'landing') {
    next({
      path: '/loja'
    })
  } else {
    next()
  }
})

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default router
