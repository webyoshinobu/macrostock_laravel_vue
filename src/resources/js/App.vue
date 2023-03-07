<template>
  <div>
    <Header />
    <router-view></router-view>
    <Footer />
  </div>
</template>

<script lang="ts">
import 'normalize.css';
import { onMounted, watch } from "vue";
import { useRoute, useRouter } from 'vue-router';
import { storeToRefs } from 'pinia';
import axios from "axios"
import { auth } from '../../store/auth';
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import { error } from "../../store/error";
import { NOT_FOUND, UNAUTHORIZED, INTERNAL_SERVER_ERROR } from './util'

export default {
  components: {
    Header,
    Footer,
  },

  setup() {
    const router = useRouter();
    const route = useRoute();
    const { code } = storeToRefs(error());
    const errorCode = code
    const authStore = auth();

    watch(errorCode, async(errorCode:any, val:any) => {
        console.log('errorCode', errorCode)
        if (errorCode === INTERNAL_SERVER_ERROR) {
            router.push({ name: '500' })
        }else if (val === UNAUTHORIZED) {
            // トークンをリフレッシュ
            await axios.get('/api/refresh-token')
            // ストアのuserをクリア
            // this.$store.commit('auth/setUser', null)
            authStore.setAuth(null);
            // ログイン画面へ
            router.push({ name: 'login' })
        }else if (val === NOT_FOUND) {
            router.push({ name: 'NotFound' })
        }
    }, {
        immediate: true
    })

    onMounted(() => {

    });

    return { onMounted };
  }
};
</script>

<style lang="scss">
* {
    padding: 0;
    margin: 0;
}
// img {
//   pointer-events: none;
// }
</style>
