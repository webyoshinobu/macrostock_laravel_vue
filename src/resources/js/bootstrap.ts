// window._ = require('lodash');

// try {
//     require('bootstrap');
// } catch (e) {}

// /**
//  * We'll load the axios HTTP library which allows us to easily issue requests
//  * to our Laravel back-end. This library automatically handles sending the
//  * CSRF token as a header based on the value of the "XSRF" token cookie.
//  */

// window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// /**
//  * Echo exposes an expressive API for subscribing to channels and listening
//  * for events that are broadcast by Laravel. Echo and event broadcasting
//  * allows your team to easily build robust real-time web applications.
//  */

// // import Echo from 'laravel-echo';

// // window.Pusher = require('pusher-js');

// // window.Echo = new Echo({
// //     broadcaster: 'pusher',
// //     key: process.env.MIX_PUSHER_APP_KEY,
// //     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
// //     forceTLS: true
// // });

// ---------------------------
// import { getCookieValue } from './util'

// window.axios = require('axios')

// // Ajaxリクエストであることを示すヘッダーを付与する
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// window.axios.interceptors.request.use(config => {
//   // クッキーからトークンを取り出してヘッダーに添付する
//   config.headers['X-XSRF-TOKEN'] = getCookieValue('XSRF-TOKEN')

//   return config
// })
// ---------------------------

// ---------------------------
// window.axios = require('axios')

// //csrfを使える設定
// window.axios.defaults.headers.common = {
//     "X-Requested-With": "XMLHttpRequest",
//     "X-CSRF-TOKEN": document
//       .querySelector('meta[name="csrf-token"]')
//       .getAttribute("content"),
// };
// ---------------------------

import Axios, { AxiosStatic } from 'axios';

declare global {
  interface Window {
    axios: AxiosStatic;
  }
  interface Element {
    content: string;
  }
}

export default function bootstrap() {

  window.axios = Axios;

  window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

  let token = document.head.querySelector('meta[name="csrf-token"]');

  if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
  } else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
  }

}
