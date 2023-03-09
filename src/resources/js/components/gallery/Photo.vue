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

    <!-- 管理者で「カートに追加」を押下場合のモーダル -->
    <transition name="modal">
        <div id="photo_overlay" v-show="caution_to_admin">
            <div class="photo_modal_content" id="photo_modal_content">
                <h2>管理者でログイン中の場合</h2>
                <p class="photo_modal_content_word">管理者でログイン中の場合、画像を購入できません。</p>
                <p class="photo_modal_content_word">お客様用アカウントを作成してください。</p>
                <div class="photo_modal_content_button">
                    <ButtonGreen @click="closeModal">Close</ButtonGreen>
                </div>
            </div>
        </div>
    </transition>
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
import ButtonGreen from "../common/ButtonGreen.vue";

export default defineComponent({
    name: 'Photo',
    components: {
        ButtonOrange,
        ButtonGreen,
        Term,
    },

    setup() {
        // data
        let term = ref();
        const router = useRouter();
        const route = useRoute();
        const image = route.params;
        const { isLoggedIn, adminFlag } = storeToRefs(auth());
        const { product_imgs } = storeToRefs(galleryImgs());
        const { addCart } = cartCounter();
        const tax = 1.1
        const caution_to_admin = ref(false);

        // methods
        // 利用規約用モーダル
        const termOpen = () => {
            term.value.openModal(); //子コンポーネント(term)の呼び出し
        }

        // 管理者で「カートに追加」を押下場合のモーダル
        const openModal = () => {
            caution_to_admin.value = true;
        }
        const closeModal = () => {
            caution_to_admin.value = false;
        }

        const toCart = (image:any) => {
            if(auth().adminFlag == null){
                if(auth().isLoggedIn == true){
                    addCart(image);
                    router.push( {name: 'cart'} );
                }else{
                    router.push( {name: 'login'} );
                }
            }else{
                openModal()
                // router.push( {name: 'top'} );
            }

        }

        const pricePrefix = (price:number) => {
            price = price * tax
            return Number(price).toLocaleString('ja')
        }

        onMounted(() => {

        })

        return { term, router, route, image, termOpen, addCart, toCart, pricePrefix, openModal, closeModal, caution_to_admin }
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
// -------------------------------------
// 管理者で「カートに追加」を押下場合のモーダル
//--------------------------------------
#photo_overlay{
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

#photo_modal_content{
  z-index:2;
  width:50%;
  padding: 1em;
  background:#fff;
  border-radius: 20px;

  @include tb {
    width: 80%;
  }
}

.photo_modal_content {

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
