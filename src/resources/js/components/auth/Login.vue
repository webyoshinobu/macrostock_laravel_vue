<template>
    <section class="login">
        <div class="">
            <form method="post" class="form" @submit.prevent="clickLogin">
                <!-- laravelのトークンを使用 -->
                <input type="hidden" name="_token" :value="token">

                <label for="login-email">Email</label>
                <input type="text" class="form__item" id="login-email" v-model="loginForm.email">
                <label for="login-password">Password</label>
                <input type="password" class="form__item" id="login-password" v-model="loginForm.password">
                <div class="form__button">
                <button type="submit" class="button button--inverse">login</button>
                </div>
            </form>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { storeToRefs } from 'pinia';
import { useRoute, useRouter } from 'vue-router';
import { auth } from '../../../../store/auth';

export default defineComponent({
    name: 'Login',
    components: {

    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const { login } = auth();
        const loginForm = {
            email: '',
            password: ''
        };
        const token = auth().csrf;

        // methods
        const clickLogin = () => {
            console.log('loginForm', loginForm)
            const data = loginForm;
            login(data);

            // トップページに移動する
            router.push('/')
        }

        return { router, route, loginForm, clickLogin, token };
    }

});
</script>

<style lang="scss" scoped>
.login {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;
}

</style>
