import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { auth } from '../../store/auth';
import 'normalize.css';
import router from './router';
import App from './App.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faInstagram } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
// import VueAwesomeSwiper from 'vue-awesome-swiper';
import 'swiper/swiper-bundle.css';
import '../css/swiper.css'; //swiper専用スタイル
import axios from '../../plugins/axios';
import bootstrap from './bootstrap';
import { error } from '../../store/error';
import { message } from '../../store/message';
import VueElementLoading from "vue-element-loading";
// import '../../public/css/mediaQuery.css';
// import '../sass/prepends.scss';

// require('../../resources/sass/_mediaQuery.scss');

library.add(faInstagram)
bootstrap()

const app = createApp(App)
const pinia = createPinia()
app.use(pinia);
// ログイン後にページリロードした時に、ログイン状態を維持する場合、
//app.use(pinia);の後、以下の3行を記述しないとpiniaが動かないエラーが出る。
const authStore = auth()
const currentUser = async () => {
    await authStore.currentUser()
}
app.use(currentUser)

const currentAdmin = async () => {
    await authStore.currentAdmin()
}
app.use(currentAdmin)

app.component('fa', FontAwesomeIcon );

app.component("VueElementLoading", VueElementLoading);

app.use(axios, {
    baseUrl: 'https://localhost:8001/',
});

app.use(router)

const errorStore = error()
app.use(errorStore.setCode)

const messageStore = message()
app.use(messageStore.setContent)

app.mount("#app")
