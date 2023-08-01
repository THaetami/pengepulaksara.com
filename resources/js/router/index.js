import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../pages/HomePage.vue'
import UserPage from '../pages/UserPage.vue'
import SearchPage from '../pages/SearchPage.vue'
import DetailPage from '../pages/DetailPage.vue'
// import NotFound from '../pages/NotFoundPage.vue'
import LoginPage from '../pages/LoginPage.vue'
import RegisterPage from '../pages/RegisterPage.vue'
import LikePage from '../pages/LikePage.vue'
import SastraUser from '../pages/SastraUser.vue'
import ProfilePage from '../pages/ProfilePage.vue'
import axios from 'axios'


const guest = (to, from, next) => {
    axios.get('/api/check')
      .then(response => {
        console.log(response)
        return next("/");
      })
      .catch(error => {
        console.log(error)
        return next();
      });
  };

  const auth = (to, from, next) => {
    axios.get('/api/check')
      .then(response => {
        console.log(response)
        return next();
      })
      .catch(error => {
        console.log(error)
        return next("/search");
      });
  };


const router = createRouter({
  history: createWebHistory(),
  linkExactActiveClass: 'aktip',
  routes: [
    // {
    //     path: '/:pathMatch(.*)*',
    //     name: NotFound,
    //     component: NotFound,
    //     redirect: '/'
    // },
    {
      path: '/guest/ready/login',
      name: 'LoginPage',
      component: LoginPage,
      beforeEnter: guest
    },
     {
      path: '/guest/ready/register',
      name: 'RegisterPage',
      component: RegisterPage,
      beforeEnter: guest
    },
    {
      path: '/',
      name: 'HomePage',
      component: HomePage,
      beforeEnter: auth
    },
    {
      path: '/profile',
      name: 'ProfilePage',
      component: ProfilePage,
      beforeEnter: auth
    },
    {
      path: '/u',
      name: 'UserPage',
      component: UserPage,
      children: [
        {
            path: ':username',
            name: 'SastraUser',
            component: SastraUser,
        },
        {
            path: ':username/likes',
            name: 'LikePage',
            component: LikePage,
            beforeEnter: auth
        }
      ]
    },
    {
        name: 'SearchPage',
        path: '/search',
        component: SearchPage,
    },
    {
        name: 'DetailPage',
        path: '/sastra/:slug',
        component: DetailPage,
    }
  ]
})


export default router
