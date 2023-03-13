<template>
    <section class="userchangeemail">

        <Indicator :isLoading="isLoading"></Indicator>

        <h2 class="userchangeemail_title">{{ ( userInfo || {} ).name }}様マイページ</h2>
        <div class="userchangeemail_wrap">
            <div class="userchangeemail_wrap_title">メールアドレス変更</div>
            <form method="post" class="userchangeemail_wrap_form" @submit.prevent="clickRegister">
                <!-- laravelのトークンを使用 -->
                <input type="hidden" name="_token" :value="token">

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
                    <div class="userchangeemail_wrap_form_button_common">
                        <ButtonRed @click="clickChangeEmail">変更する</ButtonRed>
                    </div>
                    <router-link to="/mypage" class="userchangeemail_wrap_form_button_common">
                        <ButtonWhite>マイページトップへ戻る</ButtonWhite>
                    </router-link>
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
import Indicator from '../../Indicator.vue'

export default defineComponent({
    name: 'UserChangeEmail',
    components: {
        ButtonWhite,
        ButtonRed,
        Loader,
        Message,
        Indicator,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const authStore = auth();
        const { changeEmail, resetChangeEmailMessage } = authStore;
        const { userInfo, changeEmailStatus, changeEmailErrorMessagesCurrentEmail, changeEmailErrorMessagesNewemail, isLoggedIn } = storeToRefs(authStore);
        const changeForm = ref({
            current_email: '',
            new_email: '',
            new_email_confirmation: '',
        });
        let isLoading = ref(false);
        const token = auth().csrf;

        // computed
        const changeEmailErrorsCurrentEmail = computed(() => {
            return authStore.changeEmailErrorMessagesCurrentEmail
        })

        const changeEmailErrorsNewemail = computed(() => {
            return authStore.changeEmailErrorMessagesNewemail
        })

        // methods
        const checkLoggedIn = () => {
            if(!isLoggedIn.value) {
                router.push({ name:'login' })
            }
        }

        const clickChangeEmail = async() => {
            isLoading.value = true

            await changeEmail(changeForm.value)

            isLoading.value = false

            if(authStore.changeEmailStatus === OK){
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
            checkLoggedIn();
        });

        return { router, route, token, onMounted, watch, userInfo, changeForm, clickChangeEmail, changeEmailErrorsCurrentEmail, changeEmailErrorsNewemail, isLoading };
    },

});
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.userchangeemail {
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

    &_wrap{

        &_title {
            background-color: #000000;
            color: #ffffff;
            // font-size: 36px;
            @include f-36;
            font-weight: bold;
            padding: 18.5px 0 18.5px 10px;
        }

        &_form {
            border: 2px solid #000000;
            padding: 20px;
            // font-size: 36px;
            @include f-36;

            &_line {
                padding: 20px;
                display: flex;

                @include md {
                    flex-direction: column;

                    &:not(:last-child) {
                        padding: 0 0 20px 0;
                    }
                }

                &_label {
                    width: 40%;

                    @include md {
                        width: 100%;
                    }
                }

                &_input {
                    width: 60%;

                    @include md {
                        width: 100%;
                    }
                }

            }

            &_button {
                display: flex;
                justify-content: center;
                margin: 20px 0 0 0;

                @include tb {
                    flex-direction: column;
                }

                &_common {
                    display: flex;
                    justify-content: center;
                    text-decoration: none;
                    @include f-36;

                    &:last-child {
                        margin: 0 0 0 10px;

                        @include tb {
                            margin: 10px 0 0 0;
                        }
                    }
                }
            }
        }
    }
}

.errors {
    margin: 0 0 20px 0;
    // font-size: 24px;
    @include f-24;
    color: red;
    font-weight: bold;

    ul {
        list-style: none;
    }
}

</style>
