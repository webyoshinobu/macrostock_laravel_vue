<template>
  <section class="logined">
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

export default defineComponent({
    name: 'CartLoginAside',
    components: {
        ButtonOrange,
        ButtonWhite,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const { totalPrice } = storeToRefs(cartCounter());

        // methods
        const download = async() => {
            const downloadItems = cartCounter().items;
            console.log('CartLoginAside.vue download downloadItems', downloadItems);

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

            //Thanksページへ移動
            router.push({ name: 'thanks'})

        }

        const registerOrderData = async(downloadItems:any) => {
            const orderData = {
                user_id: auth().userInfo!.id,
                order_total_amount: Math.floor(totalPrice.value * 1.1),
                order_total_number: downloadItems.length,
            }

            console.log('CartLoginAside.vue download userInfo.id',auth().userInfo!.id)
            console.log('CartLoginAside.vue download totalPrice', totalPrice.value)
            console.log('CartLoginAside.vue download downloadItems.length', downloadItems.length)
            console.log('CartLoginAside.vue download orderData', orderData)


            //注文履歴を残す
            //orderテーブルに情報を登録する。このidを取得して、order_detailのorder_idとして登録する
            const orderDataResponse = await cartCounter().makeOrder(orderData)
            //order_idを追加してorder_detailテーブルに追加する
            console.log('CartLoginAside.vue download makeOrder orderDataResponse.data', orderDataResponse)

            for(let i=0; i<downloadItems.length; i++) {
                downloadItems[i]['order_id'] = orderDataResponse['uuid']
                downloadItems[i]['order_total_number'] = Number(1)
            }
            const orderDetails = downloadItems
            console.log('CartLoginAside.vue download downloadItems order_id追加', downloadItems)
            console.log('CartLoginAside.vue download orderDetails', orderDetails)
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

        return { router, route, download, getFileName, registerOrderData }
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

</style>
