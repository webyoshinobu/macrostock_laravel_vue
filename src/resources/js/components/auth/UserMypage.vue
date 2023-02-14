<template>
    <section class="usermypage">
        <h2 class="usermypage_title">様マイページ</h2>
    </section>
</template>

<script lang="ts">
import { defineComponent, ref, computed, onMounted, reactive, watch, nextTick } from "vue"
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'
import { auth } from '../../../../store/auth'
import ButtonWhite from "../common/ButtonWhite.vue"
import ButtonBlack from "../common/ButtonBlack.vue"
import Message from "../Message.vue"
import Loader from "../Loader.vue"
import axios from "axios";
import { CREATED, UNPROCESSABLE_ENTITY } from '../../util'
import { error } from '../../../../store/error'
import { message } from '../../../../store/message'

export default defineComponent({
    name: 'UserMypage',
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


        onMounted(() => {

        });

        return { router, route, onMounted, watch };
    },

});
</script>

<style lang="scss" scoped>
.usermypage {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    &_title {
        font-size: 70px;
        margin-bottom: 50px;
    }
}

.errors {
    margin: 0 0 20px 0;

    ul {
        list-style: none;
        font-size: 24px;
        color: red;
        font-weight: bold;
    }
}

</style>
