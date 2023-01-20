<template>
    <section class="login">
        <div class="panel">
            <form method="post" class="form">
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

export default defineComponent({
    name: 'Login',
    components: {

    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const loginForm = {
            email: '',
            password: ''
        };

        // methods
        const login = () => {
            console.log(loginForm)
        }

        return { router, route, loginForm, login };
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
