<template>
    <section class="userchangeemail">
        <h2 class="userchangeemail_title">様マイページ</h2>
        <div class="userchangeemail_wrap">
            <div class="userchangeemail_wrap_title">メールアドレス変更</div>
            <form method="post" class="userchangeemail_wrap_form" @submit.prevent="clickRegister">
                <!-- laravelのトークンを使用 -->
                <!-- <input type="hidden" name="_token" :value="token"> -->

                <!-- <div v-if="registerErrors" class="errors">
                    <ul v-if="registerErrors.name">
                        <li v-for="msg in registerErrors.name" :key="msg">
                            {{ msg }} -->
                            <!-- 氏名を入力してください。 -->
                        <!-- </li>
                    </ul>
                    <ul v-if="registerErrors.email">
                        <li v-for="msg in registerErrors.email" :key="msg">
                            {{ msg }} -->
                            <!-- メールアドレスを入力してください。 -->
                        <!-- </li>
                    </ul>
                    <ul v-if="registerErrors.password">
                        <li v-for="msg in registerErrors.password" :key="msg">
                            {{ msg }} -->
                            <!-- パスワードを入力してください。 -->
                        <!-- </li>
                    </ul>
                </div> -->


                <div class="userchangeemail_wrap_form_line">
                    <label class="userchangeemail_wrap_form_line_label" for="userchangeemail_form_email">メールアドレス</label>
                    <input type="text" class="userchangeemail_wrap_form_line_input" id="userchangeemail_form_email" v-model="changeForm.email">
                </div>

                <div class="userchangeemail_wrap_form_line">
                    <label class="userchangeemail_wrap_form_line_label" for="userchangeemail_form_email">メールアドレス(確認)</label>
                    <input type="text" class="userchangeemail_wrap_form_line_input" id="userchangeemail_form_email" v-model="changeForm.emailConfirm">
                </div>

                <div class="userchangeemail_wrap_form_button">
                    <ButtonRed>変更する</ButtonRed>
                    <ButtonWhite class="margin-left">マイページトップへ戻る</ButtonWhite>
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
        const { userInfo } = storeToRefs(authStore);
        const changeForm = {
            email: '',
            emailConfirm: '',
        };

        onMounted(() => {

        });

        return { router, route, onMounted, watch, userInfo, changeForm };
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

    ul {
        list-style: none;
        font-size: 24px;
        color: red;
        font-weight: bold;
    }
}

</style>
