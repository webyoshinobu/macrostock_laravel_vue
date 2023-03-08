<template>
    <section class="adminRegister">
        <h2 class="adminRegister_title">管理者登録</h2>
        <!-- <div class=""> -->
            <form method="post" class="adminRegister_form" @submit.prevent="clickRegister">
                <!-- laravelのトークンを使用 -->
                <input type="hidden" name="_token" :value="token">

                <div v-if="registerErrors" class="errors">
                    <ul v-if="registerErrors.name">
                        <li v-for="msg in registerErrors.name" :key="msg">
                            {{ msg }}
                        </li>
                    </ul>
                    <ul v-if="registerErrors.email">
                        <li v-for="msg in registerErrors.email" :key="msg">
                            {{ msg }}
                        </li>
                    </ul>
                    <ul v-if="registerErrors.password">
                        <li v-for="msg in registerErrors.password" :key="msg">
                            {{ msg }}
                        </li>
                    </ul>
                </div>

                <div class="adminRegister_form_line">
                    <label class="adminRegister_form_line_label" for="adminRegister_form_username">氏名</label>
                    <input type="text" class="adminRegister_form_line_input" id="adminRegister_form_username" v-model="registerForm.name">
                </div>

                <div class="adminRegister_form_line">
                    <label class="adminRegister_form_line_label" for="adminRegister_form_email">メールアドレス</label>
                    <input type="text" class="adminRegister_form_line_input" id="adminRegister_form_email" v-model="registerForm.email">
                </div>

                <div class="adminRegister_form_line">
                    <label class="adminRegister_form_line_label" for="adminRegister_form_pass">パスワード</label>
                    <input type="password" class="adminRegister_form_line_input" id="adminRegister_form_pass" v-model="registerForm.password">
                </div>

                <div class="adminRegister_form_line">
                    <label class="adminRegister_form_line_label" for="adminRegister_form_passconfirmation">パスワード(確認)</label>
                    <input type="password" class="adminRegister_form_line_input" id="adminRegister_form_passconfirmation" v-model="registerForm.password_confirmation">
                </div>

                <div class="adminRegister_form_submit">
                    <ButtonOrange class="adminRegister_form_submit_button" type="submit">登録</ButtonOrange>
                </div>
            </form>
        <!-- </div> -->
    </section>

</template>

<script lang="ts">
import { defineComponent, ref, onMounted, computed } from "vue";
import { storeToRefs } from 'pinia';
import { useRoute, useRouter } from 'vue-router';
import { auth } from '../../../../store/auth';
import ButtonOrange from "../common/ButtonOrange.vue";

export default defineComponent({
    name: 'AdminRegister',
    components: {
        ButtonOrange,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const { adminRegister, setRegisterErrorMessages } = auth();
        const registerForm = {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        };
        const token = auth().csrf;
        const { getApiStatus } = storeToRefs(auth());

        //computed
        const registerErrors = computed(() => {
            return auth().registerErrorMessages
        })

        // methods
        const clickRegister = async () => {
            // console.log('registerForm', registerForm);
            const data = registerForm;
            // authストアのresigterアクションを呼び出す
            await adminRegister(data);

            const apiStatus = auth().getApiStatus;
            // console.log('register apiStatus', apiStatus);
            auth().currentAdmin();

            // トップページに移動する
            if (apiStatus == true) {
                router.push({ name: 'top' })
            }
        }

        const clearError = () => {
            setRegisterErrorMessages(null)
            console.log('clearError');
        }

        onMounted(() => {
            clearError();
        });

        return { router, route, registerForm, token, clickRegister, adminRegister, registerErrors, clearError };
    }

});
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.adminRegister {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    @include sm {
        padding: 107px 10% 100px 10%;
    }

    &_title {
        // font-size: 70px;
        @include f-80;
        margin-bottom: 50px;

        @include sm {
            @include f-33;
            margin-bottom: 30px;
        }
    }

    &_form {
        display: flex;
        flex-flow: column;

        &_line {
            display: flex;
            // font-size: 36px;
            @include f-36;

            @include md {
                flex-direction: column;
            }

            &:not(:last-child) {
                margin: 0 0 20px 0;
            }

            &_label {
                width: 30%;

                @include md {
                    width: 100%;
                }
            }

            &_input {
                width: 70%;

                @include md {
                    width: 100%;
                }
            }
        }

        &_term {
            margin: 0 0 20px 30%;
            // font-size: 24px;
            @include f-24;

            @include md {
                margin: 0 0 20px 0;
            }

            &_checkbox {
                transform: scale(2);
            }

            &_link {
                margin: 0 0 0 20px;
            }
        }

        &_submit {
            display: flex;
            justify-content: center;

            &_button {
                @include f-24;
                width: 150px;
            }
        }
    }
}

.errors {
    margin: 0 0 20px 0;

    ul {
        list-style: none;
        // font-size: 24px;
        @include f-24;
        color: red;
        font-weight: bold;
    }
}

</style>
