import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { auth } from '../../store/auth';
import 'normalize.css';
import router from './router';
import App from './App.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faInstagram } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import VueAwesomeSwiper from 'vue-awesome-swiper';
import 'swiper/swiper-bundle.css';
import '../css/swiper.css'; //swiper専用スタイル
import axios from '../../plugins/axios';
import bootstrap from './bootstrap';

library.add(faInstagram);
bootstrap();

const app = createApp(App);
const pinia = createPinia();
app.use(pinia);
// ログイン後にページリロードした時に、ログイン状態を維持する場合、
//app.use(pinia);の後、以下の3行を記述しないとpiniaが動かないエラーが出る。
const authStore = auth()
const currentUser = async () => {
    await authStore.currentUser()
}
app.use(currentUser)

app.component('fa', FontAwesomeIcon );
// app.use(VueAwesomeSwiper, /* { default options with global component } */);
app.use(axios, {
    baseUrl: 'https://localhost:8001/',
});

app.use(router)

app.mount("#app")

// const app = createApp({

//     async setup() {
//         createPinia()
//         const authStore = auth()
//         // const currentUser = async () => {
//             await authStore.currentUser()
//         // }

//         return { createPinia, authStore }
//     },

//     components: { App },

// })
// app.component('fa', FontAwesomeIcon );
// // app.use(VueAwesomeSwiper, /* { default options with global component } */);
// app.use(axios, {
//     baseUrl: 'https://localhost:8001/',
// });

// app.use(router)

// app.mount("#app")
