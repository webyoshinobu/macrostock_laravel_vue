<template>
    <section class="register">
        <h2 class="register_title">会員登録(無料)</h2>
        <!-- <div class=""> -->
            <form method="post" class="register_form" @submit.prevent="clickRegister">
                <!-- laravelのトークンを使用 -->
                <input type="hidden" name="_token" :value="token">

                <div class="register_form_line">
                    <label for="register_form_username">氏名</label>
                    <input type="text" class="register_form_line_username" id="register_form_username" v-model="registerForm.name">
                </div>

                <div class="register_form_line">
                    <label for="register_form_email">メールアドレス</label>
                    <input type="text" class="register_form_line_email" id="register_form_email" v-model="registerForm.email">
                </div>

                <div class="register_form_line">
                    <label for="register_form_pass">パスワード</label>
                    <input type="password" class="register_form_line_pass" id="register_form_pass" v-model="registerForm.password">
                </div>

                <div class="register_form_line">
                    <label for="register_form_passconfirmation">パスワード(確認)</label>
                    <input type="password" class="register_form_line_passconfirmation" id="register_form_passconfirmation" v-model="registerForm.password_confirmation">
                </div>

                <div class="register_form_line">
                    <input id="register_form_checkbox" type="checkbox">
                    <label for="register_form_checkbox" >Macro Stock利用規約に同意する（ご登録前に必ずご確認ください。）</label>
                </div>

                <div class="register_form_submit">
                    <ButtonOrange class="register_form_submit_button" type="submit">確認</ButtonOrange>
                </div>
            </form>
        <!-- </div> -->
    </section>

</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { storeToRefs } from 'pinia';
import { useRoute, useRouter } from 'vue-router';
import { auth } from '../../../../store/auth';
import ButtonOrange from "../common/ButtonOrange.vue";

export default defineComponent({
    name: 'Register',
    components: {
        ButtonOrange,
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

        const clickRegister = () => {
            console.log('registerForm', registerForm);
            const data = registerForm;
            // authストアのresigterアクションを呼び出す
            register(data);

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

    &_form {
        display: flex;
        flex-flow: column;
    }
}

</style>
