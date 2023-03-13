import { storeToRefs } from 'pinia';
import { auth } from '../../store/auth';
import { createRouter, createWebHistory } from 'vue-router';
import { watch } from "vue"
import top from "./components/Top.vue";
import gallery from "./components/gallery/Gallery.vue";
import photo from "./components/gallery/Photo.vue";
import contact from "./components/contact/Contact.vue";
import login from "./components/auth/Login.vue";
import register from "./components/auth/Register.vue";
import userMypage from "./components/auth/UserMypage.vue";
import userOrderHistory from "./components/auth/UserOrderHistory.vue";
import userChangeEmail from "./components/auth/UserChangeEmail.vue";
import userChangePassword from "./components/auth/UserChangePassword.vue";
import userDeleteAccount from "./components/auth/UserDeleteAccount.vue";
import admin from "./components/admin/AdminLogin.vue";
import adminRegister from "./components/admin/AdminRegister.vue";
import adminMypage from "./components/admin/AdminMypage.vue";
import adminChangeEmail from "./components/admin/AdminChangeEmail.vue";
import adminChangePassword from "./components/admin/AdminChangePassword.vue";
import cart from "./components/cart/Cart.vue";
import thanks from "./components/Thanks.vue";
import systemError from "./components/errors/System.vue";
import NotFound from "./components/errors/NotFound.vue";

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
            // console.log('router.ts gallery route', route);
            // console.log('router.ts page', page);
            return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 }
        }
    },
    {
        // path: '/gallery/photo/:index?/:src?/:alt?',
        path: '/gallery/photo/:id?/:filename?/:price?/:url?/:owner?',
        // path: '/gallery/photo/:id?/:filename?/:price?/:owner?',
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
    },
    {
        path: '/register',
        name: 'register',
        component: register
    },
    {
        path: '/mypage',
        name: 'mypage',
        component: userMypage
    },
    {
        path: '/orderHistory',
        name: 'orderHistory',
        component: userOrderHistory
    },
    {
        path: '/changeEmail',
        name: 'changeEmail',
        component: userChangeEmail
    },
    {
        path: '/changePassword',
        name: 'changePassword',
        component: userChangePassword
    },
    {
        path: '/deleteAccount',
        name: 'deleteAccount',
        component: userDeleteAccount
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
        path: '/admin/changeEmail',
        name: 'admin/changeEmail',
        component: adminChangeEmail
    },
    {
        path: '/admin/changePassword',
        name: 'admin/changePassword',
        component: adminChangePassword
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
    {
        // path: '*',
        path: '/:catchAll(.*)',
        name: 'NotFound',
        component: NotFound
    },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

export default router;
