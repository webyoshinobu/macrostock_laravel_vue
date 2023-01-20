<template>
  <section class="top">
    <p class="top_site_title wd_color_white">MacroStock</p>
    <p class="top_sub_site_title wd_color_white">マクロ写真専門ストックフォトサイト</p>
    <button class="top_what_macro_photo wd_color_white" v-on:click="openModal">マクロ写真とは？</button>

    <!-- モーダル -->
    <transition name="modal">
        <div id="top_overlay" v-show="whats_macro_photo">
            <div class="top_modal_content" id="top_modal_content">
                <h2>マクロ写真とは？</h2>
                <p class="top_modal_content_word">植物や虫などの小さい物をカメラの機能を使って一枚の写真に大きく写し出す写真のことです。</p>
                <p class="top_modal_content_word">接写で被写体に近づくことで、いつもは見逃してしまうような小さい部分の輝きや面白さを表した写真を撮ることができます。</p>
                <p class="top_modal_content_word">いわゆる接写の同義語になります。</p>
                <p class="top_modal_content_word">MacroStockはマクロ写真を専門にしたストックフォトサイトです。</p>
                <p class="top_modal_content_word">ぜひ、マクロの世界を楽しんでみてください。</p>
                <p class="top_modal_content_button">
                    <ButtonGreen @click="closeModal">Close</ButtonGreen>
                </p>
            </div>
        </div>
    </transition>

  </section>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import ButtonGreen from "./common/ButtonGreen.vue";
// import { Swiper, SwiperSlide } from 'vue-awesome-swiper';
// import 'swiper/swiper-bundle.css';
// import { Swiper, SwiperSlide } from 'swiper/vue';
import Swiper, { Navigation, Pagination, Autoplay } from 'swiper'
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default defineComponent({
    name: 'Top',
    components: {
        ButtonGreen,
        Swiper,
        // SwiperSlide,
    },

    setup() {
        // data
        const whats_macro_photo = ref(false);

        // methods
        const openModal = () => {
            whats_macro_photo.value = true;
        }
        const closeModal = () => {
            whats_macro_photo.value = false;
        }

        return { whats_macro_photo, openModal, closeModal };
    }

});
</script>

<style lang="scss" scoped>
.top {
    width: 100%;
    height: 100vh;
    background-image: url('../../../public/images/top_slide1.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-flow: column;
}

.top_site_title {
    font-size: 144px;
}

.top_sub_site_title {
    font-size: 48px;
}

.top_what_macro_photo {
    background-color: #F87D09;
    border-radius: 20px;
    border: none;
    outline: none;
    padding: 13px 50px;
    margin-top: 50px;
    font-size: 36px;
    cursor: pointer;
}

#top_overlay{
  /*　要素を重ねた時の順番　*/
  z-index:1;

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

#top_modal_content{
  z-index:2;
  width:50%;
  padding: 1em;
  background:#fff;
  border-radius: 20px;
}

.top_modal_content {

    h2 {
        font-size: 36px;
        margin: 20px 0;
    }

    &_word {
        font-size: 24px;
        text-align: left;
    }

    &_button {
        display: flex;
        justify-content: flex-end;

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

.wd_color_white {
    color: #ffffff;
    font-weight: bold;
}
</style>
