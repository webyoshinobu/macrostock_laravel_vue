<template>
    <section class="login">
        <h2 class="login_title">会員ログイン</h2>
        <form method="post" class="login_form" @submit.prevent="clickLogin">
            <!-- laravelのトークンを使用 -->
            <input type="hidden" name="_token" :value="token">

            <div v-if="loginErrors" class="errors">
                <ul v-if="loginErrors.email">
                    <li v-for="msg in loginErrors.email" :key="msg">
                        <!-- {{ msg }} -->
                        メールアドレスを入力してください。
                    </li>
                </ul>
                <ul v-if="loginErrors.password">
                    <li v-for="msg in loginErrors.password" :key="msg">
                        <!-- {{ msg }} -->
                        パスワードを入力してください。
                    </li>
                </ul>
            </div>

            <div class="login_form_line">
                <input class="login_form_line_input" type="text" id="login-email" v-model="loginForm.email" placeholder="メールアドレス">
            </div>

            <div class="login_form_line">
                <input type="password" class="login_form_line_input" id="login-password" v-model="loginForm.password" placeholder="パスワード">
            </div>

            <div class="login_form_submit">
                <ButtonWhite class="login_form_submit_button" type="submit">ログイン</ButtonWhite>
            </div>

        </form>

        <div class="login_explain">
            <p class="login_explain_word">パスワードをお忘れですか？</p>
            <p class="login_explain_word">会員登録はまだですか？</p>
        </div>

        <div class="login_toRegister">
            <router-link to="/register" class="header_nav_menu_item"><ButtonBlack class="login_toRegister_button">会員登録</ButtonBlack></router-link>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent, ref, computed, onMounted } from "vue";
import { storeToRefs } from 'pinia';
import { useRoute, useRouter } from 'vue-router';
import { auth } from '../../../../store/auth';
import ButtonWhite from "../common/ButtonWhite.vue";
import ButtonBlack from "../common/ButtonBlack.vue";

export default defineComponent({
    name: 'Login',
    components: {
        ButtonWhite,
        ButtonBlack,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const { login, setLoginErrorMessages } = auth();
        const loginForm = {
            email: '',
            password: ''
        };
        const token = auth().csrf;
        const { getApiStatus } = storeToRefs(auth());

        //computed
        const loginErrors = computed(() => {
            return auth().loginErrorMessages
        })

        // methods
        const clickLogin = async () => {
            // console.log('loginForm', loginForm)
            const data = loginForm;
            await login(data);

            const apiStatus = auth().getApiStatus
            console.log('login apiStatus', apiStatus);

            // トップページに移動する
            if (apiStatus == true) {
                router.push({ name: 'top' })
            }
        }

        const clearError = () => {
            setLoginErrorMessages(null)
            console.log('clearError');
        }

        onMounted(() => {
            clearError();
        });

        return { router, route, loginForm, clickLogin, token, loginErrors, clearError, onMounted };
    }

});
</script>

<style lang="scss" scoped>
.login {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    &_title {
        font-size: 70px;
        margin-bottom: 50px;
    }

    &_form {
        display: flex;
        flex-flow: column;

        &_line {
            font-size: 36px;
            border-bottom: solid 2px #000000;

            &:not(:last-child) {
                margin: 0 0 50px 0;
            }

            &_input {
                width: 100%;
                border: none;
                outline: none;
            }
        }

        &_submit {
            display: flex;
            justify-content: center;
        }
    }

    &_explain {
        font-size: 24px;
        padding: 0 10%;

        &_word {
        display: flex;
        justify-content: center;
        padding: 20px 0;

        &:not(:last-child) {
            border-bottom: solid 2px #000000;
        }
    }
    }

    &_toRegister {
        display: flex;
        justify-content: center;
    }
}

.errors {
    margin: 0 0 20px 0;

    ul {
        list-style: none;
        font-size: 24px;
        color: red;
        font-weight: bold;
    }
}

</style>
