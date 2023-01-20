import { createRouter, createWebHistory } from 'vue-router';
import { reactive } from "vue" //リアクティブメソッドを呼び出し
import top from "./components/Top.vue";
import gallery from "./components/gallery/Gallery.vue";
import photo from "./components/gallery/Photo.vue";
import contact from "./components/contact/Contact.vue";
import register from "./components/auth/Register.vue";
import cart from "./components/cart/Cart.vue";
import thanks from "./components/Thanks.vue";
// const storage = gallery(); //外部ファイルに格納したデータを格納
// const state = reactive({ //格納したオブジェクトstorageをリアクティブメソッドで値渡しにする
// 	storage:storage
// });

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
