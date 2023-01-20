<template>
  <div>
    <Header />
    <router-view></router-view>
    <Footer />
  </div>
</template>

<script lang="ts">
import 'normalize.css';
// import { createApp, ref } from "vue";
// import { defineComponent } from "vue";
import Vue from "vue";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import axios from 'axios';
import VueAxios from 'vue-axios';

export default {
  components: {
    Header,
    Footer,
  }
};
</script>

<style>
* {
    padding: 0;
    margin: 0;
}
</style>
