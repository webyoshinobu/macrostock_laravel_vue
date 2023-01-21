import { createRouter, createWebHistory } from 'vue-router';
import { reactive } from "vue" //リアクティブメソッドを呼び出し
import top from "./components/Top.vue";
import gallery from "./components/gallery/Gallery.vue";
import photo from "./components/gallery/Photo.vue";
import contact from "./components/contact/Contact.vue";
import login from "./components/auth/Login.vue";
import register from "./components/auth/Register.vue";
import cart from "./components/cart/Cart.vue";
import thanks from "./components/Thanks.vue";
import { auth } from '../../store/auth' // ★　追加

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
        props: true
    },
    // {
    //     path: '/gallery/photo',
    //     name: 'photo',
    //     component: photo,
    //     props: true
    // },
    {
        path: '/gallery/photo/:index?/:src?/:alt?',
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
        beforeEnter (to:any, from:any, next:any) {
            if (auth().isLoggedIn) {
              next('/')
            } else {
              next()
            }
        }
    },
    {
        path: '/register',
        name: 'register',
        component: register
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
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

export default router;
