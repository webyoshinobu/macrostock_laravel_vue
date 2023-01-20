<template>
  <section class="logined">
    <h2 class="logined_title">購入</h2>
    <div class="logined_detail">
        <p class="logined_detail_word">「購入する」ボタンを押すと写真がダウンロードされ、購入完了画面へ遷移します。</p>
        <div class="logined_detail_button">
            <router-link to="/gallery">
                <ButtonWhite class="logined_detail_button_component">Galleryへ</ButtonWhite>
            </router-link>
            <router-link to="/thanks">
                <ButtonOrange class="logined_detail_button_component">購入する</ButtonOrange>
            </router-link>
        </div>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import ButtonOrange from "../common/ButtonOrange.vue";
import ButtonWhite from "../common/ButtonWhite.vue";
import { useRoute, useRouter } from 'vue-router';

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


        return { router, route }
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
