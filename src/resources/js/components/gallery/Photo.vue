<template>
  <section class="photo">
    <h2 class="photo_title">写真No.000000</h2>
    <div class="photo_wrap">
        <figure class="photo_wrap_img">
            <img :src="image.src" :alt="image.alt">
        </figure>
        <aside class="photo_wrap_aside">
            <p class="photo_wrap_aside_word">画像サイズ：0000 × 0000px</p>
            <p class="photo_wrap_aside_word">画像形式：JPEG</p>
            <p class="photo_wrap_aside_word">価格：¥0000</p>
            <p class="photo_wrap_aside_button"><ButtonOrange @click="toCart(image)">カートに追加する</ButtonOrange></p>
            <p ref="term" @click="termOpen" class="photo_wrap_aside_term">利用可能な用途と禁止事項について</p>
        </aside>
        <!-- <p>カウント:{{ counter.count }}</p> -->
    </div>
    <!-- モーダルでTermで表示 -->
    <Term ref="term" />
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { storeToRefs } from 'pinia';
import ButtonOrange from "../common/ButtonOrange.vue";
import Term from "../term.vue";
import { useRoute, useRouter } from 'vue-router';
import { cartCounter } from '../../../../store/cart';
import { galleryImgs } from '../../../../store/gallery';

export default defineComponent({
    name: 'Photo',
    components: {
        ButtonOrange,
        Term,
    },

    setup() {
        // data
        let term = ref();
        const router = useRouter();
        const route = useRoute();
        const image = route.params;
        const { product_imgs } = storeToRefs(galleryImgs());
        const { addCart } = cartCounter();

        // methods
        const termOpen = () => {
            term.value.openModal(); //子コンポーネント(term)の呼び出し
        }

        const toCart = (image:any) => {
            addCart(image);
            router.push( {name: 'cart'} );
        }

        onMounted(() => {

        })

        return { term, router, route, image, termOpen, addCart, toCart }
    },

});
</script>

<style lang="scss" scoped>
.photo {
    width: 80%;
    padding: 170px 10% 0 10%;

    &_title {
        font-size: 70px;
        margin-bottom: 20px;
    }

    &_wrap{
        display: flex;
        justify-content: space-between;

        &_img {
            width: 60%;

            img {
                width: 100%;
            }
        }

        &_aside {
            width: 35%;
            padding: 0 0 0 5%;

            &_word {
                font-size: 36px;
                font-weight: bold;
                padding-bottom: 20px;
            }

            &_button {
                font-size: 30px;
            }

            &_term {
                font-size: 24px;
                padding-top: 10px;
                text-decoration:underline;
            }
        }
    }

}

</style>
