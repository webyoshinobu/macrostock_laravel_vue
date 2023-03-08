<template>
  <section class="cart">
    <h2 class="cart_title">Cart</h2>
    <div class="cart_wrap">
        <div class="cart_wrap_list">
            <div v-if="items.length > 0" class="cart_wrap_list_title">{{ items.length }}個の素材がカートに入っています。</div>
            <div v-else class="cart_wrap_list_title">カートは空です。</div>
            <ul class="cart_wrap_list_content">
                <li v-for="item in items" :key="item" class="cart_wrap_list_content_each">
                    <p class="cart_wrap_list_content_each_title f_40">写真ID: {{ item.id }}</p>
                    <div class="cart_wrap_list_content_each_selected">
                        <div class="cart_wrap_list_content_each_selected_img">
                            <img :src="item.url" :alt="`Photo by ${item.owner.name}`" oncontextmenu="return false;" onselectstart="return false;" onmousedown="return false;">
                        </div>
                        <div class="cart_wrap_list_content_each_selected_detail">
                            <!-- <p class="cart_wrap_list_content_each_selected_detail_word f_36">¥{{ item.price }}</p> -->
                            <p class="cart_wrap_list_content_each_selected_detail_word f_36">¥{{ pricePrefix(item.price) }}</p>
                            <!-- <p class="cart_wrap_list_content_each_selected_detail_word f_24">画像サイズ：0000 × 0000px</p> -->
                            <p class="cart_wrap_list_content_each_selected_detail_word f_24">画像形式：JPEG</p>
                            <button @click="removeImg(item)" class="cart_wrap_list_content_each_selected_detail_word f_24 delete_button">削除</button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <aside class="cart_wrap_aside">
            <div class="cart_wrap_aside_amount">
                <p class="cart_wrap_aside_amount_title">合計金額：</p>
                <p class="cart_wrap_aside_amount_price"><span>￥</span>{{ pricePrefix(cartCounter().totalPrice) }}</p>
            </div>
            <CartLoginAside />
        </aside>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, computed } from "vue";
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
        let { items } = storeToRefs(cartCounter());
        // const items = cartCounter().items;
        // console.log('Cart.vue', items);
        const tax = 1.1

        // methods
        const removeImg = (item:any) => {
            // console.log('Cart.vue removeImg')
            // console.log('Cart.vue item', item)
            cartCounter().removeItem(item)
            // console.log('Cart.vue removeImg', items)
        }

        const pricePrefix = (price:number) => {
            price = price * tax
            return Number(price).toLocaleString()
        }

        return { items, removeImg, pricePrefix, cartCounter }
    },

});
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.cart {
    width: 80%;
    padding: 170px 10% 100px 10%;

    @include sm {
        padding: 107px 10% 100px 10%;
    }

    &_title {
        // font-size: 70px;
        @include f-80;
        margin-bottom: 20px;
    }

    &_wrap{
        display: flex;
        justify-content: space-between;

        @include tb {
            display: block;
        }

        &_list {
            width: 55%;

            @include tb {
                width: 100%;
            }

            &_title {
                background-color: #000000;
                color: #ffffff;
                // font-size: 36px;
                @include f-36;
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
            width: 45%;
            padding: 0 0 0 5%;

            @include tb {
                width: 100%;
                padding: 20px 0 0 0;
            }

            &_amount{
                width: 100%;
                display: flex;
                justify-content: space-between;
                font-weight: bold;
                border-bottom: 2px solid #000000;

                &_title {
                    width: 47%;
                    font-size: 24px;
                    // @include f-24;
                    display: flex;
                    align-items: center;
                }

                &_price {
                    width: 53%;
                    font-size: 48px;
                    // @include f-48;
                    display: flex;
                    justify-content: flex-end;
                    align-items: center;

                    @include md {
                        font-size: 40px;
                    }

                    @include xs {
                        font-size: 30px;
                    }
                }
            }
        }
    }

}

.delete_button {
    border-radius: 10px;
    padding: 10px;
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
