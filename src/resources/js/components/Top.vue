<template>
  <section class="top">

    <Indicator :isLoading="isLoading"></Indicator>

    <!-- <div class="story-visuals"> -->
        <swiper
        :modules="modules"
        :autoplay="{ loop: true }"
        :effect="'coverflow'"
        @swiper="onSwiper"
        @slideChange="onSlideChange"
        >
        <!-- <swiperSlide v-for="(image, index) in images" :key="`slide-${index}`">
            <img :src="image" />
        </swiperSlide> -->
        <swiper-slide><img src="../../../public/images/top_slide1.jpg" ></swiper-slide>
        <swiper-slide><img src="../../../public/images/top_slide2.jpg" ></swiper-slide>
        <swiper-slide><img src="../../../public/images/top_slide3.jpg" ></swiper-slide>
        </swiper>
    <!-- </div> -->

    <section class="top_content">
        <p class="top_site_title wd_color_white">MacroStock</p>
        <p class="top_sub_site_title wd_color_white">マクロ写真専門ストックフォトサイト</p>
        <button class="top_what_macro_photo wd_color_white" v-on:click="openModal">マクロ写真とは？</button>
    </section>

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
                <div class="top_modal_content_button">
                    <ButtonGreen @click="closeModal">Close</ButtonGreen>
                </div>
            </div>
        </div>
    </transition>

  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onUpdated, onMounted } from "vue";
import ButtonGreen from "./common/ButtonGreen.vue";
import Indicator from '../Indicator.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, A11y, EffectCoverflow, EffectCube } from 'swiper';
import 'swiper/css';
import 'swiper/css/bundle';
// import 'swiper/css/navigation';
// import 'swiper/css/pagination';
// import 'swiper/css/autoplay';

export default defineComponent({
    name: 'Top',
    components: {
        ButtonGreen,
        Indicator,
        Swiper,
        SwiperSlide,
    },

    setup() {
        // data
        const whats_macro_photo = ref(false);
        let isLoading = ref(true)
        const images = [
            '../../public/images/top_slide1.jpg',
            '../../public/images/top_slide2.jpg',
            '../../public/images/top_slide3.jpg',
        ];

        // methods
        const openModal = () => {
            whats_macro_photo.value = true;
        }
        const closeModal = () => {
            whats_macro_photo.value = false;
        }

        // Swiperのインスタンスが返ってくる
        const onSwiper = (swiper:any) => {
            console.log('swiper', swiper);
        };
        // スライド位置が変更された時に呼ばれる
        const onSlideChange = () => {
            console.log('slide change');
        };

        onMounted(() => {
            isLoading.value = false
        })

        // onUpdated(() => {
        //     isLoading.value = false
        //     // console.log("on update", isLoading.value)
        // })

        return { whats_macro_photo, openModal, closeModal, isLoading, onSwiper, onSlideChange, images, modules: [Autoplay, A11y, EffectCoverflow], };
    }

});
</script>

<style lang="scss" scoped>
@import "../../sass/prepends.scss";
.top {
    width: 100%;
    height: 100vh;
    // background-image: url('../../../public/images/top_slide1.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-flow: column;

    &_content {
        position: relative;
        top: 0;
        left: 0;
        z-index: 2;
    }
}

.top_site_title {
    // font-size: 144px;
    // font-size: clamp(2.5rem, 4vw + 1.75rem, 9rem);
    @include f-144;
}

.top_sub_site_title {
    // font-size: 48px;
    @include f-48;
}

.top_what_macro_photo {
    background-color: #F87D09;
    border-radius: 20px;
    border: none;
    outline: none;
    padding: 13px 50px;
    margin-top: 50px;
    // font-size: 36px;
    @include f-36;
    cursor: pointer;

    @include tb {
        margin-top: 30px;
    }
}

//--------------
//モーダル関連
//--------------
#top_overlay{
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

#top_modal_content{
  z-index:2;
  width:50%;
  padding: 1em;
  background:#fff;
  border-radius: 20px;

  @include tb {
    width: 80%;
  }
}

.top_modal_content {

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

.wd_color_white {
    color: #ffffff;
    font-weight: bold;
}

//-------------
// swiper.js
//-------------
.swiper {
    width: 100%;
    height: 100vh;
    position: absolute;
    top: 0;
    left: 0;
    background-color: #000000;

    &-wrapper {
        height: auto;
    }

    &-slide {
        height: auto;

        img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }
    }
}
</style>
