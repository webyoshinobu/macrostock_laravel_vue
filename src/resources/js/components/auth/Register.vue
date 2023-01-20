<template>
    <section class="register">
        <div class="">
            <form method="post" class="form" @submit.prevent="clickRegister">
                <input type="hidden" name="_token" :value="token">
                <label for="username">Name</label>
                <input type="text" class="" id="username" v-model="registerForm.name">
                <label for="email">Email</label>
                <input type="text" class="" id="email" v-model="registerForm.email">
                <label for="password">Password</label>
                <input type="password" class="" id="password" v-model="registerForm.password">
                <label for="password-confirmation">Password (confirm)</label>
                <input type="password" class="" id="password-confirmation" v-model="registerForm.password_confirmation">
                <div class="">
                    <button type="submit" class="">register</button>
                </div>
            </form>
        </div>
    </section>

</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { storeToRefs } from 'pinia';
import { useRoute, useRouter } from 'vue-router';
import { auth } from '../../../../store/auth';

export default defineComponent({
    name: 'Register',
    components: {

    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const { register } = auth();
        const registerForm = {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        };
        const token = auth().csrf;

        // methods

        const clickRegister = (data:any) => {
            console.log('registerForm', registerForm);
            // authストアのresigterアクションを呼び出す
            register(registerForm);

            // トップページに移動する
            // router.push('/')
        }

        onMounted(() => {
            // console.log('csrf', token);
        });

        return { router, route, registerForm, token, clickRegister, register };
    }

});
</script>

<style lang="scss" scoped>
.register {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;
}

</style>
