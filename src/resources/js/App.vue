<template>
  <div>
    <Message />
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
import Message from "./components/Message.vue"
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import { error } from "../../store/error";
import { INTERNAL_SERVER_ERROR } from './util'

export default {
  components: {
    Header,
    Footer,
    Message,
  },

  setup() {
    const router = useRouter();
    const route = useRoute();
    const { code } = storeToRefs(error());
    const errorCode = code

    watch(errorCode, (errorCode:any) => {
        console.log('errorCode', errorCode)
        if (errorCode === INTERNAL_SERVER_ERROR) {
            router.push({ name: '500' })
        }
    })

    onMounted(() => {

    });

    return { onMounted };
  }
};
</script>

<style>
* {
    padding: 0;
    margin: 0;
}
</style>
