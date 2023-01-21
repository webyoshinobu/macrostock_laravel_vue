import { createApp } from 'vue';
import { createPinia } from 'pinia';
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
import { auth } from '../../store/auth';

library.add(faInstagram);
bootstrap();

const app = createApp(App);
const pinia = createPinia();
const currentUser = async () => { auth().currentUser }

app.use(pinia);
app.use(router, VueAwesomeSwiper);
app.component('fa', FontAwesomeIcon );
// app.use(VueAwesomeSwiper, /* { default options with global component } */);
app.use(axios, {
    baseUrl: 'https://localhost:8001/',
});
app.use(currentUser);
app.mount("#app")
