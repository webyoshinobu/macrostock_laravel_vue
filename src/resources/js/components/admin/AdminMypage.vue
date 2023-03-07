<template>
    <section class="adminmypage">
        <h2 class="adminmypage_title">管理者マイページ</h2>

        <!-- 登録情報エリア -->
        <div class="adminmypage_wrap_content">

            <div v-if="changePasswordSuccess" class="errors">{{changePasswordSuccess}}</div>
            <div v-if="changeEmailSuccess" class="errors">{{changeEmailSuccess}}</div>

            <ul class="adminmypage_wrap_content_list">
                <li class="adminmypage_wrap_content_list_items">
                    <p class="adminmypage_wrap_content_list_items_title">氏名</p>
                    <p class="adminmypage_wrap_content_list_items_info">{{ ( userInfo || {} ).name }}</p>
                </li>
                <li class="adminmypage_wrap_content_list_items">
                    <p class="adminmypage_wrap_content_list_items_title">メールアドレス</p>
                    <p class="adminmypage_wrap_content_list_items_info">{{ ( userInfo || {} ).email }}</p>
                    <div class="adminmypage_wrap_content_list_items_button">
                        <router-link to="/admin/changeEmail">
                        <button class="adminmypage_wrap_content_list_items_button_word">変更</button>
                        </router-link>
                    </div>
                </li>
                <li class="adminmypage_wrap_content_list_items">
                    <p class="adminmypage_wrap_content_list_items_title">パスワード</p>
                    <p class="adminmypage_wrap_content_list_items_info">********</p>
                    <div class="adminmypage_wrap_content_list_items_button">
                        <router-link to="/admin/changePassword">
                        <button class="adminmypage_wrap_content_list_items_button_word">変更</button>
                        </router-link>
                    </div>
                </li>
            </ul>

             <!-- ローディング -->
            <div v-show="loading" class="panel">
                <Loader>Sending your photo...</Loader>
            </div>

            <form v-show="! loading" class="adminmypage_form" @submit.prevent="submit">

                <!-- <input type="hidden" name="_token" :value="token"> -->

                <!-- エラーメッセージ -->
                <div class="errors" v-if="errors">
                    <ul v-if="errors.photo">
                        <li v-for="msg in errors.photo" :key="msg">{{ msg }}</li>
                    </ul>
                </div>

                <p class="margin-bottom">写真のアップロード</p>

                <Message></Message>

                <input class="adminmypage_form_item" id="photo_upload" type="file" v-if="input" @change="onFileChange">
                <output class="form_output" v-show="preview">
                    <img :src="preview" alt="">
                </output>
                <div class="adminmypage_form_button">
                    <button type="submit" class="button button--inverse">submit</button>
                </div>

            </form>

            <div class="adminmypage_wrap_content_button">
                <ButtonWhite @click="deleteAccountModalOpen" class="margin-left">退会</ButtonWhite>
            </div>
        </div>

        <!-- ローディング -->
        <!-- <div v-show="loading" class="panel">
            <Loader>Sending your photo...</Loader>
        </div> -->

        <!-- <form v-show="! loading" class="adminmypage_form" @submit.prevent="submit"> -->

            <!-- <input type="hidden" name="_token" :value="token"> -->

            <!-- エラーメッセージ -->
            <!-- <div class="errors" v-if="errors">
                <ul v-if="errors.photo">
                    <li v-for="msg in errors.photo" :key="msg">{{ msg }}</li>
                </ul>
            </div>

            <h3>写真のアップロード</h3>

            <Message></Message>

            <input class="adminmypage_form_item" id="photo_upload" type="file" v-if="input" @change="onFileChange">
            <output class="form_output" v-show="preview">
                <img :src="preview" alt="">
            </output>
            <div class="adminmypage_form_button">
                <button type="submit" class="button button--inverse">submit</button>
            </div> -->

        <!-- </form> -->

        <h3 class="f-40 margin-bottom">{{( userInfo || {} ).name}}様が販売中の写真一覧</h3>

        <ul class="adminmypage_list">
            <li class="adminmypage_list_items" v-for="photo in photos" :key="photo.index">
            <!-- <li class="adminmypage_list_items" v-for="photo in photo_list" :key="photo.index"> -->
                <div class="adminmypage_list_items_img">
                    <img class="adminmypage_list_items_img_content" :src="photo.img_url" :alt="photo.filename">
                </div>
                <div class="adminmypage_list_items_detail">
                    <p>ファイル名：{{photo.filename}}</p>
                    <p>所有者：{{photo.name}}</p>
                    <p>価格：{{photo.price}}</p>
                    <button @click="deleteModalOpen(photo)">削除</button>
                </div>
            </li>
        </ul>

        <!-- 写真削除モーダル -->
        <transition name="modal">
            <div id="deletephoto_overlay" v-show="delete_modal">

                <div v-if="!success_flag" class="deletephoto_modal_content" id="deletephoto_modal_content">
                    <h2>写真削除の確認</h2>
                    <p class="deletephoto_modal_content_word">写真を削除します。</p>
                    <p class="deletephoto_modal_content_word">削除を実行すると復元できなくなり、再アップロードが必要になります。</p>
                    <p class="deletephoto_modal_content_word">写真の削除を実行しますか？</p>

                    <form class="deletephoto_modal_content_form" method="post">
                        <p v-if="password_error" class="errors">{{password_error}}</p>
                        <label for="deletephoto_modal_content_form_label">パスワード確認</label>
                        <input type="password" class="deletephoto_modal_content_form_label" id="deletephoto_modal_content_form_label" v-model="deleteForm.current_password">
                    </form>
                    <p class="deletephoto_modal_content_button">
                        <ButtonRed @click="deleteImg">削除</ButtonRed>
                        <ButtonGreen @click="deleteModalClose" class="margin-left">キャンセル</ButtonGreen>
                    </p>
                </div>

                <div v-else class="deletephoto_modal_content" id="deletephoto_modal_content">
                    <h2>{{success}}</h2>
                    <p class="deletephoto_modal_content_button">
                        <ButtonGreen @click="deleteModalClose">OK</ButtonGreen>
                    </p>
                </div>

            </div>
        </transition>

        <!-- アカウント削除モーダル -->
        <transition name="modal">
            <div id="deleteaccount_overlay" v-show="delete_account_modal">
                <div class="deleteaccount_modal_content" id="deleteaccount_modal_content">
                    <h2>退会の確認</h2>
                    <p class="deleteaccount_modal_content_word">お客様のアカウントを削除します。</p>
                    <p class="deleteaccount_modal_content_word">削除を実行するとお客様の全ての情報が削除され、復元もできなくなります。</p>
                    <p class="deleteaccount_modal_content_word">アカウント削除を実行しますか？</p>

                    <form class="deleteaccount_modal_content_form" method="post">
                        <p v-if="password_error" class="errors">{{password_error}}</p>
                        <label for="deleteaccount_modal_content_form_label">パスワード確認</label>
                        <input type="password" class="deleteaccount_modal_content_form_label" id="deleteaccount_modal_content_form_label" v-model="deleteAccountForm.current_password">
                    </form>
                    <p class="deleteaccount_modal_content_button">
                        <ButtonRed @click="deleteAccount(userInfo)">削除</ButtonRed>
                        <ButtonGreen @click="deleteAccountModalClose" class="margin-left">キャンセル</ButtonGreen>
                    </p>
                </div>
            </div>
        </transition>

    </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, watch, nextTick, onUpdated, onBeforeUnmount } from "vue"
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'
import { auth } from '../../../../store/auth'
import ButtonWhite from "../common/ButtonWhite.vue"
import ButtonBlack from "../common/ButtonBlack.vue"
import ButtonRed from "../common/ButtonRed.vue"
import ButtonGreen from "../common/ButtonGreen.vue"
import Message from "../Message.vue"
import Loader from "../Loader.vue"
import axios from "axios";
import { CREATED, UNPROCESSABLE_ENTITY } from '../../util'
import { error } from '../../../../store/error'
import { message } from '../../../../store/message'
import { galleryImgs } from '../../../../store/gallery'
import { OK } from '../../util'

export default defineComponent({
    name: 'AdminMypage',
    components: {
        ButtonWhite,
        ButtonBlack,
        ButtonRed,
        ButtonGreen,
        Loader,
        Message,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const authStore = auth();
        const galleryStore = galleryImgs()
        // let preview = ref<string | ArrayBuffer>('');
        let preview = null
        let photo:any = null
        let errors:any = null
        let loading = ref<boolean>(false)
        let input = ref<boolean>(true)
        const { deleteAccountAdmin, adminLogout } = authStore;
        const { userInfo, changePasswordSuccess, changeEmailSuccess } = storeToRefs(authStore) as any|null;
        const { photo_list } = storeToRefs(galleryStore) as any|null;
        let photos = ref([]);
        let delete_modal = ref<boolean>(false);
        let deleteForm = ref({
            current_password: '',
        });
        let password_error = ref('');
        let selectedDeletePhoto = ref([]);
        let success_flag = ref<boolean>(false)
        let success = ref('');
        let delete_account_modal = ref<boolean>(false);
        let deleteAccountForm = ref({
            current_password: '',
        });

        watch(userInfo, () => {
            console.log('watch userInfo', userInfo.value)
            photoList(userInfo.value)
        },
        {
            // deep: true,
            // immediate: true
        })

        //methods
        const photoList = async(data:any) => {
            console.log('AdminMypage.vue photoList()', data)
            photos.value = await galleryImgs().getPhotoList(data)
            console.log('AdminMypage.vue photoList() photos', photos)
            // console.log('AdminMypage.vue photoList() photo_list', photo_list)
        }

        // フォームでファイルが選択されたら実行される
        const onFileChange = (event: Event) => {
            console.log('onFileChange');

            if (event.target instanceof HTMLInputElement && event.target.files) {

                if (event.target.files[0]!==null){

                    // 何も選択されていなかったら処理中断
                    if (event.target.files.length === 0) {
                        return false
                    }

                    // ファイルが画像ではなかったら処理中断
                    if (!event.target.files[0].type.match('image.*')) {
                        return false
                    }

                    // FileReaderクラスのインスタンスを取得
                    const reader = new FileReader()

                    // ファイルを読み込み終わったタイミングで実行する処理
                    // reader.onload = e => {
                    reader.onload = (e:any) => {
                        // previewに読み込み結果（データURL）を代入する
                        // previewに値が入ると<output>につけたv-ifがtrueと判定される
                        // また<output>内部の<img>のsrc属性はpreviewの値を参照しているので
                        // 結果として画像が表示される

                        preview = e.target.result
                        // preview = reader.result
                        // console.log('preview',preview);
                    }

                    // console.log('reader',reader);
                    // console.log('event.target.files[0]',event.target.files[0])

                    // ファイルを読み込む
                    // 読み込まれたファイルはデータURL形式で受け取れる（上記onload参照）
                    reader.readAsDataURL(event.target.files[0])
                    // console.log('reader.readAsDataURL',reader.readAsDataURL);
                    photo = event.target.files[0]
                }
            }
        }

        // 入力欄の値とプレビュー表示をクリアするメソッド
        const reset = () => {
            preview = ''
            photo = null
            input.value = false
            console.log('input2', input.value);
            nextTick(() =>{
                input.value = true
                console.log('input3', input.value);
            })
        }

        const submit = async () => {
            loading.value = true

            const formData = new FormData()
            formData.append('photo', photo)
            const response = await axios.post('/api/photos', formData)

            loading.value = false

            if (response.status === UNPROCESSABLE_ENTITY) {
                errors = response.data.errors
                return false
            }

            reset()

            if (response.status !== CREATED) {
                const code = response.status
                error().setCode(code)
                return false
            }

            // メッセージ登録
            const content = '写真がアップロードされました。'
            const timeout = 6000
            message().setContent(content,timeout)

            photoList(userInfo.value)
        }

        const deleteModalOpen = (photo:any) => {
            delete_modal.value = true
            console.log('AdminMypage.vue deleModalOpen photo', photo)
            selectedDeletePhoto.value = photo
            console.log('AdminMypage.vue deleModalOpen selectedDeletePhoto', selectedDeletePhoto)
        }
        const deleteModalClose = () => {
            delete_modal.value = false;
            // password_error.value = ''
            // deleteForm.value = {current_password: ''}
            // selectedDeletePhoto.value = []
            resetVals()
        }

        const deleteImg = async () => {
            console.log('AdminMypage.vue deleteImg deleteForm', deleteForm.value)

            try {
                const response = await authStore.confirmAdminPass(deleteForm.value)
                console.log('AdminMypage.vue deleteImg confirmAdminPass response', response)
                const confirm_pass_status = response.status
                console.log('AdminMypage.vue deleteImg confirm_pass_status', confirm_pass_status)
                if(!deleteForm.value.current_password) {
                        password_error.value = 'パスワードを入力してください。'
                }else if(confirm_pass_status != OK) {
                    password_error.value = response.data.errorMessage
                    // throw new Error(error_mismatch_pass.value)
                }else{
                    try {
                        const delete_photo_response = await galleryStore.deletePhoto(selectedDeletePhoto.value)
                        console.log('AdminMypage.vue deleteImg delete_photo_response.status', delete_photo_response.status)
                        if(delete_photo_response.status == OK) {
                            // selectedDeletePhoto.value = []
                            // deleteForm.value = {current_password: ''}
                            // delete_modal.value = false
                            resetVals()
                            success.value = '写真が削除されました。'
                            console.log(success.value)
                            success_flag.value = true
                            photoList(userInfo.value)
                            return
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
        }

        const resetVals = () => {
            selectedDeletePhoto.value = []
            deleteForm.value = {current_password: ''}
            // delete_modal.value = false
            password_error.value = ''
            deleteForm.value = {current_password: ''}
            selectedDeletePhoto.value = []
            success_flag.value = false
            console.log('resetVals')
        }

        const deleteAccountModalOpen = () => {
            delete_account_modal.value = true
        }
        const deleteAccountModalClose = () => {
            delete_account_modal.value = false;
            password_error.value = ''
            deleteAccountForm.value = {current_password: ''}
        }

        const deleteAccount = async(admin:any) => {
            console.log('AdminMypage.vue deleteAccount data', admin)
            console.log('AdminMypage.vue deleteAccount deleteForm', deleteAccountForm.value)

            try {
                const response = await authStore.confirmAdminPass(deleteAccountForm.value)
                console.log('AdminMypage.vue confirmAdminPass response', response)
                const confirm_pass_status = response.status
                console.log('AdminMypage.vue deleteAccount confirm_pass_status', confirm_pass_status)
                if(!deleteAccountForm.value.current_password) {
                    password_error.value = 'パスワードを入力してください。'
                }else if(confirm_pass_status != OK) {
                    password_error.value = response.data.errorMessage
                    // throw new Error(error_mismatch_pass.value)
                }else{

                    try {
                        console.log('AdminMypage.vue deleteAccount photos', photos.value)
                        const delete_photos = photos.value
                        const delete_account_response = await authStore.deleteAccountAdmin(admin, delete_photos)
                        console.log('AdminMypage.vue deleteAccount response.status', delete_account_response.status)
                        if(delete_account_response.status == OK) {
                            await authStore.adminLogout()
                            return router.push({name: 'deleteAccount'})
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
        }

        onMounted(async() => {
            console.log('onMounted');
            console.log('watch userInfo', userInfo.value)
            photoList(userInfo.value)
        });

        return { router, route, onMounted, watch, onFileChange, preview, reset, submit, errors, loading, input, nextTick, photoList, photos, photo_list, deleteImg, deleteModalOpen, deleteModalClose, delete_modal, deleteForm, password_error, success, resetVals, success_flag, userInfo, changePasswordSuccess, changeEmailSuccess, deleteAccount, deleteAccountModalOpen, delete_account_modal, deleteAccountModalClose, deleteAccountForm };
    },

});
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.adminmypage {
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
            margin: 0 0 40px 0;

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

    &_form {
        margin: 0 0 20px 0;
        border: 2px solid #000000;
        padding: 20px;

        h3 {
            padding: 0 0 20px 0;
            // font-size: 24px;
            @include f-24;
        }

        &_item {
            width: 100%;
            margin: 0 0 20px 0;
        }

        button {
            padding: 10px;
            border-radius: 10px;
        }
    }

    &_list {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        list-style-type: none;

        &::after{
            content: "";
            display: block;
            width: 32%;
        }

        &_items {
            width: 19%;
            display: flex;
            flex-direction: column;
            margin: 0 0 20px 0;

            @include md {
                width: 30%;
            }

            @include tb {
                width: 47%;
            }

            @include sm {
                width: 100%;
            }

            &_img {
                width: 100%;
                display: flex;

                &_content {
                    width: 100%;
                    height: 300px;
                    object-fit: cover;
                }
            }

            &_detail {
                padding: 20px 0;

                p {
                    padding: 0 0 10px 0;
                }

                button {
                    padding: 10px;
                    border-radius: 10px;
                }
            }
        }
    }
}

.f-40 {
    // font-size: 40px;
    @include f-40;
}

.panel {
    border: 2px solid #000000;
    width: 97%;
    padding: 20px;
    margin: 0 0 20px 0;
}

.margin-left {
    margin: 0 0 0 10px;
}

.margin-bottom {
    margin: 0 0 20px 0;
}

// .errors {
//     margin: 0 0 20px 0;

//     ul {
//         list-style: none;
//         font-size: 24px;
//         color: red;
//         font-weight: bold;
//     }
// }
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
// 写真削除モーダル関連
//-----------------------
#deletephoto_overlay{
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

#deletephoto_modal_content{
  z-index:2;
  width:50%;
  padding: 1em;
  background:#fff;
  border-radius: 20px;

  @include tb {
    width: 80%;
  }
}

.deletephoto_modal_content {

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

// .modal-enter-active, .modal-leave-active {
//   opacity: 1;
//   transform: scale(1);
//   transition: opacity 0.5s;

//   .modal-content{
//     transform: scale(1.2);
//     transition: 0.5s;
//   }
// }

// .modal-enter, .modal-leave-to {
//   opacity: 0;
//   transform: scale(0);
//   transition: opacity 0.5s, transform 0s 0.5s;

//   .modal-content{
//     transform: scale(1);
//   }
// }

//-----------------------
// 写真削除モーダル関連
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

//-----------------------
// モーダル関連共通
//-----------------------
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
