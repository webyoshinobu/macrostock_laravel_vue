<template>
    <section class="register">

        <Indicator :isLoading="isLoading"></Indicator>

        <h2 class="register_title">会員登録(無料)</h2>
        <!-- <div class=""> -->
            <form method="post" class="register_form" @submit.prevent="clickRegister">
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
                <div v-if="term_error" class="errors">
                    <ul>
                        <li>{{ term_error }}</li>
                    </ul>
                </div>

                <div class="register_form_line">
                    <label class="register_form_line_label" for="register_form_username">氏名</label>
                    <input type="text" class="register_form_line_input" id="register_form_username" v-model="registerForm.name">
                </div>

                <div class="register_form_line">
                    <label class="register_form_line_label" for="register_form_email">メールアドレス</label>
                    <input type="text" class="register_form_line_input" id="register_form_email" v-model="registerForm.email">
                </div>

                <div class="register_form_line">
                    <label class="register_form_line_label" for="register_form_pass">パスワード</label>
                    <input type="password" class="register_form_line_input" id="register_form_pass" v-model="registerForm.password">
                </div>

                <div class="register_form_line">
                    <label class="register_form_line_label" for="register_form_passconfirmation">パスワード(確認)</label>
                    <input type="password" class="register_form_line_input" id="register_form_passconfirmation" v-model="registerForm.password_confirmation">
                </div>

                <div class="register_form_term">
                    <input class="register_form_term_checkbox" id="register_form_checkbox" type="checkbox" v-model="term_checked">
                    <!-- <label class="register_form_term_link" for="register_form_checkbox" >Macro Stock<span class="term">利用規約</span>に同意する（ご登録前に必ずご確認ください。）</label> -->
                    <label class="register_form_term_link">Macro Stock<span class="term" @click="termOpen">利用規約</span>に同意する（ご登録前に必ずご確認ください。）</label>
                </div>

                <div class="register_form_submit">
                    <ButtonOrange class="register_form_submit_button" type="submit">登録</ButtonOrange>
                </div>
            </form>
        <!-- </div> -->
        <!-- モーダルでTermで表示 -->
        <Term ref="term" />
    </section>

</template>

<script lang="ts">
import { defineComponent, ref, onMounted, computed } from "vue";
import { storeToRefs } from 'pinia';
import { useRoute, useRouter } from 'vue-router';
import { auth } from '../../../../store/auth';
import ButtonOrange from "../common/ButtonOrange.vue";
import Term from "../term.vue";
import Indicator from '../../Indicator.vue';

export default defineComponent({
    name: 'Register',
    components: {
        ButtonOrange,
        Term,
        Indicator,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const { register, setRegisterErrorMessages } = auth();
        const registerForm = {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        };
        const token = auth().csrf;
        const { getApiStatus } = storeToRefs(auth());
        let term = ref();
        let term_checked = ref(false);
        let term_error = ref('');
        let isLoading = ref(false);

        //computed
        const registerErrors = computed(() => {
            return auth().registerErrorMessages
        })

        // methods
        const termOpen = () => {
            term.value.openModal(); //子コンポーネント(term)の呼び出し
        }

        const clickRegister = async () => {
            isLoading.value = true
            // console.log('term_checked', term_checked);
            // console.log('registerForm', registerForm);
            if(term_checked.value == false) {
                term_error.value = '利用規約に同意をお願いいたします。'
                isLoading.value = false
                return term_error
            }

            const data = registerForm;
            // authストアのresigterアクションを呼び出す
            await register(data);

            const apiStatus = auth().getApiStatus
            console.log('register apiStatus', apiStatus);

            isLoading.value = false

            // トップページに移動する
            if (apiStatus == true) {
                router.push({ name: 'top' })
            }
        }

        const clearError = () => {
            setRegisterErrorMessages(null)
            term_error.value = ''
            console.log('clearError');
        }

        onMounted(() => {
            clearError();
        });

        return { router, route, registerForm, token, clickRegister, register, registerErrors, clearError, termOpen, term, term_checked, term_error, isLoading };
    }

});
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.register {
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

            // &:not(:last-child) {
                margin: 20px 0 20px 0;
            // }

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
            display: flex;

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
    margin: 0 0 0 0;

    ul {
        list-style: none;
        // font-size: 24px;
        @include f-24;
        color: red;
        font-weight: bold;
    }
}

.term {
    text-decoration: underline;
    cursor: pointer;
}

</style>
