<template>
    <section class="adminmypage">
        <h2 class="adminmypage_title">管理者マイページ</h2>

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

            <input class="adminmypage_form_item" id="photo_upload" type="file" v-if="input" @change="onFileChange">
            <output class="form_output" v-show="preview">
                <img :src="preview" alt="">
            </output>
            <div class="adminmypage_form_button">
                <button type="submit" class="button button--inverse">submit</button>
            </div>

        </form>
    </section>
</template>

<script lang="ts">
import { defineComponent, ref, computed, onMounted, reactive, watch, nextTick } from "vue"
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'
import { auth } from '../../../../store/auth'
import ButtonWhite from "../common/ButtonWhite.vue"
import ButtonBlack from "../common/ButtonBlack.vue"
import Loader from "../Loader.vue"
import axios from "axios";
import { CREATED, UNPROCESSABLE_ENTITY } from '../../util'
import { error } from '../../../../store/error'
import { message } from '../../../../store/message'

export default defineComponent({
    name: 'AdminMypage',
    components: {
        ButtonWhite,
        ButtonBlack,
        Loader,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        // let preview = ref<string | ArrayBuffer>('');
        let preview = null
        let photo:any = null
        let errors:any = null
        let loading = ref<boolean>(false)
        let input = ref<boolean>(true)

        // watch(preview, () => {
        //     console.log('watch preview', preview)
        // },
        // {
        //     deep: true
        // })

        //methods
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
            const content = '写真が投稿されました！'
            const timeout = 6000
            message().setContent(content,timeout)
        }

        onMounted(() => {
            console.log('input1', input.value);
        });

        return { router, route, onMounted, watch, onFileChange, preview, reset, submit, errors, loading, input, nextTick };
    },

});
</script>

<style lang="scss" scoped>
.adminmypage {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    &_title {
        font-size: 70px;
        margin-bottom: 50px;
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
