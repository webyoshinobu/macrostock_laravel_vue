<template>
  <section class="thanks">
    <h2 class="thanks_title">ご購入ありがとうございます。</h2>
    <div class="thanks_wrap">
        <p class="thanks_wrap_name">〇〇 〇〇 様</p>
        <p class="thanks_wrap_word">ご購入ありがとうございます。</p>
        <p class="thanks_wrap_word">領収書をご希望の場合は、お客様ご自身で「お客様ページ」より印刷することができます。</p>
        <h3 class="thanks_wrap_title">注文内容</h3>
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
        </ul>
    </div>
    <div class="thanks_button">
        <router-link to="/gallery">
            <ButtonBlack class="thanks_button_component">購入を続ける</ButtonBlack>
        </router-link>
        <router-link to="/">
            <ButtonOrange class="thanks_button_component">トップへ戻る</ButtonOrange>
        </router-link>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import ButtonOrange from "./common/ButtonOrange.vue";
import ButtonBlack from "./common/ButtonBlack.vue";
import { useRoute, useRouter } from 'vue-router';
import { thanksItems } from '../../../store/thanks';

export default defineComponent({
    name: 'Photo',
    components: {
        ButtonOrange,
        ButtonBlack,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const ordered_items = thanksItems().ordered_imgs;

        // methods

        onMounted(() => {

        })

        return { router, route, ordered_items }
    },

});
</script>

<style lang="scss" scoped>
.thanks {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    &_title {
        font-size: 48px;
    }

    &_wrap{

        &_name {
            font-size: 36px;
            padding: 18.5px 0 18.5px 0;
        }

        &_word {
            font-size: 24px;
        }

        &_title {
            font-size: 36px;
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

        :last-child {
            margin: 0 0 0 10px;
        }
    }
}

.f_40 {
    font-size: 40px;
}

.f_36 {
    font-size: 36px;
}

.f_24 {
    font-size: 24px;
}

</style>
