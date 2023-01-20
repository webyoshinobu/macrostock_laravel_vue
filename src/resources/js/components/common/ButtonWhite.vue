<template>
  <button class="button-white">
    <slot/>
  </button>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted } from "vue";
    import { useRoute, useRouter } from 'vue-router';
    import router from '../../router'
    export default defineComponent({
        name: 'ButtonWhite',
        components: {

        },
    });
</script>

<style lang="scss" scoped>
.button-white {
    background-color: #ffffff;
    color: #000000;
    font-weight: bold;
    border: 1px solid #000000;
    border-radius: 20px;
    padding: 22px 68px;
    outline: none;
}
</style>
