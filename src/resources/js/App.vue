<template>
  <div>
    <Header />
    <router-view></router-view>
    <Footer />
  </div>
</template>

<script lang="ts">
import 'normalize.css';
import { onMounted, computed, watch } from "vue";
import { useRoute, useRouter } from 'vue-router';
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import { error } from "../../store/error";
import { INTERNAL_SERVER_ERROR } from './util'

export default {
  components: {
    Header,
    Footer,
  },

  setup() {
    const router = useRouter();
    const route = useRoute();

    const errorCode = computed(() => {
      return error().code
    })

    watch(() => errorCode, (next, prev) => {
        const handler = (val:any) => {
            if (val === INTERNAL_SERVER_ERROR) {
            router.push('/500')
            }
        };
    },
    {
        immediate: true
    })

    onMounted(() => {

    });

    return { onMounted, errorCode };
  }
};
</script>

<style>
* {
    padding: 0;
    margin: 0;
}
</style>
