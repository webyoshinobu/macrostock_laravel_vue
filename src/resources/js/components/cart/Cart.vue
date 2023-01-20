<template>
  <section class="cart">
    <h2 class="cart_title">Cart</h2>
    <div class="cart_wrap">
        <div class="cart_wrap_list">
            <div class="cart_wrap_list_title">0個の素材がカートに入っています。</div>
            <ul class="cart_wrap_list_content">
                <li v-for="item in items" :key="item" class="cart_wrap_list_content_each">
                    <p class="cart_wrap_list_content_each_title f_40">写真No.000000</p>
                    <div class="cart_wrap_list_content_each_selected">
                        <div class="cart_wrap_list_content_each_selected_img">
                            <img :src="item.src" :alt="item.alt">
                        </div>
                        <div class="cart_wrap_list_content_each_selected_detail">
                            <p class="cart_wrap_list_content_each_selected_detail_word f_36">¥0000</p>
                            <p class="cart_wrap_list_content_each_selected_detail_word f_24">画像サイズ：0000 × 0000px</p>
                            <p class="cart_wrap_list_content_each_selected_detail_word f_24">画像形式：JPEG</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <aside class="cart_wrap_aside">
            <div class="cart_wrap_aside_amount">
                <p class="cart_wrap_aside_amount_title">合計金額：</p>
                <p class="cart_wrap_aside_amount_price"><span>￥</span>00000</p>
            </div>
            <CartLoginAside />
        </aside>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { storeToRefs } from 'pinia';
import { cartCounter } from '../../../../store/cart';
import ButtonOrange from "../common/ButtonOrange.vue";
import CartLoginAside from "./CartLoginAside.vue";
export default defineComponent({
    name: 'Cart',
    components: {
        ButtonOrange,
        CartLoginAside,
    },

    setup() {
        // data
        // const { items } = storeToRefs(cartCounter());
        const items = cartCounter().items;

        // methods

        return { items }
    },

});
</script>

<style lang="scss" scoped>
.cart {
    width: 80%;
    padding: 170px 10% 0 10%;

    &_title {
        font-size: 70px;
        margin-bottom: 20px;
    }

    &_wrap{
        display: flex;
        justify-content: space-between;

        &_list {
            width: 60%;

            &_title {
                background-color: #000000;
                color: #ffffff;
                font-size: 36px;
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

        &_aside {
            width: 35%;
            padding: 0 0 0 5%;

            &_amount{
                width: 100%;
                display: flex;
                justify-content: space-between;
                font-weight: bold;
                border-bottom: 2px solid #000000;

                &_title {
                    width: 30%;
                    font-size: 24px;
                    display: flex;
                    align-items: center;
                }

                &_price {
                    width: 70%;
                    font-size: 48px;
                    display: flex;
                    justify-content: flex-end;
                    align-items: center;
                }
            }
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
