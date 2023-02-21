<template>
    <section class="userorderhistory">
        <h2 class="userorderhistory_title">{{ ( userInfo || {} ).name }}様マイページ</h2>
        <div class="userorderhistory_wrap">
            <div class="userorderhistory_wrap_title">注文履歴一覧</div>
            <div class="userorderhistory_wrap_content">
                <div class="userorderhistory_wrap_content_header">
                    <h3 class="userorderhistory_wrap_content_header_title">ご注文日時</h3>
                    <h3 class="userorderhistory_wrap_content_header_title">注文No.</h3>
                    <h3 class="userorderhistory_wrap_content_header_title">合計金額</h3>
                </div>
                <div class="userorderhistory_wrap_content_body">
                    <!-- <ul class="userorderhistory_wrap_content_body_list">
                        <li class="userorderhistory_wrap_content_body_list_item">
                            <p class="userorderhistory_wrap_content_body_list_item_p">0000/00/00</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">No.00000</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">00000円</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">
                                <button>領収書発行</button>
                            </p>
                        </li>
                        <li class="userorderhistory_wrap_content_body_list_item">
                            <p class="userorderhistory_wrap_content_body_list_item_p">0000/00/00</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">No.00000</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">00000円</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">
                                <button>領収書発行</button>
                            </p>
                        </li>
                        <li class="userorderhistory_wrap_content_body_list_item">
                            <p class="userorderhistory_wrap_content_body_list_item_p">0000/00/00</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">No.00000</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">00000円</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">
                                <button>領収書発行</button>
                            </p>
                        </li>
                    </ul> -->
                    <ul class="userorderhistory_wrap_content_body_list">
                        <li class="userorderhistory_wrap_content_body_list_item" v-for="data in groupedData" :key="data">
                            <p class="userorderhistory_wrap_content_body_list_item_p">{{ orderDateFormat(data[0].created_at) }}</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">{{ data[0].uuid }}</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">{{ data[0].order_total_amount }}円</p>
                            <p class="userorderhistory_wrap_content_body_list_item_p">
                                <button>領収書発行</button>
                            </p>
                        </li>
                    </ul>
                </div>

                <div class="userorderhistory_wrap_content_button">
                    <!-- <ButtonBlack>注文履歴</ButtonBlack> -->
                    <router-link to="/mypage"><ButtonWhite class="margin-left">マイページトップへ戻る</ButtonWhite></router-link>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent, onMounted, watch, ref, computed } from "vue"
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'
import { auth } from '../../../../store/auth'
import ButtonBlack from "../common/ButtonOrange.vue"
import ButtonWhite from "../common/ButtonWhite.vue"
import Message from "../Message.vue"
import Loader from "../Loader.vue"
import axios from "axios";
import { CREATED, UNPROCESSABLE_ENTITY } from '../../util'
import { error } from '../../../../store/error'
import { message } from '../../../../store/message'
import { order } from '../../../../store/order'
import _ from 'lodash'

export default defineComponent({
    name: 'UserOrderHistory',
    components: {
        ButtonWhite,
        ButtonBlack,
        Loader,
        Message,
    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();
        const authStore = auth();
        const {  } = authStore;
        const { userInfo } = storeToRefs(authStore);
        const data = userInfo.value;
        const order_history = order().order_history;
        // let groupedData:any = []
        let groupedData = ref<any>([])

        const groupByOrderHistory = (data:any) => {
            console.log('UserOrderHistory.vue groupByOrderHistory()')
            console.log('UserOrderHistory.vue groupByOrderHistory() data', data)
            // const groupedData = _.groupBy(data, 'uuid')
            // groupedData = _.groupBy(data, 'uuid')
            groupedData.value = Object.values(_.groupBy(data, 'uuid'))
            console.log('UserOrderHistory.vue groupByOrderHistory() groupedData', groupedData.value)

        }

        const orderDateFormat = (date:Date) => {
            let date_obj = new Date(date);
            let order_year  = date_obj.getFullYear(); // 西暦年取得
            let order_month = date_obj.getMonth();    // 月取得
            let order_day   = date_obj.getDate();     // 日取得
            // 文字列として連結
            let format_date = ('0000' + order_year).slice(-4)
            + '/'
            + ('00' + (order_month + 1)).slice(-2)
            + '/'
            + ('00' + order_day).slice(-2);
            console.log('UserOrderHistory.vue orderDateFormat', format_date)
            return format_date
        }

        onMounted(async() => {
            console.log('UserOrderHistory.vue data', data)
            const response = await order().orderHistory(data)
            await groupByOrderHistory(response)
        });

        return { router, route, onMounted, watch, userInfo, groupByOrderHistory, groupedData, orderDateFormat };
    },

});
</script>

<style lang="scss" scoped>
.userorderhistory {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    &_title {
        font-size: 70px;
        margin-bottom: 50px;
    }

    &_wrap{

        &_title {
            background-color: #000000;
            color: #ffffff;
            font-size: 36px;
            font-weight: bold;
            padding: 18.5px 0 18.5px 10px;
        }

        &_content {
            border: 2px solid #000000;
            padding: 20px;
            font-size: 36px;

            &_header {
                display: flex;
                font-size: 24px;
                background-color: #F2F0ED;
                padding: 20px 0;

                &_title {
                    width: 25%;
                    text-align: center;
                }
            }

            &_body {
                font-size: 24px;

                &_list {
                    list-style-type: none;

                    &_item {
                        display: flex;
                        margin: 20px 0;

                        &_p {
                            width: 25%;
                            display: flex;
                            justify-content: center;
                            align-items: center;

                            button {
                                border-radius: 10px;
                                padding: 10px;
                            }
                        }
                    }
                }
            }


            &_button {
                display: flex;
                justify-content: center;
            }
        }
    }
}

.margin-left {
    margin: 0 0 0 10px;
}

.errors {
    margin: 0 0 20px 0;
    font-size: 24px;
    color: red;
    font-weight: bold;

    ul {
        list-style: none;
    }
}

</style>
