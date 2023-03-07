<template>
  <button class="button-black">
    <slot/>
  </button>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted } from "vue";
    import { useRoute, useRouter } from 'vue-router';
    import router from '../../router'
    export default defineComponent({
        name: 'ButtonBlack',
        components: {

        },
    });
</script>

<style lang="scss" scoped>
.button-black {
    background-color: #000000;
    color: #ffffff;
    font-weight: bold;
    border-radius: 20px;
    // padding: 22px 68px;
    padding: 22px 10px;
    border: none;
    outline: none;
    cursor: pointer;
}
</style>
