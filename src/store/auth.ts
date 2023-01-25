import { defineStore } from 'pinia'
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../resources/js/util'
import { error } from './error'
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
        apiStatus: false,
        loginErrorMessages: null,
        registerErrorMessages: null,
        // loginStatus: false,
    }),
    getters: ({
        isLoggedIn: (state) => state.user !== null,
        userInfo: state => state.user ? state.user : null,
        getApiStatus: state => state.apiStatus,
    }),
    actions: {
        async register (data:any) {
            // this.user = data;
            // const response = await axios.post('/api/register', data);
            // this.user = response.data;

            this.user = null;
            const response = await axios.post('/api/register', data);
            if (response.status === CREATED) {
                this.apiStatus = true;
                this.user = response.data;
                return false
            }

            this.apiStatus = false;
            if (response.status === UNPROCESSABLE_ENTITY) {
                this.registerErrorMessages = response.data.errors
            } else {
                error().setCode(response.status);
            }
        },

        async login (data:any) {
            // const response = await axios.post('/api/login', data);
            // console.log('auth.ts login data', response.data);
            // this.user = response.data;

            // this.apiStatus = false
            const response = await axios.post('/api/login', data).
            catch(err => err.response || err);
            console.log('auth.ts login response.status1', response.status);
            if (response.status === OK) {
                this.apiStatus = true;
                this.user = response.data;
                return false;
            }

            this.apiStatus = false;
            error().setCode(response.status);
            console.log('auth.ts login response.data', response.data);
            console.log('auth.ts login response.status2', response.status);
            console.log('auth.ts login this.apiStatus', this.apiStatus);

            if (response.status === UNPROCESSABLE_ENTITY) {
                this.loginErrorMessages = response.data.errors
            } else {
                error().setCode(response.status);
            }
        },

        async logout () {
            // const response = await axios.post('/api/logout');
            // this.user = null;

            this.apiStatus = false
            const response = await axios.post('/api/logout')

            if (response.status === OK) {
                this.apiStatus = true
                this.user = null;
                return false
            }

            this.apiStatus = false
            error().setCode(response.status);

        },

        async currentUser () {
            const response = await axios.get('/api/user');
            const user = response.data || null;
            this.user = user;
            // if(this.user == null) {
            //     this.loginStatus = false;
            //     console.log('currentUser this.loginStatus', this.loginStatus);
            // }else{
            //     this.loginStatus = true;
            //     console.log('currentUser this.loginStatus', this.loginStatus);
            // }
        },

        setLoginErrorMessages (messages:any) {
            this.loginErrorMessages = messages
        },

        setRegisterErrorMessages (messages:any) {
            this.registerErrorMessages = messages
        }
    },
  })
