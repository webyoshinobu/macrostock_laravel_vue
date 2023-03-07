<template>
  <section class="photo">
    <h2 class="photo_title">写真ID: {{ image.id }}</h2>
    <div class="photo_wrap">
        <figure class="photo_wrap_img">
            <img :src="image.url" :alt="`Photo by ${image.owner.name}`" oncontextmenu="return false;" onselectstart="return false;" onmousedown="return false;">
        </figure>
        <aside class="photo_wrap_aside">
            <!-- <p class="photo_wrap_aside_word">画像サイズ：0000 × 0000px</p> -->
            <p class="photo_wrap_aside_word">画像形式：JPEG</p>
            <p class="photo_wrap_aside_word">価格：¥{{ pricePrefix(image.price) }}</p>
            <p class="photo_wrap_aside_button"><ButtonOrange @click="toCart(image)">カートに追加する</ButtonOrange></p>
            <p ref="term" @click="termOpen" class="photo_wrap_aside_term">利用可能な用途と禁止事項について</p>
        </aside>
    </div>
    <!-- モーダルでTermで表示 -->
    <Term ref="term" />
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, computed } from "vue";
import { storeToRefs } from 'pinia';
import ButtonOrange from "../common/ButtonOrange.vue";
import Term from "../term.vue";
import { useRoute, useRouter } from 'vue-router';
import { auth } from '../../../../store/auth';
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
        const { isLoggedIn } = storeToRefs(auth());
        const { product_imgs } = storeToRefs(galleryImgs());
        const { addCart } = cartCounter();
        const tax = 1.1

        // methods
        const termOpen = () => {
            term.value.openModal(); //子コンポーネント(term)の呼び出し
        }

        const toCart = (image:any) => {
            if(auth().isLoggedIn==true){
                addCart(image);
                router.push( {name: 'cart'} );
            }else{
                router.push( {name: 'login'} );
            }

        }

        const pricePrefix = (price:number) => {
            price = price * tax
            return Number(price).toLocaleString('ja')
        }

        onMounted(() => {

        })

        return { term, router, route, image, termOpen, addCart, toCart, pricePrefix }
    },

});
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.photo {
    width: 80%;
    padding: 170px 10% 100px 10%;

    @include sm {
        padding: 107px 10% 100px 10%;
    }

    &_title {
        // font-size: 70px;
        @include f-80;
        margin-bottom: 20px;
        overflow-wrap: break-word;

        @include sm {
            @include f-33;
        }
    }

    &_wrap{
        display: flex;
        justify-content: space-between;

        @include tb {
            display: block;
        }

        &_img {
            width: 60%;

            @include tb {
                width: 100%;
            }

            img {
                width: 100%;
            }
        }

        &_aside {
            width: 35%;
            padding: 0 0 0 5%;

            @include tb {
                width: 100%;
                padding: 20px 0 0 0;
            }

            &_word {
                // font-size: 36px;
                @include f-30;
                font-weight: bold;
                padding-bottom: 20px;
            }

            &_button {
                // font-size: 30px;
                @include f-30;

                @include tb {
                    display: flex;
                    justify-content: center;
                }
            }

            &_term {
                // font-size: 24px;
                @include f-24;
                padding-top: 10px;
                text-decoration:underline;

                @include tb {
                    display: flex;
                    justify-content: center;
                }
            }
        }
    }

}

</style>
