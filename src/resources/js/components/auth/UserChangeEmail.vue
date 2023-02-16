<template>
    <section class="userchangeemail">
        <h2 class="userchangeemail_title">{{ ( userInfo || {} ).name }}様マイページ</h2>
        <div class="userchangeemail_wrap">
            <div class="userchangeemail_wrap_title">メールアドレス変更</div>
            <form method="post" class="userchangeemail_wrap_form" @submit.prevent="clickRegister">
                <!-- laravelのトークンを使用 -->
                <!-- <input type="hidden" name="_token" :value="token"> -->

                <!-- エラーメッセージ -->
                <div v-if="changeEmailErrorsCurrentEmail" class="errors">{{changeEmailErrorsCurrentEmail}}</div>
                <div v-if="changeEmailErrorsNewemail" class="errors">
                    <ul v-if="changeEmailErrorsNewemail.new_email">
                        <li v-for="msg in changeEmailErrorsNewemail.new_email" :key="msg">
                            {{ msg }}
                        </li>
                    </ul>
                </div>

                <div class="userchangeemail_wrap_form_line">
                    <label class="userchangeemail_wrap_form_line_label" for="userchangeemail_form_email">現在のメールアドレス</label>
                    <input type="text" class="userchangeemail_wrap_form_line_input" id="userchangeemail_form_email" v-model="changeForm.current_email">
                </div>

                <div class="userchangeemail_wrap_form_line">
                    <label class="userchangeemail_wrap_form_line_label" for="userchangeemail_form_newemail">新しいメールアドレス</label>
                    <input type="text" class="userchangeemail_wrap_form_line_input" id="userchangeemail_form_newemail" v-model="changeForm.new_email">
                </div>

                <div class="userchangeemail_wrap_form_line">
                    <label class="userchangeemail_wrap_form_line_label" for="userchangeemail_form_newemail_confirmation">新しいメールアドレス(確認)</label>
                    <input type="text" class="userchangeemail_wrap_form_line_input" id="userchangeemail_form_newemail_confirmation" v-model="changeForm.new_email_confirmation">
                </div>

                <div class="userchangeemail_wrap_form_button">
                    <ButtonRed @click="clickChangeEmail">変更する</ButtonRed>
                    <router-link to="/mypage"><ButtonWhite class="margin-left">マイページトップへ戻る</ButtonWhite></router-link>
                </div>

            </form>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent, ref, computed, onMounted, reactive, watch, nextTick } from "vue"
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'
import { auth } from '../../../../store/auth'
import ButtonRed from "../common/ButtonRed.vue"
import ButtonWhite from "../common/ButtonWhite.vue"
import Message from "../Message.vue"
import Loader from "../Loader.vue"
import axios from "axios";
import { OK, UNPROCESSABLE_ENTITY } from '../../util'

export default defineComponent({
    name: 'UserChangeEmail',
    components: {
        ButtonWhite,
        ButtonRed,
        Loader,
        Message,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const authStore = auth();
        const { changeEmail, resetChangeEmailMessage } = authStore;
        const { userInfo, changeEmailStatus, changeEmailErrorMessagesCurrentEmail, changeEmailErrorMessagesNewemail } = storeToRefs(authStore);
        const changeForm = ref({
            current_email: '',
            new_email: '',
            new_email_confirmation: '',
        });

        const changeEmailErrorsCurrentEmail = computed(() => {
            return authStore.changeEmailErrorMessagesCurrentEmail
        })

        const changeEmailErrorsNewemail = computed(() => {
            return authStore.changeEmailErrorMessagesNewemail
        })

        const clickChangeEmail = async() => {

            await changeEmail(changeForm.value)

            if(authStore.changePasswordStatus === OK){
                router.push({ name: 'mypage' })
            }else{
                resetInputs()
            }
        }

        const resetInputs = () => {
            changeForm.value = {
                current_email: '',
                new_email: '',
                new_email_confirmation: '',
            }
        }

        const clearError = () => {
            resetChangeEmailMessage(null)
            console.log('clearError');
        }

        onMounted(() => {
            clearError();
        });

        return { router, route, onMounted, watch, userInfo, changeForm, clickChangeEmail, changeEmailErrorsCurrentEmail, changeEmailErrorsNewemail };
    },

});
</script>

<style lang="scss" scoped>
.userchangeemail {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    &_title {
        font-size: 70px;
        margin-bottom: 50px;
    }

    &_wrap{

        &_title {
            background-color: #000000;
            color: #ffffff;
            font-size: 36px;
            font-weight: bold;
            padding: 18.5px 0 18.5px 10px;
        }

        &_form {
            border: 2px solid #000000;
            padding: 20px;
            font-size: 36px;

            &_line {
                padding: 20px;
                display: flex;

                &_label {
                    width: 40%;
                }

                &_input {
                    width: 60%;
                }

            }

            &_button {
                display: flex;
                justify-content: center;
            }
        }
    }
}

.margin-left {
    margin: 0 0 0 10px;
}

.errors {
    margin: 0 0 20px 0;
    font-size: 24px;
    color: red;
    font-weight: bold;

    ul {
        list-style: none;
    }
}

</style>
