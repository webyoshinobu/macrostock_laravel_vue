import { storeToRefs } from 'pinia';
import { auth } from '../../store/auth';
import { createRouter, createWebHistory } from 'vue-router';
import {  } from "vue"
import top from "./components/Top.vue";
import gallery from "./components/gallery/Gallery.vue";
import photo from "./components/gallery/Photo.vue";
import contact from "./components/contact/Contact.vue";
import login from "./components/auth/Login.vue";
import register from "./components/auth/Register.vue";
import admin from "./components/admin/AdminLogin.vue";
import adminRegister from "./components/admin/AdminRegister.vue";
import adminMypage from "./components/admin/AdminMypage.vue";
import cart from "./components/cart/Cart.vue";
import thanks from "./components/Thanks.vue";
import systemError from "./components/errors/System.vue";

const routes = [
    {
        path: '/',
        name: 'top',
        component: top
    },
    {
        path: '/gallery',
        name: 'gallery',
        component: gallery,
        // props: true
        props: (route:any) => {
            const page = route.query.page
            console.log('router.ts gallery route', route);
            console.log('router.ts page', page);
            return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 }
        }
    },
    {
        // path: '/gallery/photo/:index?/:src?/:alt?',
        path: '/gallery/photo/:id?/:url?/:owner?',
        name: 'photo',
        component: photo,
        props: true
    },
    {
        path: '/contact',
        name: 'contact',
        component: contact
    },
    {
        path: '/login',
        name: 'login',
        component: login,
        // meta: {
        //     requiresAuth: true
        // },

        // beforeEnter (to:any, from:any, next:any) {
        //     console.log('beforeEnter');
        //     const authStore = auth();
        //     const { isLoggedIn } = storeToRefs(authStore);
        //     if (!authStore.isLoggedIn) {
        //     // if (to.meta.requiresAuth && !authStore.isLoggedIn) {
        //         console.log(authStore.isLoggedIn);
        //         next();
        //     } else {
        //         console.log(authStore.isLoggedIn);
        //         next('/');
        //     }
        // }

        // beforeEnter: (to:any, from:any, next:any) => {
        //     console.log('beforeEnter');
        //     const authStore = auth();
        //     const { isLoggedIn } = storeToRefs(authStore);
        //     if (!authStore.isLoggedIn) {
        //         console.log('beforeEnter false')
        //         next();
        //     }else{
        //         console.log('beforeEnter true')
        //         next('/');
        //     }
        // },

    },
    {
        path: '/register',
        name: 'register',
        component: register
    },
    {
        path: '/admin/login',
        name: 'admin/login',
        component: admin
    },
    {
        path: '/admin/register',
        name: 'admin/register',
        component: adminRegister
    },
    {
        path: '/admin/mypage',
        name: 'admin/mypage',
        component: adminMypage
    },
    {
        path: '/cart',
        name: 'cart',
        component: cart
    },
    {
        path: '/thanks',
        name: 'thanks',
        component: thanks
    },
    {
        path: '/500',
        name: '500',
        component: systemError
    },
]

// function isLogin() {
//     const authStore = auth();
//     const { isLoggedIn } = storeToRefs(authStore);
//     console.log('isLogin', authStore.isLoggedIn);
//     return authStore.isLoggedIn;
// }

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

// router.beforeEach(async(to, from, next) => {
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//       if (isLogin()) {
//         console.log('authStore.isLoggedIn1',isLogin());
//         // next({
//         //   path: '/',
//         //   query: {
//         //     redirect: to.fullPath
//         //   }
//         // })
//         // next('/login')
//         next({name: 'top'});
//       } else {
//         console.log('authStore.isLoggedIn2',isLogin());
//         next();
//       }
//     } else {
//         console.log('authStore.isLoggedIn3',isLogin());
//         next();
//     }
//     console.log('authStore.isLoggedIn4',isLogin());
// });

// router.beforeEach(async (to, from) => {
//     const authStore = auth();
//     const { isLoggedIn } = storeToRefs(authStore);
//     // canUserAccess() returns `true` or `false`
//     const canAccess = await authStore.isLoggedIn
//     if (!canAccess) {
//         return '/'
//     }else{
//         return '/login'
//     }
// })

export default router;
