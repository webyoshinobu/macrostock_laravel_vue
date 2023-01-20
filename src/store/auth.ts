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
        // user: [] as any[],
        user: [] as USER[],
        csrf: document.querySelector('meta[name="csrf-token"]')!.getAttribute('content'),
    }),
    getters: ({
        check: state => !! state.user,
        username: state => state.user ? state.user : ''
    }),
    actions: {
        async register (data:any) {
            this.user = data;
            const response = await axios.post('/api/register', data);
            this.user = response.data;
        }
    },
  })
