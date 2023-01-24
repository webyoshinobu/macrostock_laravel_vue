<template>
  <div>
    <Header />
    <router-view></router-view>
    <Footer />
  </div>
</template>

<script lang="ts">
import 'normalize.css';
import { onMounted } from "vue";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";

export default {
  components: {
    Header,
    Footer,
  },

  setup() {

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
