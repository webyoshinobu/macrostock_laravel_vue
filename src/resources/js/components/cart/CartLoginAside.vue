<template>
  <section class="logined">

    <Indicator :isLoading="isLoading"></Indicator>

    <h2 class="logined_title">購入</h2>
    <div class="logined_detail">
        <p class="logined_detail_word">「購入する」ボタンを押すと写真がダウンロードされ、購入完了画面へ遷移します。</p>
        <div class="logined_detail_button">
            <router-link to="/gallery">
                <ButtonWhite class="logined_detail_button_component">Galleryへ</ButtonWhite>
            </router-link>
            <!-- <router-link to="/thanks"> -->
            <div>
                <ButtonOrange @click="download" class="logined_detail_button_component">購入する</ButtonOrange>
            </div>
            <!-- </router-link> -->
        </div>
    </div>

    <!-- モーダル -->
    <transition name="modal">
        <div id="no_item_overlay" v-show="no_item">
            <div class="no_item_modal_content" id="no_item_modal_content">
                <h2>画像が選択されていません。</h2>
                <p class="no_item_modal_content_word">画像が選択されていません。画像を選択してください。</p>
                <div class="no_item_modal_content_button">
                    <ButtonGreen @click="closeModal">Close</ButtonGreen>
                </div>
            </div>
        </div>
    </transition>

  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import ButtonOrange from "../common/ButtonOrange.vue";
import ButtonWhite from "../common/ButtonWhite.vue";
import { useRoute, useRouter } from 'vue-router';
import axios from "axios"
import { auth } from '../../../../store/auth';
import { storeToRefs } from 'pinia';
import { cartCounter } from '../../../../store/cart';
import { saveAs } from "file-saver";
import Indicator from '../../Indicator.vue'
import ButtonGreen from "../common/ButtonGreen.vue";

export default defineComponent({
    name: 'CartLoginAside',
    components: {
        ButtonOrange,
        ButtonWhite,
        Indicator,
        ButtonGreen,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const { totalPrice } = storeToRefs(cartCounter());
        let isLoading = ref(false);
        const no_item = ref(false);

        // methods
        const closeModal = () => {
            no_item.value = false;
        }

        const download = async() => {

            if(cartCounter().items.length == 0) {
                no_item.value = true
                return
            }

            isLoading.value = true

            const downloadItems = cartCounter().items;
            // console.log('CartLoginAside.vue download downloadItems', downloadItems);

            await registerOrderData(downloadItems)

            await axios.post('api/photos/zipDownLoad', downloadItems, { responseType: "blob", })
            .then((response)=>{
                let mineType = response.headers["content-type"];
                // const name = response.headers["content-disposition"];
                const contentDisposition = response.headers["content-disposition"];
                const fileName = getFileName(contentDisposition)
                const blob = new Blob([response.data], { type: mineType });
                // saveAs(blob, fileName );
                saveAs(blob, decodeURIComponent( fileName ));
            })
            .catch((error) => {
                console.log(error.messagae);
            });

            //カート内のデータをリセット
            await cartCounter().resetItems()

            isLoading.value = false

            //Thanksページへ移動
            router.push({ name: 'thanks'})

        }

        const registerOrderData = async(downloadItems:any) => {
            const orderData = {
                user_id: auth().userInfo!.id,
                order_total_amount: Math.floor(totalPrice.value * 1.1),
                order_total_number: downloadItems.length,
            }

            // console.log('CartLoginAside.vue download userInfo.id',auth().userInfo!.id)
            // console.log('CartLoginAside.vue download totalPrice', totalPrice.value)
            // console.log('CartLoginAside.vue download downloadItems.length', downloadItems.length)
            // console.log('CartLoginAside.vue download orderData', orderData)


            //注文履歴を残す
            //orderテーブルに情報を登録する。このidを取得して、order_detailのorder_idとして登録する
            const orderDataResponse = await cartCounter().makeOrder(orderData)
            //order_idを追加してorder_detailテーブルに追加する
            // console.log('CartLoginAside.vue download makeOrder orderDataResponse.data', orderDataResponse)

            for(let i=0; i<downloadItems.length; i++) {
                downloadItems[i]['order_id'] = orderDataResponse['uuid']
                downloadItems[i]['order_total_number'] = Number(1)
            }
            const orderDetails = downloadItems
            // console.log('CartLoginAside.vue download downloadItems order_id追加', downloadItems)
            // console.log('CartLoginAside.vue download orderDetails', orderDetails)
            for(let j=0; j<orderDetails.length; j++) {
                await cartCounter().makeOrderDetail(orderDetails[j])
            }
        }

        //laravelからのレスポンスで$headersのContent-Dispositionを指定してダウンロードするとtmpファイルには正常に保存されるが、
        // ダウンロードしたタイミングでファイルが壊れるので、Content-Dispositionのfilenameからファイル名を取り出して返す。
        const getFileName = (contentDisposition:string) => {
            let fileName = contentDisposition.substring(contentDisposition.indexOf("''") + 2,
            contentDisposition.length
            );
            //デコードするとスペースが"+"になるのでスペースへ置換します
            fileName = decodeURI(fileName).replace(/\+/g, " ");

            return fileName;
        }

        return { router, route, download, getFileName, registerOrderData, isLoading, closeModal, no_item }
    },

});
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.logined {
    border: solid 1px #000000;
    margin: 50px 0 0 0;

    &_title {
        display: flex;
        justify-content: center;
        align-items: center;
        border-bottom: solid 1px #000000;
        padding: 10px 0;
        background-color: #F2F0ED;
    }

    &_detail {
        padding: 10px;

        &_word {
            margin: 0 0 10px 0;
            font-size: 24px;
        }

        &_button {
            display: flex;
            justify-content: center;
            align-items: center;
            // font-size: 24px;
            @include f-24;

            &_component {

                &:last-child {
                    margin: 0 0 0 10px;
                }
            }
        }
    }
}

//--------------
//モーダル関連
//--------------
#no_item_overlay{
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

#no_item_modal_content{
  z-index:2;
  width:50%;
  padding: 1em;
  background:#fff;
  border-radius: 20px;

  @include tb {
    width: 80%;
  }
}

.no_item_modal_content {

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

    &_button {
        display: flex;
        justify-content: flex-end;
        margin: 10px 0 0 0;

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
