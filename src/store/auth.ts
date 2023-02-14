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
// type ADMIN = {
//     admin_name: string,
//     admin_email: string,
//     admin_password: Password,
// }

type ADMIN = {
    admin_name: string,
    admin_email: string,
    admin_password: string,
    admin_flag: number,
}

export const auth = defineStore('auth', {
    state: () => ({
        //-------------------
        //ユーザー関連
        //-------------------
        user: null as USER|null,
        csrf: document.querySelector('meta[name="csrf-token"]')!.getAttribute('content'),
        apiStatus: false,
        loginErrorMessages: null,
        registerErrorMessages: null,

        //-------------------
        //管理者関連
        //-------------------
        adminUser: null as ADMIN|null,
        adminRegisterErrorMessages: null,
        adminFlag: null,
    }),
    getters: ({
        //ユーザー、管理者共用
        isLoggedIn: (state) => state.user !== null || state.adminUser !== null,
        userInfo: state => state.user ? state.user : null || state.adminUser ? state.adminUser : null,
        getApiStatus: state => state.apiStatus,
        //管理者
        getAdminFlag: state => state.adminFlag,
    }),
    actions: {
        //-------------------
        //ユーザー関連
        //-------------------
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
                // this.apiStatus = true
                this.apiStatus = false;
                this.user = null;
                return false
            }

            this.apiStatus = false
            error().setCode(response.status);

        },

        async currentUser () {
            // const response = await axios.get('/api/user');
            // const user = response.data || null;
            // this.user = user;

            this.apiStatus = false
            const response = await axios.get('/api/user')
            console.log('auth.ts currentUser response.data', response.data);
            const user = response.data || null
            console.log('auth.ts currentUser user', user);

            if (response.status === OK) {
                this.apiStatus = true
                this.user = user
                return false
            }

            this.apiStatus = false;
            error().setCode(response.status);
        },

        //-------------------
        //管理者関連
        //-------------------
        async adminRegister (data:any) {
            this.adminUser = null;
            const response = await axios.post('/api/admin/register', data);
            if (response.status === CREATED) {
                this.apiStatus = true;
                this.adminUser = response.data;
                return false
            }

            this.apiStatus = false;
            if (response.status === UNPROCESSABLE_ENTITY) {
                this.registerErrorMessages = response.data.errors
            } else {
                error().setCode(response.status);
            }
        },

        async adminLogin (data:any) {
            // const response = await axios.post('/api/login', data);
            // console.log('auth.ts login data', response.data);
            // this.user = response.data;

            // this.apiStatus = false
            const response = await axios.post('/api/admin/login', data).
            catch(err => err.response || err);
            console.log('adminLogin data', data);
            console.log('auth.ts login response.status1', response.status);
            if (response.status === OK) {
                this.apiStatus = true;
                this.adminUser = response.data;
                this.adminFlag = response.data.admin_flag;
                console.log('adminLogin this.adminFlag', this.adminFlag);
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

        async adminLogout () {
            // const response = await axios.post('/api/logout');
            // this.user = null;

            this.apiStatus = false
            const response = await axios.post('/api/admin/logout')

            if (response.status === OK) {
                // this.apiStatus = true
                this.apiStatus = false
                this.adminUser = null;
                this.adminFlag = null;
                return false
            }

            this.apiStatus = false;
            this.adminFlag = null;
            error().setCode(response.status);

        },

        async currentAdmin () {
            // const response = await axios.get('/api/user');
            // const user = response.data || null;
            // this.user = user;

            this.apiStatus = false
            const response = await axios.get('/api/admin');
            console.log('auth.ts currentUser response.data', response.data);
            const admin = response.data || null
            console.log('auth.ts currentUser admin', admin);

            if (response.status === OK) {
                this.apiStatus = true
                this.adminUser = admin
                return false
            }

            this.apiStatus = false;
            error().setCode(response.status);
        },

        //-------------------
        //ユーザー、管理者共通
        //-------------------

        setLoginErrorMessages (messages:any) {
            this.loginErrorMessages = messages
        },

        setRegisterErrorMessages (messages:any) {
            this.registerErrorMessages = messages
        },
        setAuth (status:any) {
            this.user = status
            this.adminUser = status
        }

    },
  })
