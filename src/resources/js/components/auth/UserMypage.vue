<template>
    <section class="usermypage">
        <!-- <h2 class="usermypage_title">{{ userInfo.name }}様マイページ</h2> -->
        <h2 class="usermypage_title">{{ ( userInfo || {} ).name }}様マイページ</h2>
        <div class="usermypage_wrap">
            <div class="usermypage_wrap_title">登録情報</div>
            <div class="usermypage_wrap_content">

                <div v-if="changePasswordSuccess" class="errors">{{changePasswordSuccess}}</div>
                <div v-if="changeEmailSuccess" class="errors">{{changeEmailSuccess}}</div>

                <ul class="usermypage_wrap_content_list">
                    <li class="usermypage_wrap_content_list_items">
                        <p class="usermypage_wrap_content_list_items_title">氏名</p>
                        <p class="usermypage_wrap_content_list_items_info">{{ ( userInfo || {} ).name }}</p>
                    </li>
                    <li class="usermypage_wrap_content_list_items">
                        <p class="usermypage_wrap_content_list_items_title">メールアドレス</p>
                        <p class="usermypage_wrap_content_list_items_info">{{ ( userInfo || {} ).email }}</p>
                        <div class="usermypage_wrap_content_list_items_button">
                            <router-link to="/changeEmail">
                            <button class="usermypage_wrap_content_list_items_button_word">変更</button>
                            </router-link>
                        </div>
                    </li>
                    <li class="usermypage_wrap_content_list_items">
                        <p class="usermypage_wrap_content_list_items_title">パスワード</p>
                        <p class="usermypage_wrap_content_list_items_info">********</p>
                        <div class="usermypage_wrap_content_list_items_button">
                            <router-link to="/changePassword">
                            <button class="usermypage_wrap_content_list_items_button_word">変更</button>
                            </router-link>
                        </div>
                    </li>
                </ul>
                <div class="usermypage_wrap_content_button">
                    <router-link to="/orderHistory"><ButtonBlack>注文履歴</ButtonBlack></router-link>
                    <ButtonWhite class="margin-left">退会する</ButtonWhite>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent, onMounted, watch } from "vue"
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'
import { auth } from '../../../../store/auth'
import ButtonBlack from "../common/ButtonOrange.vue"
import ButtonWhite from "../common/ButtonWhite.vue"
import Message from "../Message.vue"
import Loader from "../Loader.vue"
import axios from "axios";
import { CREATED, UNPROCESSABLE_ENTITY } from '../../util'
import { error } from '../../../../store/error'
import { message } from '../../../../store/message'

export default defineComponent({
    name: 'UserMypage',
    components: {
        ButtonWhite,
        ButtonBlack,
        Loader,
        Message,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const authStore = auth();
        // const { resetChangePasswordMessage, resetChangeEmailMessage } = authStore;
        const { userInfo, changePasswordSuccess, changeEmailSuccess } = storeToRefs(authStore);

        // const clearError = () => {
        //     resetChangePasswordMessage(null)
        //     resetChangeEmailMessage(null)
        //     console.log('clearError');
        // }

        onMounted(() => {
            // clearError();
        });

        return { router, route, onMounted, watch, userInfo, changePasswordSuccess, changeEmailSuccess };
    },

});
</script>

<style lang="scss" scoped>
.usermypage {
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

        &_content {
            border: 2px solid #000000;
            padding: 20px;
            font-size: 36px;

            &_list {
                list-style-type: none;

                &_items {
                    display: flex;
                    padding: 20px 0;

                    &_title{
                        width: 33.33%;
                    }

                    &_info{
                        width: 46.33%;
                    }

                    &_button{
                        width: 20.33%;
                        display: flex;
                        justify-content: center;

                        &_word {
                            padding: 10px;
                            border-radius: 10px;
                        }
                    }
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
