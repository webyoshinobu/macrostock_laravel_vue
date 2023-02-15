<template>
    <section class="userchangepassword">
        <h2 class="userchangepassword_title">{{ ( userInfo || {} ).name }}様マイページ</h2>
        <div class="userchangepassword_wrap">
            <div class="userchangepassword_wrap_title">パスワード変更</div>
            <form method="post" class="userchangepassword_wrap_form" @submit.prevent="clickRegister">
            <!-- laravelのトークンを使用 -->
            <!-- <input type="hidden" name="_token" :value="token"> -->

            <!-- <div v-if="error_current" class="errors">{{error_current}}</div> -->
            <!-- <div v-if="error_newpass" class="errors">
                <ul v-if="error_newpass.new_password">
                    <li v-for="msg in error_newpass.new_password" :key="msg">
                        {{ msg }}
                    </li>
                </ul>
            </div> -->

            <!-- エラーメッセージ -->
            <div v-if="changePasswordErrorsCurrent" class="errors">{{changePasswordErrorsCurrent}}</div>
            <div v-if="changePasswordErrorsNewpass" class="errors">
                <ul v-if="changePasswordErrorsNewpass.new_password">
                    <li v-for="msg in changePasswordErrorsNewpass.new_password" :key="msg">
                        {{ msg }}
                    </li>
                </ul>
            </div>

            <div class="userchangepassword_wrap_form_line">
                <label class="userchangepassword_wrap_form_line_label" for="userchangepassword_form_current_password">現在のパスワード</label>
                <input type="password" class="userchangepassword_wrap_form_line_input" id="userchangepassword_form_current_password" v-model="changeForm.current_password">
            </div>

            <div class="userchangepassword_wrap_form_line">
                <label class="userchangepassword_wrap_form_line_label" for="userchangepassword_form_newpassword">新しいパスワード</label>
                <input type="password" class="userchangepassword_wrap_form_line_input" id="userchangepassword_form_newpassword" v-model="changeForm.new_password">
            </div>

            <div class="userchangepassword_wrap_form_line">
                <label class="userchangepassword_wrap_form_line_label" for="userchangepassword_form_newpassword_confirmation">新しいパスワード(確認)</label>
                <input type="password" class="userchangepassword_wrap_form_line_input" id="userchangepassword_form_newpassword_confirmation" v-model="changeForm.new_password_confirmation">
            </div>

            <div class="userchangepassword_wrap_form_button">
                <ButtonRed @click="clickChangePassword">変更する</ButtonRed>
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
    name: 'UserChangePassword',
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
        const { changePassword, resetChangePasswordMessage } = authStore;
        const { userInfo, changePasswordStatus, changePasswordErrorMessagesCurrent, changePasswordErrorMessagesNewpass } = storeToRefs(authStore);
        let changeForm = ref({
            current_password: '',
            new_password: '',
            new_password_confirmation: '',
        });
        // const error_current = ref('')
        // const error_newpass = ref('')

        const changePasswordErrorsCurrent = computed(() => {
            return authStore.changePasswordErrorMessagesCurrent
        })

        const changePasswordErrorsNewpass = computed(() => {
            return authStore.changePasswordErrorMessagesNewpass
        })

        const clickChangePassword = async() => {
            // const response = await axios.post('api/changePassword', changeForm.value)
            // if(response.status == OK){
            //     router.push({ name: 'mypage' })
            // }else{
            //     error_current.value = response.data.errorCurrent
            //     error_newpass.value = response.data.errors
            //     resetInputs()
            // }

            await changePassword(changeForm.value)

            if(authStore.changePasswordStatus === OK){
                router.push({ name: 'mypage' })
            }else{
                // error_current.value = authStore.changePasswordErrorMessagesCurrent
                // error_newpass.value = authStore.changePasswordErrorMessagesNewpass
                resetInputs()
            }
        }

        const resetInputs = () => {
            changeForm.value = {
                current_password : '',
                new_password : '',
                new_password_confirmation : '',
            }
        }

        const clearError = () => {
            resetChangePasswordMessage(null)
            console.log('clearError');
        }

        onMounted(() => {
            clearError();
        });

        return { router, route, onMounted, watch, userInfo, changeForm, clickChangePassword, changePasswordErrorsCurrent, changePasswordErrorsNewpass };
    },

});
</script>

<style lang="scss" scoped>
.userchangepassword {
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
