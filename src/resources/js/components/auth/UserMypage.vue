<template>
    <section class="usermypage">

        <Indicator :isLoading="isLoading"></Indicator>

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
                    <ButtonWhite @click="deleteModalOpen" class="margin-left">退会</ButtonWhite>
                </div>
            </div>
        </div>

        <!-- モーダル -->
        <transition name="modal">
            <div id="deleteaccount_overlay" v-show="delete_modal">
                <div class="deleteaccount_modal_content" id="deleteaccount_modal_content">
                    <h2>退会の確認</h2>
                    <p class="deleteaccount_modal_content_word">お客様のアカウントを削除します。</p>
                    <p class="deleteaccount_modal_content_word">削除を実行するとお客様の全ての情報が削除され、復元もできなくなります。</p>
                    <p class="deleteaccount_modal_content_word">アカウント削除を実行しますか？</p>

                    <form class="deleteaccount_modal_content_form" method="post">
                        <p v-if="password_error" class="errors">{{password_error}}</p>
                        <label for="deleteaccount_modal_content_form_label">パスワード確認</label>
                        <input type="password" class="deleteaccount_modal_content_form_label" id="deleteaccount_modal_content_form_label" v-model="deleteForm.current_password">
                    </form>
                    <p class="deleteaccount_modal_content_button">
                        <ButtonRed @click="deleteAccount(userInfo)">削除</ButtonRed>
                        <ButtonGreen @click="deleteModalClose" class="margin-left">キャンセル</ButtonGreen>
                    </p>
                </div>
            </div>
        </transition>

    </section>
</template>

<script lang="ts">
import { defineComponent, onMounted, watch, ref, onUpdated } from "vue"
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'
import { auth } from '../../../../store/auth'
import ButtonBlack from "../common/ButtonOrange.vue"
import ButtonWhite from "../common/ButtonWhite.vue"
import ButtonRed from "../common/ButtonRed.vue"
import ButtonGreen from "../common/ButtonGreen.vue"
import Message from "../Message.vue"
import Loader from "../Loader.vue"
import axios from "axios";
import { OK } from '../../util'
import { error } from '../../../../store/error'
import { message } from '../../../../store/message'
import Indicator from '../../Indicator.vue'

export default defineComponent({
    name: 'UserMypage',
    components: {
        ButtonWhite,
        ButtonBlack,
        ButtonRed,
        ButtonGreen,
        Loader,
        Message,
        Indicator,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const authStore = auth();
        const { confirmUserPass, logout } = authStore;
        const { userInfo, changePasswordSuccess, changeEmailSuccess } = storeToRefs(authStore);
        let delete_modal = ref<boolean>(false);
        let deleteForm = ref({
            current_password: '',
        });
        let password_error = ref('');

        const deleteModalOpen = () => {
            delete_modal.value = true
        }
        const deleteModalClose = () => {
            delete_modal.value = false;
            password_error.value = ''
            deleteForm.value = {current_password: ''}
        }
        let isLoading = ref(false)

        const deleteAccount = async(data:any) => {
            isLoading.value = true
            // console.log('UserMypage.vue deleteAccount data', data)
            // console.log('UserMypage.vue deleteAccount deleteForm', deleteForm.value)

            try {
                const response = await confirmUserPass(deleteForm.value)
                // console.log('UserMypage.vue deleteAccount response', response)
                const confirm_pass_status = response.status
                // console.log('UserMypage.vue deleteAccount confirm_pass_status', confirm_pass_status)
                if(!deleteForm.value.current_password) {
                    password_error.value = 'パスワードを入力してください。'
                }else if(confirm_pass_status != OK) {
                    password_error.value = response.data.errorMessage
                    // throw new Error(error_mismatch_pass.value)
                }else{

                    try {
                        const delete_account_response = await authStore.deleteAccount(data)
                        // console.log('UserMypage.vue deleteAccount response.status', delete_account_response.status)
                        if(delete_account_response.status == OK) {
                            await authStore.logout()
                            router.push({name: 'deleteAccount'})
                        }else{
                            password_error.value = 'アカウントの削除に失敗しました。'
                            throw new Error(password_error.value)
                        }
                    }catch(e:any){
                        console.error( "エラー：", e.message )
                    }

                }
                throw new Error(password_error.value)
            }catch(e:any){
                console.error( "エラー：", e.message )
            }

            isLoading.value = false

        }

        // const clearError = () => {
        //     resetChangePasswordMessage(null)
        //     resetChangeEmailMessage(null)
        //     console.log('clearError');
        // }

        onMounted(() => {
            // isLoading.value = true
            // clearError();
        });

        // onUpdated(() => {
        //     isLoading.value = false
        //     console.log("on update", isLoading.value)
        // })

        return { router, route, onMounted, watch, userInfo, changePasswordSuccess, changeEmailSuccess, delete_modal, deleteModalOpen, deleteModalClose, deleteAccount, deleteForm, password_error, logout, isLoading };
    },

});
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.usermypage {
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

        &_content {
            border: 2px solid #000000;
            padding: 20px;
            // font-size: 36px;
            @include f-36;

            &_list {
                list-style-type: none;

                &_items {
                    display: flex;
                    padding: 20px 0;

                    @include md {
                        flex-direction: column;
                    }

                    &_title{
                        width: 33.33%;
                        overflow-wrap: break-word;

                        @include md {
                            width: 100%;
                        }
                    }

                    &_info{
                        width: 46.33%;
                        overflow-wrap: break-word;

                        @include md {
                            margin: 0 0 20px 5%;
                            width: 95%;
                        }
                    }

                    &_button{
                        width: 20.33%;
                        display: flex;
                        justify-content: center;

                        @include md {
                            width: 100%;
                            justify-content: flex-end;
                        }

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
    // font-size: 24px;
    @include f-24;
    color: red;
    font-weight: bold;

    ul {
        list-style: none;
    }
}

//-----------------------
// モーダル関連
//-----------------------
#deleteaccount_overlay{
  /*　要素を重ねた時の順番　*/
  z-index:999;

  /*　画面全体を覆う設定　*/
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background-color:rgba(0,0,0,0.5);

  /*　画面の中央に要素を表示させる設定　*/
  display: flex;
  align-items: center;
  justify-content: center;

}

#deleteaccount_modal_content{
  z-index:2;
  width:50%;
  padding: 1em;
  background:#fff;
  border-radius: 20px;

  @include tb {
    width: 80%;
  }
}

.deleteaccount_modal_content {

    h2 {
        // font-size: 36px;
        @include f-36;
        margin: 20px 0;
    }

    &_word {
        // font-size: 24px;
        @include f-24;
        text-align: left;
    }

    &_form {
        margin: 20px 0;
        // font-size: 24px;
        @include f-24;

        &_label {
            margin: 0 0 0 20px;
        }
    }

    &_button {
        display: flex;
        justify-content: flex-end;
        // font-size: 24px;
        @include f-24;

        &_content {
            padding: 10px;
            border-radius: 10px;
            background-color: #3cb371;
            border: none;
            outline: none;
            cursor: pointer;
        }
    }

}

.modal-enter-active, .modal-leave-active {
  opacity: 1;
  transform: scale(1);
  transition: opacity 0.5s;

  .modal-content{
    transform: scale(1.2);
    transition: 0.5s;
  }
}

.modal-enter, .modal-leave-to {
  opacity: 0;
  transform: scale(0);
  transition: opacity 0.5s, transform 0s 0.5s;

  .modal-content{
    transform: scale(1);
  }
}

</style>
