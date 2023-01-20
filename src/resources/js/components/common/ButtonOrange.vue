<template>
  <button class="button-orange">
    <slot/>
  </button>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted } from "vue";
    import { useRoute, useRouter } from 'vue-router';
    import router from '../../router'
    export default defineComponent({
        name: 'ButtonOrange',
        components: {

        },
    });
</script>

<style lang="scss" scoped>
    .button-orange {
        background-color: #F87D09;
        color: #ffffff;
        font-weight: bold;
        border-radius: 20px;
        padding: 22px 68px;
        border: none;
        outline: none;
    }
</style>
