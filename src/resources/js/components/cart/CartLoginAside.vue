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

        // methods
        const download = async() => {
            const downloadItems = cartCounter().items;
            console.log('CartLoginAside.vue download downloadItems', downloadItems);

            // const response = await axios.get('api/photos/zipDownLoad');
            // console.log('CartLoginAside.vue download response', response);

            await axios.get('api/photos/zipDownLoad', { responseType: "blob", })
            .then((response)=>{
                let mineType = response.headers["content-type"];
                const name = response.headers["content-disposition"];
                const blob = new Blob([response.data], { type: mineType });
                saveAs(blob, name);
            })
            .catch((error) => {
                console.log(error.messagae);
            });

        }

        return { router, route, download }
    },

});
</script>

<style lang="scss" scoped>
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
            font-size: 24px;

            &_component {

                &:last-child {
                    margin: 0 0 0 10px;
                }
            }
        }
    }
}

</style>
