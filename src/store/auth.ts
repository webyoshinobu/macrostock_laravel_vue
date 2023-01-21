import { defineStore } from 'pinia'
import axios from "axios"

type USER = {
    name: string,
    email: string,
    password: string,
}

// declare const validPassword: unique symbol;
// type Password = string & { validPassword: never }
// type USER = {
//     name: String,
//     email: String,
//     password: Password,
// }

export const auth = defineStore('auth', {
    state: () => ({
        user: null as USER|null,
        csrf: document.querySelector('meta[name="csrf-token"]')!.getAttribute('content'),
    }),
    getters: ({
        isLoggedIn: (state) => state.user !== null,
        userInfo: state => state.user ? state.user : null,
    }),
    actions: {
        async register (data:any) {
            this.user = data;
            const response = await axios.post('/api/register', data);
            this.user = response.data;
        },

        async login (data:any) {
            const response = await axios.post('/api/login', data);
            console.log('auth.ts login data', response.data);
            this.user = response.data;
        },

        async logout () {
            const response = await axios.post('/api/logout');
            this.user = null;
        },

        async currentUser () {
            const response = await axios.get('/api/user');
            const user = response.data || null;
            this.user = user;
          }
    },
  })
