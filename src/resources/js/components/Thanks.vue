<template>
  <section class="thanks">
    <h2 class="thanks_title">ご購入ありがとうございます。</h2>
    <div class="thanks_wrap">
        <p class="thanks_wrap_name">{{ ( userInfo || {} ).name }} 様</p>
        <p class="thanks_wrap_word">ご購入ありがとうございます。</p>
        <p class="thanks_wrap_word">領収書をご希望の場合は、お客様ご自身で「お客様マイページ」よりPDFでダウンロードすることができます。</p>
        <!-- <h3 class="thanks_wrap_title">注文内容</h3>
        <ul class="thanks_wrap_list_content">
            <li v-for="ordered_item in ordered_items" :key="ordered_item" class="thanks_wrap_list_content_each">
                <p class="thanks_wrap_list_content_each_title f_40">写真No.000000</p>
                <div class="thanks_wrap_list_content_each_selected">
                    <div class="thanks_wrap_list_content_each_selected_img">
                        <img :src="ordered_item.src" :alt="ordered_item.alt">
                    </div>
                    <div class="thanks_wrap_list_content_each_selected_detail">
                        <p class="thanks_wrap_list_content_each_selected_detail_word f_36">¥0000</p>
                        <p class="thanks_wrap_list_content_each_selected_detail_word f_24">画像サイズ：0000 × 0000px</p>
                        <p class="thanks_wrap_list_content_each_selected_detail_word f_24">画像形式：JPEG</p>
                    </div>
                </div>
            </li>
        </ul> -->
    </div>
    <div class="thanks_button">
        <router-link to="/gallery">
            <ButtonBlack class="thanks_button_component">購入を続ける</ButtonBlack>
        </router-link>
        <router-link to="/mypage">
            <ButtonWhite class="thanks_button_component">マイページトップへ戻る</ButtonWhite>
        </router-link>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { storeToRefs } from "pinia";
import ButtonWhite from "./common/ButtonWhite.vue";
import ButtonBlack from "./common/ButtonBlack.vue";
import { useRoute, useRouter } from 'vue-router';
import { thanksItems } from '../../../store/thanks';
import { auth } from '../../../store/auth';

export default defineComponent({
    name: 'Photo',
    components: {
        ButtonWhite,
        ButtonBlack,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const ordered_items = thanksItems().ordered_imgs;
        const { userInfo } = storeToRefs(auth());

        // methods

        onMounted(() => {

        })

        return { router, route, ordered_items, userInfo }
    },

});
</script>

<style lang="scss" scoped>
@import "../../sass/prepends.scss";
.thanks {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    @include sm {
        padding: 107px 10% 100px 10%;
    }

    &_title {
        // font-size: 48px;
        @include f-80;

        @include tb {
            font-size: 36px
        }
    }

    &_wrap{

        &_name {
            // font-size: 36px;
            @include f-36;
            padding: 18.5px 0 18.5px 0;
        }

        &_word {
            font-size: 24px;
        }

        &_title {
            // font-size: 36px;
            @include f-36;
            color: #ffffff;
            background-color: #000000;
            padding: 18.5px 0 18.5px 10px;
            margin: 20px 0 0 0;
        }

        &_list {
            width: 60%;

            &_title {
                background-color: #000000;
                color: #ffffff;
                font-size: 18px;
                padding: 18.5px 0 18.5px 10px;
            }

            &_content {
                width: 100%;
                list-style-type: none;
                margin: 50px 0 0 0;

                &_each {
                    width: 100%;

                    &_title {
                        margin: 0 0 10px 0;
                    }

                    &:not(:last-child) {
                        padding: 0 0 10px 0;
                    }

                    &_selected {
                        display: flex;
                        justify-content: space-between;
                        width: 100%;

                        &_img {
                            width: 40%;

                            img {
                                width:100%;
                                height:auto;
                            }
                        }

                        &_detail {
                            width: 55%;
                            margin: 0 0 0 5%;

                            &_word {
                                margin: 0 0 10px 0;
                            }
                        }
                    }
                }
            }
        }
    }

    &_button {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 100px 0 0 0;
        @include f-30;

        @include tb {
            flex-direction: column;
        }

        :last-child {
            margin: 0 0 0 10px;

            @include tb {
                margin: 10px 0 0 0;
            }
        }
    }
}

.f_40 {
    // font-size: 40px;
    @include f-40;
}

.f_36 {
    // font-size: 36px;
    @include f-36;
}

.f_24 {
    // font-size: 24px;
    @include f-24;
}

</style>
